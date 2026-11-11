<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class BorrowerController extends Controller {
    public function index(Request $request) {
        $borrowers=User::where('role','student')->when($request->q,fn($q,$v)=>$q->where(fn($w)=>$w->where('name','like',"%$v%")->orWhere('email','like',"%$v%")->orWhere('student_number','like',"%$v%")))->orderBy('name')->paginate(15)->withQueryString();
        return view('borrowers.index',compact('borrowers'));
    }
    public function create() { return view('borrowers.form',['borrower'=>new User]); }
    public function store(Request $request) {
        $data=$request->validate(['name'=>'required|string|max:120','email'=>'required|email|unique:users,email','student_number'=>'nullable|string|max:60','phone'=>'nullable|string|max:30','password'=>'required|string|min:8']);
        $data['role']='student'; User::create($data); return redirect()->route('borrowers.index')->with('success','Borrower account created.');
    }
    public function edit(User $borrower) { abort_unless($borrower->role==='student',404); return view('borrowers.form',compact('borrower')); }
    public function update(Request $request, User $borrower) {
        abort_unless($borrower->role==='student',404);
        $data=$request->validate(['name'=>'required|string|max:120','email'=>['required','email',Rule::unique('users')->ignore($borrower->id)],'student_number'=>'nullable|string|max:60','phone'=>'nullable|string|max:30','password'=>'nullable|string|min:8']);
        if(empty($data['password'])) unset($data['password']); $borrower->update($data);
        return redirect()->route('borrowers.index')->with('success','Borrower updated.');
    }
    public function destroy(User $borrower) {
        abort_unless($borrower->role==='student',404);
        if($borrower->loans()->whereNull('returned_at')->exists()) return back()->with('error','Borrower has an active loan.');
        $borrower->delete(); return back()->with('success','Borrower deleted.');
    }
}
