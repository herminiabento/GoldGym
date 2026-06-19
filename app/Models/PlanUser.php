<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PlanUser extends Pivot
{
    //
    protected $table = 'plan_user';

    protected $fillable = [
        'user_id',
        'plan_id',
        'is_active',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function getIsValidNowAttribute(): bool
    {
        if (!$this->end_date) {
            return false;
        }

        return $this->end_date->gte(today());
    }

    public function cancel(): bool
    {
        if ($this->end_date && $this->end_date->gte(today())) {
            $this->is_active = false;
            return $this->save();
        }

        return $this->delete();
    }
}
