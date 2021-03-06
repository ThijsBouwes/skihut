<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $appends = [
        'total_products_price',
        'total_revenue',
        'profit',
        'total_users'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'event_date'
    ];

    /**
     * Get all the users for the Event.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('payed')
            ->withTimestamps();
    }

    /**
     * Get the event products.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function getTotalUsersAttribute()
    {
        return $this->users->count();
    }

    public function getTotalUsersWithDebtAttribute()
    {
        return $this->users()
            ->wherePivot('payed', '=', false)
            ->count();
    }

    public function getTotalProductsPriceAttribute()
    {
        return $this->products->sum(function($product) {
            return $product->price * $product->quantity;
        });
    }

    public function getTotalDebtAttribute()
    {
        return $this->total_users_with_debt * $this->price;
    }

    public function getTotalRevenueAttribute()
    {
        return $this->users->count() * $this->price;
    }

    public function getProfitAttribute()
    {
        return $this->total_revenue - $this->total_products_price;
    }
}
