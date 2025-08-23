
<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
        .total { font-weight: bold; background-color: #f9f9f9; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Sales Report</h2>
        <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Sale Number</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Total Amount</th>
                <th>Discount</th>
                <th>Tax</th>
                <th>Final Amount</th>
            </tr>
        </thead>
        <tbody>
            @php $totalSales = 0; @endphp
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->sale_number }}</td>
                <td>{{ $sale->customer->name }}</td>
                <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                <td>${{ number_format($sale->total_amount, 2) }}</td>
                <td>${{ number_format($sale->discount, 2) }}</td>
                <td>${{ number_format($sale->tax, 2) }}</td>
                <td>${{ number_format($sale->final_amount, 2) }}</td>
            </tr>
            @php $totalSales += $sale->final_amount; @endphp
            @endforeach
            <tr class="total">
                <td colspan="6">Total Sales</td>
                <td>${{ number_format($totalSales, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
