<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 */
class Member extends Model
{
    use HasFactory;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['start_date', 'end_date'];

    protected $fillable = [
        'group_id',
        'provisioned_user_id',
        'member_function_id',
        'start_date',
        'end_date',
        'employment_number',
    ];

    /**
     * Determine if the member should be deleted.
     *
     * @param int $extra_days
     * @return bool
     */
    function shouldBeDeleted($extra_days = 0): bool
    {
        if ($this->end_date) {
            $end_date = $this->end_date->addDays($extra_days);
            return $end_date->isPast();
        }

        return false;
    }

    function isActive(): bool
    {
        return !$this->isExpired() && !$this->isWaitingForStart();
    }

    function isExpired(): bool
    {
        return $this->end_date && $this->end_date->isPast();
    }

    function isWaitingForStart(): bool
    {
        return $this->start_date && $this->start_date->isFuture();
    }

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function user() {
        return $this->belongsTo(ProvisionedUser::class);
    }

    public function memberFunction() {
        return $this->belongsTo(MemberFunction::class);
    }
}
