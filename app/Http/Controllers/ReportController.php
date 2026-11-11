<?php
namespace App\Http\Controllers;
use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;
class ReportController extends Controller {
    public function __invoke(Request $request) {
        $loans=Loan::with(['book','borrower'])->when($request->from,fn($q,$v)=>$q->whereDate('borrowed_at','>=',$v))
            ->when($request->to,fn($q,$v)=>$q->whereDate('borrowed_at','<=',$v))->latest()->get();
        $summary=['transactions'=>$loans->count(),'active'=>$loans->whereNull('returned_at')->count(),'returned'=>$loans->whereNotNull('returned_at')->count(),
            'overdue'=>$loans->filter(fn($l)=>!$l->returned_at && $l->due_date->lt(today()))->count()];
        $popular=Book::withCount('loans')->orderByDesc('loans_count')->take(5)->get();
        return view('reports',compact('loans','summary','popular'));
    }
}
