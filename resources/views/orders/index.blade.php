@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<a href="{{route('orders.create')}}" class="btn btn-success mt-5 mb-4 btn-sm">Create</a>
<div class="card mb-5">
    <div class="card-header">Orders</div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope='col'>#</th>
                    <th>Table Number</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $i)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$i->table->table_number}}</td>
                    <td>{{$i->customer->name}}</td>
                    <td>{{\Carbon\Carbon::parse($i->created_at)->format('d-m-Y H:i')}}</td>
                    <td>
                        <form action="{{route('orders.update',$i->id)}}" method="post">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                <option value="new" {{$i->status == 'new' ? 'selected' : ''}}>New</option>
                                <option value="process" {{$i->status == 'process' ? 'selected' : ''}}>Process</option>
                                <option value="ready" {{$i->status == 'ready' ? 'selected' : ''}}>Ready</option>
                            </select>
                        </form>
                    </td>
                    <td class="d-flex flex-row flex-wrap" style="gap: 0.5rem;">
                        <a href="{{route('orders.show', $i->id)}}" class="btn btn-primary btn-sm">Show</a>
                        <form action="{{route('orders.complete', $i->id)}}" method="post" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm">Complete</button>
                        </form>
                        <form action="{{route('orders.destroy', $i->id)}}" method="post" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
