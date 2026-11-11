<?php
namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
class DashboardController extends Controller {
    public function __invoke() {
        $user=auth()->user();
        if ($user->role==='student') {
            $loans=Loan::with('book')->where('borrower_id',$user->id)->latest()->take(8)->get();
            return view('dashboard', ['studentLoans'=>$loans]);
        }
        $stats=[
            'books'=>Book::count(),'copies'=>Book::sum('total_copies'),'borrowed'=>Loan::whereNull('returned_at')->count(),
            'overdue'=>Loan::whereNull('returned_at')->whereDate('due_date','<',today())->count(),
            'students'=>User::where('role','student')->count(),'returned'=>Loan::whereNotNull('returned_at')->count()
        ];
        $recent=Loan::with(['book','borrower'])->latest()->take(7)->get();
        return view('dashboard',compact('stats','recent'));
    }
}
