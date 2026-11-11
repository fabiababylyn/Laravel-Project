<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Loan extends Model {
    protected $fillable = ['book_id','borrower_id','borrowed_at','due_date','returned_at','status','notes'];
    protected $casts = ['borrowed_at'=>'date','due_date'=>'date','returned_at'=>'date'];
    public function book() { return $this->belongsTo(Book::class); }
    public function borrower() { return $this->belongsTo(User::class, 'borrower_id'); }
}
