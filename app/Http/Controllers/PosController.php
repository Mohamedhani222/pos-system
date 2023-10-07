<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function print_invoice($invoiceId): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('pos.invoice', ['invoice' => Invoice::with('sale.items.product')->findOrFail($invoiceId)]);
    }

}
