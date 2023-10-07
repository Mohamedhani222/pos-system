<div>
    <style>@media print {
            .no_print {
                display: none !important;
            }

            #test {
                display: block;
            }
        }
    </style>



    <!-- Modal -->
@include('livewire.endshiftModal')

    {{--    Products && Category--}}
    <!-- Button trigger modal -->
    <!-- Modal -->
    <section class="section-content no_print padding-y-sm bg-default ">
        <div class="container-fluid">
            <div class="row">
                <div class="modal fade" id="modal-create" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form wire:submit.prevent="save">
                                    <label for="name" class="form-label">Name</label>
                                    <input name="name" class="form-control" wire:model='customer_name'/>

                                    <label for="email" class="form-label">email</label>
                                    <input type="email" class="form-control" name="email"
                                           wire:model='customer_email'>

                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="number" class="form-control" name="phone"
                                           wire:model='customer_phone'>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="col-md-8 card padding-y-sm card ">

                        <div class="row mb-3" >
                                <div class="col-lg-6 col-sm-6">
                                        <div class="input-group">
                                            <input type="text" wire:model.live="searchQuery" class="form-control" placeholder="Search">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                </div>
                            <div class="col">
                                <select wire:model.live="searchCategory" name="category" class="form-control">
                                    <option value="0">-- CHOOSE CATEGORY --</option>
                                    @foreach($categories as $id => $category)
                                        <option value="{{ $id }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                        </div>
                        </div>

                    <span id="items">
            <div class="row">
{{--  product start--}}
                @foreach($products as $product)
                    <div class="col-md-3">
                <figure class="card card-product">
                    <span class="badge-new"> NEW </span>
                    <div class="img-wrap">
                        <img src="{{asset($product->image)}}" class="img-fluid">
                        <a class="btn-overlay" href="#"><i class="fa fa-search-plus"></i> Quick view</a>
                    </div>
                    <figcaption class="info-wrap">
                        <a href="#" class="title">{{$product->name}}</a>
                        <div class="action-wrap">
                            <input type="hidden" name="product_id" value={{$product->id}}>
                            <input type="hidden" name="quantity" value=1>
                    <button wire:click="add_to_cart({{ $product->id }})" wire:loading.attr="disabled"
                            class="btn btn-primary btn-sm float-right">
                        <span wire:loading wire:target="add_to_cart({{ $product->id }})"><i
                                class="fa fa-spinner fa-spin"></i> Adding...</span>

                        <span wire:loading.remove wire:target="add_to_cart({{ $product->id }})"><i
                                class="fa fa-cart-plus"></i> Add</span>
                            </button>
                            <div class="price-wrap h5">
                                <span class="price-new">{{$product->unit_price}}</span>
                            </div>
                        </div>
                    </figcaption>

                </figure>
            </div>
                @endforeach
                {{-- product End --}}
            </div>
            </span>
                </div>
                {{--  End  Products && Category--}}


                <div class="col-md-4">
                    <div class="card">
	<span id="cart">
<table class="table table-hover shopping-cart-wrap">
<thead class="text-muted">
<tr>
            <div>
                @if(!$customer_id)
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                    create customer
                </button>
                @else
                    <h5>Customer Number is {{$customer_id}}</h5>
                @endif

                <button class="btn btn-danger" data-toggle="modal" data-target="#endShiftModal">End Shift</button>
            </div>
  <th scope="col">Item</th>
  <th scope="col" width="120">Qty</th>
  <th scope="col" width="120">Price</th>
  <th scope="col" class="text-right" width="200">Delete</th>
</tr>
</thead>
<tbody>

<tr>

            @foreach ($cart as  $item)
        <td>
<figure class="media">
	<div class="img-wrap"><img src="{{asset($item['image'])}}" class="img-thumbnail img-xs"></div>
	<figcaption class="media-body">
		<h6 class="title small text-truncate">{{ $item['name']}}</h6>
	</figcaption>
</figure>
	</td>
        <td class="text-center">
		<div class="m-btn-group m-btn-group--pill btn-group mr-2" role="group" aria-label="...">
                    <button type="button" class="m-btn btn btn-default" wire:click="sub_qty({{$item['product_id']}})"><i
                            class="fa fa-minus"></i></button>
                    <button type="button" class="m-btn btn btn-default" disabled>{{ $item['quantity']}}</button>
                    <button type="button" class="m-btn btn btn-default"
                            wire:click="add_qty({{$item['product_id']}})"> <i class="fa fa-plus"></i> </button>
        </div>
	</td>
        <td>
		<div class="price-wrap">
			<var class="price small">{{number_format($item['unit_price']) }}eg</var>
		</div>
	</td>
        <td class="text-right">

	<button wire:click="remove_from_cart({{$item['product_id']}})" class="btn btn-outline-danger">
        <i class="fa fa-trash"></i>
    </button>
	</td>



</tr>
        @endforeach


</tbody>
</table>
</span>
                    </div> <!-- card.// -->
                    <div class="box">

                        @php
                            $totalPrice = 0;
                            foreach ($this->cart as $item) {
                                $totalPrice += $item['unit_price'] * $item['quantity'];
                            }
                        @endphp

                        <dl class="dlist-align">
                            <dt>Total:</dt>
                            <dd class="text-right h5 b">{{$totalPrice}} egp</dd>
                        </dl>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="#" wire:click="delete_cart"
                                   class="btn  btn-default btn-error btn-lg btn-block"><i
                                        class="fa fa-times-circle "></i> Cancel </a>
                            </div>
                            <div class="col-md-6">
                                <button wire:click="charge" class="btn  btn-primary btn-lg btn-block"
                                        @if(!count($cart)) disabled @endif >
                                    <span wire:loading.remove wire:target="charge"><i class="fa fa-shopping-bag"></i> Charge</span>
                                    <span wire:loading wire:target="charge"><i class="fa fa-spinner fa-spin"></i> loading...</span>
                                </button>
                            </div>
                        </div>
                    </div> <!-- box.// -->
                </div>
            </div>
        </div><!-- container //  -->
    </section>

    @push('js')


        <script src="{{asset('/assets/js/printThis.js')}}"></script>

        <script>
            window.addEventListener('closeModal', event => {
                $('#modal-create').modal('hide')
            });
        </script>

        <script>
            window.addEventListener('print', (id) => {
                const printUrl = `http://127.0.0.1:8000/invoices/print/${id.detail.id}`;
                const page = window.open(printUrl, '', 'width=600,height=600');
                page.onload = () => {
                    page.print();
                    page.addEventListener('afterprint', () => {
                        page.close();
                    });
                };
            });

        </script>

    @endpush


</div>
