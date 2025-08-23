
<!DOCTYPE html>
<html>
<head>
    <title>Stock Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
        .low-stock { background-color: #ffebee; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Stock Report</h2>
        <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock Quantity</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr class="{{ $product->stock_quantity < 10 ? 'low-stock' : '' }}">
                <td>{{ $product->name }}</td>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->category->name }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>{{ $product->stock_quantity }}</td>
                <td>{{ $product->stock_quantity < 10 ? 'Low Stock' : 'In Stock' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
