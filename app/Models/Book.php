<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Book extends Model {
    protected $fillable = ['title','author','isbn','category','publisher','publication_year','total_copies','available_copies','description'];
    public function loans() { return $this->hasMany(Loan::class); }
}
