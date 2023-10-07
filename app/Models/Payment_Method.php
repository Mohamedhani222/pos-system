<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment_Method extends Model
{
    use HasFactory;

    protected $table = 'payments_method';

    protected $fillable = ['admin_id', 'name'];

    public function admin() : BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
