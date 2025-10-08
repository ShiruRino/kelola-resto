@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
@if (session('success'))
<div class="alert alert-success mb-4">
    {{session('success')}}
</div>
@endif
@if($errors->any())
@foreach ($errors as $i)
<div class="alert alert-danger mb-4">
    {{$i}}
</div>
@endforeach
@endif
<div class="card mt-5 mb-5">
    <div class="card-header">Transactions</div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Total</th>
                    <th scope="col">Payment Status</th>
                    <th scope="col">Payment Method</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $i)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>{{$i->order->id}}</td>
                    <td>{{$i->order->customer->name}}</td>
                    <td>Rp{{number_format($i->total, 0, ',', '.')}}</td>
                    <td>
                        <form action="{{route('transactions.update',$i->id)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="payment_status" class="form-select" onchange="this.form.submit()">
                                <option value="pending" {{$i->payment_status == 'pending' ? 'selected' : ''}}>PENDING</option>
                                <option value="paid" {{$i->payment_status == 'paid' ? 'selected' : ''}}>PAID</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        @if ($i->payment_status == 'paid')
                        <form action="{{route('transactions.update',$i->id)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="payment_method" class="form-select" onchange="this.form.submit()">
                                <option value="cash" {{$i->payment_method == 'cash' ? 'selected' : ''}}>CASH</option>
                                <option value="credit_card" {{$i->payment_method == 'credit_card' ? 'selected' : ''}}>CREDIT CARD</option>
                                <option value="debit_card" {{$i->payment_method == 'debit_card' ? 'selected' : ''}}>DEBIT CARD</option>
                                <option value="mobile" {{$i->payment_method == 'mobile' ? 'selected' : ''}}>MOBILE</option>
                            </select>
                        </form>
                        @else
                        N/A
                        @endif
                    </td>
                    <td class="d-flex flex-row flex-wrap" style="gap: 0.5rem;">
                        <a href="{{route('transactions.show', $i->id)}}" class="btn btn-primary btn-sm">Show</a>
                        <form action="{{route('transactions.destroy', $i->id)}}" method="post" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
