<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberFunction extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
    ];
}
