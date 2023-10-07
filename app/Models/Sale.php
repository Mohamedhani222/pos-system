<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'customer_id',
            'cashier_id',
            'total_amount',
            'date',
            'paid'
        ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id')->whereHas('roles',fn($q)=>$q->where('name','cashier'));

    }


    public function items(): HasMany
    {
        return $this->hasMany(SalesItem::class, 'sale_id');
    }


}
