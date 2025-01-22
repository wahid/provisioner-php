<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    // add members to the group
    public function members()
    {
        return $this->hasMany(ProvisionedUser::class);
    }
}
