
<!DOCTYPE html>
<html>
<head>
    <title>Invoice - {{ $sale->sale_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .company-info { margin-bottom: 30px; }
        .customer-info { margin-bottom: 30px; }
        .invoice-details { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; background-color: #f9f9f9; }
        .right-align { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <h2>{{ $sale->storeKeeper->store_name }}</h2>
    </div>

    <div class="company-info">
        <strong>From:</strong><br>
        {{ $sale->storeKeeper->name }}<br>
        {{ $sale->storeKeeper->store_name }}<br>
        {{ $sale->storeKeeper->city }}<br>
        Email: {{ $sale->storeKeeper->email }}<br>
        Phone: {{ $sale->storeKeeper->phone }}
    </div>

    <div class="customer-info">
        <strong>To:</strong><br>
        {{ $sale->customer->name }}<br>
        {{ $sale->customer->address }}<br>
        Phone: {{ $sale->customer->phone }}
    </div>

    <div class="invoice-details">
        <strong>Invoice Number:</strong> {{ $sale->sale_number }}<br>
        <strong>Date:</strong> {{ $sale->created_at->format('Y-m-d') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->saleItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->unit_price, 2) }}</td>
                <td>${{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="right-align">
        <table style="width: 300px; margin-left: auto;">
            <tr>
                <td><strong>Subtotal:</strong></td>
                <td>${{ number_format($sale->total_amount, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Discount:</strong></td>
                <td>-${{ number_format($sale->discount, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Tax:</strong></td>
                <td>${{ number_format($sale->tax, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td><strong>Total:</strong></td>
                <td><strong>${{ number_format($sale->final_amount, 2) }}</strong></td>
            </tr>
        </table>
    </div>
</body>
</html>
