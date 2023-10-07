<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="{{asset('/assets/css/bootstrap.css')}}">
    <style>
        /* Custom styles for the invoice */
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .invoice-header {
            text-align: center;
        }
        .invoice-details {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .invoice-items th {
            background-color: #f5f5f5;
        }
        .invoice-footer {
            text-align: right;
        }
    </style>
</head>
<body>
<div class="container invoice-container">
    <div class="invoice-header">
        <h1>Invoice</h1>
        <p>Date: {{$invoice?->invoice_date}}</p>
    </div>
    <div class="invoice-details">
        <p>Bill From:</p>
        <address>
            {{$invoice?->sale->customer?->name}}<br>
            Walking Customer<br>
            Email: {{$invoice?->sale->customer?->email}}<br>
            Phone: {{$invoice?->sale->customer?->phone}}
        </address>
    </div>
    <table class="table table-bordered invoice-items">
        <thead>
        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @if($invoice?->sale->items )
        @foreach( $invoice->sale->items as $item)
        <tr>
            <td>{{$item->product->name}}</td>
            <td>{{$item->quantity}}</td>
            <td>{{$item->unit_price}}</td>
            <td>{{$item->total_price}}</td>
        </tr>
        @endforeach
        @endif

        </tbody>
    </table>
    <div class="invoice-footer">
        <p><strong>Total: ${{$invoice?->sale->total_amount}}</strong></p>
    </div>
</div>
</body>
</html>
