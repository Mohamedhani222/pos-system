<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['sale_id', 'invoice_number', 'invoice_date', 'total_amount', 'invoice_serial_number'];

    // increment
    public function setInvoiceSerialNumberAttribute()
    {
        $this->attributes['invoice_serial_number'] = Invoice::max('invoice_serial_number') + 1;
    }
    public function setInvoiceNumberAttribute()
    {
        $this->attributes['invoice_number'] = 'ABC-' . str_pad($this->invoice_serial_number, 5, 0, STR_PAD_LEFT);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
}
