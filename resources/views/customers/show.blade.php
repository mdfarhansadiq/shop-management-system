
@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Customer Details</h2>
    <div>
        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>{{ $customer->name }}</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Name:</dt>
                    <dd class="col-sm-9">{{ $customer->name }}</dd>
                    
                    <dt class="col-sm-3">Email:</dt>
                    <dd class="col-sm-9">{{ $customer->email ?? 'N/A' }}</dd>
                    
                    <dt class="col-sm-3">Phone:</dt>
                    <dd class="col-sm-9">{{ $customer->phone }}</dd>
                    
                    <dt class="col-sm-3">Address:</dt>
                    <dd class="col-sm-9">{{ $customer->address ?? 'N/A' }}</dd>
                    
                    <dt class="col-sm-3">Total Purchases:</dt>
                    <dd class="col-sm-9">${{ number_format($customer->sales->sum('final_amount'), 2) }}</dd>
                    
                    <dt class="col-sm-3">Registered:</dt>
                    <dd class="col-sm-9">{{ $customer->created_at->format('M d, Y H:i') }}</dd>
                </dl>
            </div>
        </div>

        @if($customer->sales->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5>Purchase History</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Sale #</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customer->sales as $sale)
                            <tr>
                                <td>{{ $sale->sale_number }}</td>
                                <td>{{ $sale->created_at->format('M d, Y') }}</td>
                                <td>{{ $sale->saleItems->count() }} items</td>
                                <td>${{ number_format($sale->final_amount, 2) }}</td>
                                <td>
                                    <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
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
