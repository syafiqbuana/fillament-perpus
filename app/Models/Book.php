<?php

namespace App\Models;

use App\Models\Loan;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'year',
        'isbn',
        'stock',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class, 'book_id');
    }
}