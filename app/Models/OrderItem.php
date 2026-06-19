<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'plan_id',
        'title',
        'description',
        'quantity',
        'unit_price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class)->withTrashed();
    }

    public function getTotalAttribute()
    {
        return $this->unit_price * $this->quantity;
    }
}
