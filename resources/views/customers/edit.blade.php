@extends('layouts.app')
@section('title', 'Edit Customer')
@section('content')
<a href="{{route('customers.index')}}" class="btn btn-danger mt-5 mb-4 btn-sm">Back</a>
<div class="card mb-5">
    <div class="card-header">Edit Customer</div>
    <div class="card-body">
        <form action="{{route('customers.update', $customer->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{old('name', $customer->name)}}" placeholder="Name">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" name="gender">
                    <option value="0" {{$customer->gender ? 'selected' : ''}}>Male</option>
                    <option value="1" {{$customer->gender ? 'selected' : ''}}>Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{old('phone', $customer->phone)}}" placeholder="Phone Number">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" placeholder="Address">{{old('address', $customer->address)}}</textarea>
            </div>
            <button type="submit" class="btn btn-success btn-sm">Submit</button>
        </form>
    </div>
</div>
@endsection
