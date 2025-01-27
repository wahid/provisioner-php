<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_code',
        'name',
        'description',
        'should_have_mailbox'
    ];

    // add members to the group
    public function members()
    {
        return $this->hasMany(ProvisionedUser::class);
    }

    public function mailbox()
    {
        return $this->hasOne(Mailbox::class);
    }
}
