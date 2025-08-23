
@extends('layouts.app')

@section('title', 'Category Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Category Details</h2>
    <div>
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>{{ $category->name }}</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Name:</dt>
                    <dd class="col-sm-9">{{ $category->name }}</dd>
                    
                    <dt class="col-sm-3">Description:</dt>
                    <dd class="col-sm-9">{{ $category->description ?? 'N/A' }}</dd>
                    
                    <dt class="col-sm-3">Products Count:</dt>
                    <dd class="col-sm-9">{{ $category->products->count() }}</dd>
                    
                    <dt class="col-sm-3">Created:</dt>
                    <dd class="col-sm-9">{{ $category->created_at->format('M d, Y H:i') }}</dd>
                </dl>
            </div>
        </div>

        @if($category->products->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5>Products in this Category</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category->products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>${{ number_format($product->price, 2) }}</td>
                                <td>{{ $product->stock_quantity }}</td>
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
