
@extends('layouts.app')

@section('title', 'Sale Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Sale Details</h2>
    <div>
        <a href="{{ route('sales.invoice', $sale) }}" class="btn btn-success" target="_blank">
            <i class="fas fa-file-invoice"></i> Download Invoice
        </a>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Sale #{{ $sale->sale_number }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">Customer:</dt>
                            <dd class="col-sm-8">{{ $sale->customer->name }}</dd>
                            
                            <dt class="col-sm-4">Phone:</dt>
                            <dd class="col-sm-8">{{ $sale->customer->phone }}</dd>
                            
                            <dt class="col-sm-4">Date:</dt>
                            <dd class="col-sm-8">{{ $sale->created_at->format('M d, Y H:i') }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">Sale Number:</dt>
                            <dd class="col-sm-8">{{ $sale->sale_number }}</dd>
                            
                            <dt class="col-sm-4">Store:</dt>
                            <dd class="col-sm-8">{{ $sale->storeKeeper->store_name }}</dd>
                        </dl>
                    </div>
                </div>

                <h6>Items Purchased</h6>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->saleItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->product->sku }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->unit_price, 2) }}</td>
                                <td>${{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Payment Summary</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span>${{ number_format($sale->total_amount, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Discount:</span>
                    <span>-${{ number_format($sale->discount, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Tax:</span>
                    <span>+${{ number_format($sale->tax, 2) }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <strong>Final Amount:</strong>
                    <strong>${{ number_format($sale->final_amount, 2) }}</strong>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5>Customer Information</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Name:</dt>
                    <dd class="col-sm-8">{{ $sale->customer->name }}</dd>
                    
                    <dt class="col-sm-4">Email:</dt>
                    <dd class="col-sm-8">{{ $sale->customer->email ?? 'N/A' }}</dd>
                    
                    <dt class="col-sm-4">Phone:</dt>
                    <dd class="col-sm-8">{{ $sale->customer->phone }}</dd>
                    
                    <dt class="col-sm-4">Address:</dt>
                    <dd class="col-sm-8">{{ $sale->customer->address ?? 'N/A' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
