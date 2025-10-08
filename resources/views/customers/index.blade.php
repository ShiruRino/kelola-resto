@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<a href="{{route('customers.create')}}" class="btn btn-success mt-5 mb-4 btn-sm">Create</a>
<div class="card mt-4 mb-5">
    <div class="card-header">Customers</div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Address</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $customer->name }}</td>
                    <td>{{ !$customer->gender ? 'Male' : 'Female' }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->address }}</td>
                    <td class="d-flex flex-row flex-wrap" style="gap: 0.5rem;">
                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $customers->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
