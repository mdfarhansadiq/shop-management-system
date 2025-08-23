
@extends('layouts.app')

@section('title', 'Sales')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Sales</h2>
    <div>
        <a href="{{ route('sales.report') }}" class="btn btn-info">
            <i class="fas fa-file-pdf"></i> Sales Report
        </a>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Sale
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($sales->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sale #</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Discount</th>
                            <th>Final Amount</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                        <tr>
                            <td>{{ $sale->sale_number }}</td>
                            <td>{{ $sale->customer->name }}</td>
                            <td>{{ $sale->saleItems->count() }} items</td>
                            <td>${{ number_format($sale->total_amount, 2) }}</td>
                            <td>${{ number_format($sale->discount, 2) }}</td>
                            <td><strong>${{ number_format($sale->final_amount, 2) }}</strong></td>
                            <td>{{ $sale->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('sales.invoice', $sale) }}" class="btn btn-sm btn-success" target="_blank">
                                        <i class="fas fa-file-invoice"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $sales->links() }}
        @else
            <div class="text-center py-4">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <p class="text-muted">No sales found.</p>
                <a href="{{ route('sales.create') }}" class="btn btn-primary">Create First Sale</a>
            </div>
        @endif
    </div>
</div>
@endsection
