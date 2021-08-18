<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'good_id', 'quantity', 'cost'];

    protected $touches = ['order'];

    protected $with = ['item'];

    protected $appends = ['item_total'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function item()
    {
        return $this->belongsTo(Good::class, 'good_id');
    }

    public function getItemTotalAttribute()
    {
        return $this->cost * $this->quantity;
    }
}
