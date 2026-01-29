@extends('layouts.app')
@section('title', 'Create Customer')
@section('content')
<a href="{{route('customers.index')}}" class="btn btn-danger mt-5 mb-4 btn-sm">Back</a>
<div class="card mb-5">
    <div class="card-header">Create Customer</div>
    <div class="card-body">
        <form action="{{route('customers.store')}}" method="post">
            @csrf
            @method('POST')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" placeholder="Name">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" name="gender">
                    <option value="">Select Gender</option>
                    <option value="0" {{old('gender') ? 'selected' : ''}}>Male</option>
                    <option value="1" {{old('gender') ? 'selected' : ''}}>Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{old('phone')}}" placeholder="Phone Number">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" placeholder="Address">{{old('address')}}</textarea>
            </div>
            <button type="submit" class="btn btn-success btn-sm">Submit</button>
        </form>
    </div>
</div>
@endsection
