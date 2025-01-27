<?php

namespace App\Models;

use App\Models\Member;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvisionedUser extends Model
{
    use HasFactory;

    protected $visible = ['id', 'first_name', 'middle_name', 'last_name', 'email'];

    protected $fillable = [
        'upn',
        'full_user_id',
        'person_id',
        'last_name',
        'user_id',
        'middle_name',
        'first_name',
        'employment_start_date',
        'employment_end_date',
        'employer_code',
        'external_email',
    ];

    public function memberships()
    {
        return $this->hasMany(Member::class);
    }
}
