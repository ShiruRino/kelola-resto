@extends('layouts.app')
@section('title', 'Edit Product')
@section('content')
<a href="{{route('products.index')}}" class="btn btn-danger mt-5 mb-4 btn-sm">Back</a>
@if ($errors->any())
@foreach ($errors->all() as $i)
<div class="alert alert-danger mb-4">{{$i}}</div>
@endforeach
@endif
<div class="card mb-5">
    <div class="card-header">Edit Product</div>
    <div class="card-body">
        <form action="{{route('products.update', $product->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{old('name', $product->name)}}" placeholder="Name">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" id="price" name="price" value="{{old('price', $product->price)}}" placeholder="Price">
                </div>
            </div>
            <button type="submit" class="btn btn-success btn-sm">Submit</button>
    </div>
</div>
@endsection
