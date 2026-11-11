<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
    // Admin and Librarian: View all borrowing transactions
    public function index(Request $request)
    {
        $loans = Loan::with(['book', 'borrower'])
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('loans.index', compact('loans'));
    }

    // Admin and Librarian: Create a borrowing transaction
    public function create()
    {
        $books = Book::where('available_copies', '>', 0)
            ->orderBy('title')->get();

        $borrowers = User::where('role', 'student')
            ->orderBy('name')->get();

        return view('loans.create', compact('books', 'borrowers'));
    }

    // Admin and Librarian: Store borrowing transaction
    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id' => 'required|exists:books,id',
            'borrower_id' => 'required|exists:users,id',
            'borrowed_at' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrowed_at',
            'notes' => 'nullable|string|max:500',
        ]);

        $borrower = User::findOrFail($data['borrower_id']);

        if ($borrower->role !== 'student') {
            return back()->withErrors([
                'borrower_id' => 'Select a student borrower.'
            ])->withInput();
        }

        DB::transaction(function () use ($data) {
            $book = Book::whereKey($data['book_id'])
                ->lockForUpdate()->firstOrFail();

            if ($book->available_copies < 1) {
                throw ValidationException::withMessages([
                    'book_id' => 'No available copies remain.'
                ]);
            }

            $book->decrement('available_copies');

            Loan::create($data + [
                'status' => 'borrowed'
            ]);
        });

        return redirect()->route('loans.index')
            ->with('success', 'Borrowing transaction recorded.');
    }

    // Student: Borrow a book
    public function borrow(Book $book)
    {
        if ($book->available_copies < 1) {
            return back()->with('error', 'Sorry, this book is currently unavailable.');
        }

        DB::transaction(function () use ($book) {

            $lockedBook = Book::whereKey($book->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedBook->available_copies < 1) {
                throw ValidationException::withMessages([
                    'book' => 'Sorry, no available copies remain.'
                ]);
            }

            $lockedBook->decrement('available_copies');

            Loan::create([
                'book_id' => $lockedBook->id,
                'borrower_id' => auth()->id(),
                'borrowed_at' => today(),
                'due_date' => today()->addDays(7),
                'status' => 'borrowed',
                'notes' => 'Borrowed by student through Book Catalog.'
            ]);
        });

        return redirect()->route('my-loans')
            ->with('success', 'Book borrowed successfully! Please return it on or before your due date.');
    }

    // Admin and Librarian: Return a book
    public function returnBook(Loan $loan)
    {
        if ($loan->returned_at) {
            return back()->with('error', 'This book has already been returned.');
        }

        DB::transaction(function () use ($loan) {

            $locked = Loan::whereKey($loan->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($locked->returned_at) {
                return;
            }

            $locked->update([
                'returned_at' => today(),
                'status' => 'returned'
            ]);

            $locked->book()->increment('available_copies');
        });

        return back()->with('success', 'Book return recorded and availability updated.');
    }

    // Student: View own borrowing history
    public function myLoans()
    {
        $loans = Loan::with('book')
            ->where('borrower_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view('loans.mine', compact('loans'));
    }
}