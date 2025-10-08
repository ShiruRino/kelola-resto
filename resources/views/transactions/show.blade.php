@extends('layouts.app')
@section('title', 'Transaction ' . $transaction->id . ' - ' . $transaction->order->customer->name)
@section('content')
<a href="{{route('transactions.index')}}" class="btn btn-danger mt-5 mb-4">Back</a>
@if (session('success'))
<div class="alert alert-success mb-4">
    {{session('success')}}
</div>
@endif
<div class="card mb-5">
    <div class="card-header">{{'Transaction ' . $transaction->id . ' - ' . $transaction->order->customer->name}}</div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            <div class="list-group-item">Order ID: {{$transaction->order->id}}</div>
            <div class="list-group-item">Total: Rp{{number_format($transaction->total, 0, ',', '.')}}</div>
            <div class="list-group-item">Payment Status: <form action="{{route('transactions.update', $transaction->id)}}" onchange="this.form.submit()" method="post">
                @csrf
                @method('PATCH')
                <select name="payment_status">
                    <option value="pending" {{$transaction->payment_status == 'pending' ? 'selected' : ''}}>PENDING</option>
                    <option value="paid" {{$transaction->payment_status == 'paid' ? 'selected' : ''}}>PAID</option>
                    <option value="failed" {{$transaction->payment_status == 'failed' ? 'selected' : ''}}>FAILED</option>
                </select>
            </form></div>
            <div class="list-group-item">Payment Method: <form action="{{route('transactions.update', $transaction->id)}}" onchange="this.form.submit()" method="POST">
                @csrf
                @method('PATCH')
                <select name="payment_method">
                    <option value="cash" {{$transaction->payment_method == 'cash' ? 'selected' : ''}}>CASH</option>
                    <option value="credit_card" {{$transaction->payment_method == 'credit_card' ? 'selected' : ''}}>CREDIT CARD</option>
                    <option value="e_wallet" {{$transaction->payment_method == 'e_wallet' ? 'selected' : ''}}>E-WALLET</option>
                </select>
            </form></div>
        </div>
    </div>
</div>
@endsection
