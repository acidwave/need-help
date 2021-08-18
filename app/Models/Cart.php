<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    protected $with = ['items'];

    protected $appends = ['items_count', 'discount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getItemsCountAttribute()
    {
        return $this->items()->sum('quantity');
    }

    public function getDiscountAttribute()
    {
        $discount = 1;
        if (in_array(Carbon::now()->dayOfWeekIso, [6,7])) {
            $discount = .8;
        } elseif ($this->items_count == 2) {
            $discount = .9;
        } elseif ($this->items_count >= 3) {
            $discount = .85;
        }
        return $discount;
    }
}
