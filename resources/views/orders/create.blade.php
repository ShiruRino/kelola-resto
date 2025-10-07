@extends('layouts.app')
@section('title', 'Create Order')
@section('content')
<a href="{{route('orders.index')}}" class="btn btn-danger mt-5 mb-4 btn-sm">Back</a>
@if ($errors->any())
<div class="alert alert-danger mb-4">
    @foreach ($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
</div>
@endif
<div class="card mb-5">
    <div class="card-header">Create Order</div>
    <div class="card-body">
        <form action="{{route('orders.store')}}" method="post">
            @csrf
            @method('POST')
            <div class="mb-3">
                <label for="table_number" class="form-label">Table Number</label>
                <input type="number" class="form-control" name="table_number" value="{{old('table_number')}}" placeholder="Table Number" required>
            </div>
            <div class="mb-3">
                <label for="customer_id" class="form-label">Customer</label>
                <input type="text" class="form-control" name="customer_phone" value="{{old('customer_phone')}}" placeholder="Customer Phone">
            </div>
            <div id="product-container">
                <div class="row mb-3 product-row">
                    <div class="col-md-6">
                        <label class="form-label">Product</label>
                        <select name="product[]" class="form-select" required>
                            <option value="">-- Select Product --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} - Rp{{ number_format($product->price, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity[]" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-row">X</button>
                    </div>
                </div>
            </div>

            <button type="button" id="add-product" class="btn btn-secondary btn-sm">+ Add Product</button>

            <button type="submit" class="btn btn-success btn-sm">Submit</button>
        </form>
    </div>
</div>
<script>
    document.getElementById('add-product').addEventListener('click', function () {
        const container = document.getElementById('product-container');
        const firstRow = container.querySelector('.product-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('select, input').forEach(input => {
            if (input.tagName === 'SELECT') {
                input.selectedIndex = 0;
            } else {
                input.value = 1;
            }
        });

        container.appendChild(newRow);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            const row = e.target.closest('.product-row');
            const container = document.getElementById('product-container');

            if (container.querySelectorAll('.product-row').length > 1) {
                row.remove();
            }
        }
    });
</script>
@endsection
