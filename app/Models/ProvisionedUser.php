<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvisionedUser extends Model
{
    use HasFactory;

    protected $visible = ['id', 'first_name', 'middle_name', 'last_name', 'email'];
}
