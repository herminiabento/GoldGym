<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'dni',
        'name',
        'lastname',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class)->using(PlanUser::class)->withPivot(['is_active','start_date','end_date'])->withTimestamps();
    }

    public function cancelPlans(array $planIds): void
    {

        $plans = PlanUser::where('user_id', $this->id)->whereIn('plan_id', $planIds)->get();

        foreach ($plans as $plan) {
            $plan->cancel();

            $orders = $this->orders()->where('status', 'pending')->get();
            foreach ($orders as $order) {
                $order->items()->where('plan_id', $plan->plan_id)->delete();

                // Si la orden queda vacía después de eliminar items, también la eliminamos
                if ($order->items()->count() === 0) {
                    $order->delete();
                }
            }
        }
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
