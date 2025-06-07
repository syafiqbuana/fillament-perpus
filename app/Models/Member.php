<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'classes_id'
    ];

    public function classes()
    {
        return $this->belongsTo(Classes::class, 'classes_id');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class, 'member_id');
    }
}