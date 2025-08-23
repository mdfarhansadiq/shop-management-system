
@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Product Details</h2>
    <div>
        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>{{ $product->name }}</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Name:</dt>
                    <dd class="col-sm-9">{{ $product->name }}</dd>
                    
                    <dt class="col-sm-3">SKU:</dt>
                    <dd class="col-sm-9">{{ $product->sku }}</dd>
                    
                    <dt class="col-sm-3">Category:</dt>
                    <dd class="col-sm-9">{{ $product->category->name }}</dd>
                    
                    <dt class="col-sm-3">Description:</dt>
                    <dd class="col-sm-9">{{ $product->description ?? 'N/A' }}</dd>
                    
                    <dt class="col-sm-3">Price:</dt>
                    <dd class="col-sm-9">${{ number_format($product->price, 2) }}</dd>
                    
                    <dt class="col-sm-3">Stock Quantity:</dt>
                    <dd class="col-sm-9">
                        {{ $product->stock_quantity }}
                        @if($product->stock_quantity < 10)
                            <span class="badge bg-warning ms-2">Low Stock</span>
                        @endif
                    </dd>
                    
                    <dt class="col-sm-3">Created:</dt>
                    <dd class="col-sm-9">{{ $product->created_at->format('M d, Y H:i') }}</dd>
                </dl>
            </div>
        </div>

        @if($product->saleItems->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5>Sales History</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Sale #</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product->saleItems as $saleItem)
                            <tr>
                                <td>{{ $saleItem->sale->sale_number }}</td>
                                <td>{{ $saleItem->sale->customer->name }}</td>
                                <td>{{ $saleItem->sale->created_at->format('M d, Y') }}</td>
                                <td>{{ $saleItem->quantity }}</td>
                                <td>${{ number_format($saleItem->unit_price, 2) }}</td>
                                <td>${{ number_format($saleItem->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
