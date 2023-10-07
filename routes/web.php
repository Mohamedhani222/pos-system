<?php

use App\Http\Controllers\PosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/invoices/print/{invoice}', [PosController::class,'print_invoice']);
Route::middleware(['auth','can:create_sale'])->get('/',\App\Livewire\PosIndex::class);

require __DIR__.'/auth.php';
