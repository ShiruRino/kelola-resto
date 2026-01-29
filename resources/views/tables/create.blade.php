@extends('layouts.app')
@section('title', 'Add a new table')
@section('content')
<div class="container">
    <a href="{{ route('tables.index') }}" class="btn btn-danger">Back</a>
    <div class="card mt-5">
        <div class="card-header">Add a new table</div>
        <div class="card-body">
            <form action="{{ route('tables.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="seating_capacity" class="form-label">Seating Capacity</label>
                    <input type="number" class="form-control" id="seating_capacity" name="seats" value="{{ old('seats') }}" placeholder="Enter seating capacity">
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Seat Location</label>
                    <select class="form-control" id="location" name="location">
                        <option value="">Select Location</option>
                        <option value="indoor" {{ old('location') == 'indoor' ? 'selected' : '' }}>Indoor</option>
                        <option value="outdoor" {{ old('location') == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                        <option value="vip" {{ old('location') == 'vip' ? 'selected' : '' }}>VIP</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Create Table</button>
            </form>
        </div>
    </div>
</div>
@endsection