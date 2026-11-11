<?php
namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class BookController extends Controller {
    public function catalog(Request $request) {
        $books=Book::query()->when($request->q,fn($q,$v)=>$q->where(fn($w)=>$w->where('title','like',"%$v%")->orWhere('author','like',"%$v%")->orWhere('isbn','like',"%$v%")))
            ->when($request->category,fn($q,$v)=>$q->where('category',$v))->orderBy('title')->paginate(12)->withQueryString();
        $categories=Book::whereNotNull('category')->distinct()->orderBy('category')->pluck('category');
        return view('catalog',compact('books','categories'));
    }
    public function index(Request $request) {
        $books=Book::when($request->q,fn($q,$v)=>$q->where('title','like',"%$v%")->orWhere('author','like',"%$v%"))
            ->orderBy('title')->paginate(12)->withQueryString();
        return view('books.index',compact('books'));
    }
    public function create() { return view('books.form',['book'=>new Book]); }
    public function store(Request $request) { $data=$this->validated($request); $data['available_copies']=$data['total_copies']; Book::create($data); return redirect()->route('books.index')->with('success','Book added successfully.'); }
    public function edit(Book $book) { return view('books.form',compact('book')); }
    public function update(Request $request, Book $book) {
        $data=$this->validated($request);
        $borrowed=$book->total_copies-$book->available_copies;
        if ($data['total_copies']<$borrowed) return back()->withErrors(['total_copies'=>"Total copies cannot be lower than the $borrowed currently borrowed copies."])->withInput();
        $data['available_copies']=$data['total_copies']-$borrowed; $book->update($data);
        return redirect()->route('books.index')->with('success','Book updated successfully.');
    }
    public function destroy(Book $book) {
        if ($book->loans()->whereNull('returned_at')->exists()) return back()->with('error','This book has an active borrowing transaction and cannot be deleted.');
        $book->delete(); return back()->with('success','Book deleted.');
    }
    private function validated(Request $request): array {
        return $request->validate([
            'title'=>'required|string|max:200','author'=>'required|string|max:160','isbn'=>['nullable','string','max:40',Rule::unique('books','isbn')->ignore($request->route('book'))],
            'category'=>'nullable|string|max:100','publisher'=>'nullable|string|max:160','publication_year'=>'nullable|integer|min:1000|max:'.(date('Y')+1),
            'total_copies'=>'required|integer|min:1|max:10000','description'=>'nullable|string|max:2000'
        ]);
    }
}
