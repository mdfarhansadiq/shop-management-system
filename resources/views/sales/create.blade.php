
@extends('layouts.app')

@section('title', 'New Sale')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>New Sale</h2>
    <a href="{{ route('sales.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<form action="{{ route('sales.store') }}" method="POST" id="saleForm">
    @csrf
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Sale Items</h5>
                </div>
                <div class="card-body">
                    <div id="saleItems">
                        <div class="sale-item mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Product</label>
                                    <select name="items[0][product_id]" class="form-control product-select" required>
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock_quantity }}">
                                                {{ $product->name }} (Stock: {{ $product->stock_quantity }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" name="items[0][quantity]" class="form-control quantity-input" min="1" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Subtotal</label>
                                    <input type="text" class="form-control subtotal" readonly>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-item">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" id="addItem" class="btn btn-success">
                        <i class="fas fa-plus"></i> Add Item
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Customer & Payment</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                        <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="discount" class="form-label">Discount</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" name="discount" id="discount" class="form-control" value="{{ old('discount', 0) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tax" class="form-label">Tax</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" name="tax" id="tax" class="form-control" value="{{ old('tax', 0) }}">
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span id="totalAmount">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Discount:</span>
                        <span id="discountAmount">-$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax:</span>
                        <span id="taxAmount">+$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Final Total:</strong>
                        <strong id="finalAmount">$0.00</strong>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Complete Sale</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
let itemIndex = 1;

document.getElementById('addItem').addEventListener('click', function() {
    const saleItems = document.getElementById('saleItems');
    const newItem = document.createElement('div');
    newItem.className = 'sale-item mb-3';
    newItem.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Product</label>
                <select name="items[${itemIndex}][product_id]" class="form-control product-select" required>
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock_quantity }}">
                            {{ $product->name }} (Stock: {{ $product->stock_quantity }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity-input" min="1" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Subtotal</label>
                <input type="text" class="form-control subtotal" readonly>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-item">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    saleItems.appendChild(newItem);
    itemIndex++;
    attachEventListeners();
});

function attachEventListeners() {
    // Remove item functionality
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            if (document.querySelectorAll('.sale-item').length > 1) {
                this.closest('.sale-item').remove();
                calculateTotal();
            }
        });
    });

    // Product selection and quantity change
    document.querySelectorAll('.product-select, .quantity-input').forEach(element => {
        element.addEventListener('change', calculateItemSubtotal);
        element.addEventListener('input', calculateItemSubtotal);
    });
}

function calculateItemSubtotal(event) {
    const item = event.target.closest('.sale-item');
    const productSelect = item.querySelector('.product-select');
    const quantityInput = item.querySelector('.quantity-input');
    const subtotalInput = item.querySelector('.subtotal');

    if (productSelect.value && quantityInput.value) {
        const price = parseFloat(productSelect.options[productSelect.selectedIndex].dataset.price);
        const quantity = parseInt(quantityInput.value);
        const subtotal = price * quantity;
        subtotalInput.value = '$' + subtotal.toFixed(2);
    } else {
        subtotalInput.value = '';
    }
    calculateTotal();
}

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(input => {
        if (input.value) {
            total += parseFloat(input.value.replace('$', ''));
        }
    });

    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const tax = parseFloat(document.getElementById('tax').value) || 0;
    const finalTotal = total - discount + tax;

    document.getElementById('totalAmount').textContent = '$' + total.toFixed(2);
    document.getElementById('discountAmount').textContent = '-$' + discount.toFixed(2);
    document.getElementById('taxAmount').textContent = '+$' + tax.toFixed(2);
    document.getElementById('finalAmount').textContent = '$' + finalTotal.toFixed(2);
}

// Initialize event listeners
attachEventListeners();

// Add listeners for discount and tax
document.getElementById('discount').addEventListener('input', calculateTotal);
document.getElementById('tax').addEventListener('input', calculateTotal);
</script>
@endsection
