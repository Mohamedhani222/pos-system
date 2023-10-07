<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'total_price',
        'quantity',
        'unit_price',
        'product_id'
    ];

    public function setTotalPriceAttribute()
    {
        $this->attributes['total_price'] = $this->quantity * $this->unit_price;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
