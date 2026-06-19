<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    /** @use HasFactory<\Database\Factories\PlanFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'plans';

    protected $fillable = [
        'title',
        'duration',
        'price',
        'status',
        'image',
        'excerpt',
        'description'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_plan');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->using(PlanUser::class)->withPivot(['is_active','start_date','end_date'])->withTimestamps();
    }

    public function calculateEndDate(Carbon $startDate): ?Carbon
    {
        return match ($this->duration) {
            'mensual' => $startDate->copy()->addMonth()->subDay(),
            'anual'   => $startDate->copy()->addYear()->subDay(),
            default   => null,
        };
    }

}
