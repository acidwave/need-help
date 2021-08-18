<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'good_id', 'quantity'];

    protected $touches = ['cart'];

    protected $with = ['item'];

    protected $appends = ['item_total'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function item()
    {
        return $this->belongsTo(Good::class, 'good_id');
    }

    public function getItemTotalAttribute()
    {
        return $this->item->cost * $this->quantity;
    }
}
