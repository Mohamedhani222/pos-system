<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SalesItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class PosIndex extends Component
{
    public $sale, $customer_id,
        $customer_name,
        $customer_email,
        $customer_phone,
        $cart = [],
        $totalPrice,
        $invoice = null,
$user,
        $searchQuery = '', $searchCategory = 0;
    public $categories;


    public function mount()
    {
        $this->categories = Category::pluck('name', 'id');
        $cart = Session::get('cart', []);
        $this->cart = $cart;
        $this->user =Auth::user();
    }

    public function render()
    {
        $products = Product::with('category')
            ->when($this->searchQuery !== '', fn(Builder $query) => $query->where('name', 'like', '%' . $this->searchQuery . '%'))
            ->when($this->searchCategory > 0, fn(Builder $query) => $query->where('category_id', $this->searchCategory))
            ->get();
        return view('livewire.pos-index', [
            'products' => $products
        ]);
    }


    public function charge()
    {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['quantity'] * $item['unit_price'];
        }
        $itemsModels = [];
        foreach ($this->cart as $item) {
            $itemsModels[] = new SalesItem($item);
        }

        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'customer_id' => $this->customer_id ?? null,
                'cashier_id' => auth()->id(),
                'total_amount' => $total,
                'date' => now()->toDate(),
                'paid' => true
            ]);
            $sale->items()->saveMany($itemsModels);
            $new_invoice = Invoice::create(
                ['sale_id' => $sale->id,
                    'invoice_number' => 0,
                    'invoice_date' => now()->toDate(),
                    'total_amount' => $sale->total_amount,
                    'invoice_serial_number' => 0]
            );
            $this->invoice = Invoice::with('sale.items')->find(7);
            DB::commit();
            $this->dispatch('print', id: $this->invoice->id);
            Session::remove('cart');
            $this->resetAll();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }


    public function resetAll()
    {
        $this->cart = [];
        $this->sale = "";
        $this->customer_id = null;
        $this->customer_name = "";
        $this->customer_email = "";
        $this->customer_phone = "";
        $this->totalPrice = "";
    }

    public function save()
    {
        $customer = Customer::create([
            'name' => $this->customer_name,
            'email' => $this->customer_email,
            'phone' => $this->customer_phone
        ]);
        $this->customer_id = $customer->id;
        $this->dispatch('closeModal');
    }

    public function setCategory($id)
    {
        $this->category = $id;
    }

    public function add_to_cart($product_id)
    {
        $product = Product::find($product_id);
        if (!isset($this->cart[$product_id])) {
            $this->cart[$product_id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'unit_price' => $product->unit_price,
                'image' => $product->image,
                'quantity' => 1,
                'total_price' => 0
            ];
            Session::put('cart', $this->cart);
        } else {
            $this->cart[$product_id]['quantity'] += 1;
        }
        Session::put('cart', $this->cart);
    }

    public function remove_from_cart($product_id)
    {
        if (isset($this->cart[$product_id])) {
            unset($this->cart[$product_id]);
            Session::put('cart', $this->cart);
        }
    }

    public function add_qty($product_id)
    {
        $this->cart[$product_id]['quantity'] += 1;
        Session::put('cart', $this->cart);
    }

    public function sub_qty($product_id)
    {
        if ($this->cart[$product_id]['quantity'] != 1) {
            $this->cart[$product_id]['quantity'] -= 1;
            Session::put('cart', $this->cart);
        };
    }

    public function delete_cart()
    {
        Session::remove('cart');
        $this->cart = [];
    }
}
