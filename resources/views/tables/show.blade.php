@extends('layouts.app')

@section('title', 'Table ' . $table->table_number)

@php
$latestOrder = $table->orders()->where('status', '!=', 'completed')->latest()->first();
$transaction = $latestOrder ? $latestOrder->transaction : null;
@endphp
@section('content')
    <a href="{{ route('tables.index') }}" class="btn btn-danger btn-sm mt-5 mb-4">Back</a>

    <div class="card mb-4">
        <div class="card-header">{{ 'Table ' . $table->table_number }}</div>
        <div class="card-body">
            <div class="list-group list-group-flush">
                <div class="list-group-item">Table Number: {{ $table->table_number }}</div>
                <div class="list-group-item">Seats: {{ $table->seats }}</div>
                <div class="list-group-item">Status: {{ $table->status }}</div>
                <div class="list-group-item">Location: {{ $table->location }}</div>
            </div>
        </div>
    </div>
    @if (!$latestOrder)
    <a href="{{route('orders.create')}}" class="btn btn-success btn-sm mb-4">Create an Order</a>
    @endif
    <div class="card mb-4">
        <div class="card-header">{{'Order ' . $table->table_number}}</div>
        <div class="card-body">
                @if ($latestOrder)
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">Order ID: {{ $latestOrder->id }}</div>
                        <div class="list-group-item">Customer: {{ $latestOrder->customer->name }}</div>
                        <div class="list-group-item">Status:
                            <form action="{{route('orders.update', $latestOrder->id)}}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select">
                                    <option value="new" {{$latestOrder->status == 'new' ? 'selected' : ''}}>NEW</option>
                                    <option value="process" {{$latestOrder->status == 'process' ? 'selected' : ''}}>PROCESS</option>
                                    <option value="ready" {{$latestOrder->status == 'ready' ? 'selected' : ''}}>READY</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total = 0;
                            @endphp
                            @foreach ($latestOrder->orderDetails as $i)
                            @php
                            $subtotal = $i->product->price * $i->quantity;
                            $total += $subtotal;
                            @endphp
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$i->product->name}}</td>
                                <td>{{$i->quantity}}</td>
                                <td>Rp{{number_format($i->product->price,0,',','.')}}</td>
                                <td>Rp{{number_format($subtotal,0,',','.')}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" class="text-end"><strong>Total</strong></td>
                                <td><strong>Rp{{number_format($total,0,',','.')}}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    @if ($transaction)
                    <div class="card mt-3">
                        <div class="card-header">Transaction</div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item">Order ID: {{ $transaction->order->id }}</div>
                                <div class="list-group-item">Total: Rp{{ number_format($transaction->total, 0, ',', '.') }}</div>

                                <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="list-group-item">
                                        Payment Status:
                                        <select name="payment_status" class="form-select">
                                            <option value="pending" {{ $transaction->payment_status == 'pending' ? 'selected' : '' }}>PENDING</option>
                                            <option value="paid" {{ $transaction->payment_status == 'paid' ? 'selected' : '' }}>PAID</option>
                                        </select>
                                    </div>

                                    <div class="list-group-item">
                                        Payment Method:
                                        <select name="payment_method" class="form-select">
                                            <option value="" >-- Select Payment Method --- </option>
                                            <option value="cash" {{ $transaction->payment_method == 'cash' ? 'selected' : '' }}>CASH</option>
                                            <option value="credit_card" {{ $transaction->payment_method == 'credit_card' ? 'selected' : '' }}>CREDIT CARD</option>
                                            <option value="e_wallet" {{ $transaction->payment_method == 'e_wallet' ? 'selected' : '' }}>E-WALLET</option>
                                        </select>
                                    </div>

                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                    @else
                    <p>No active orders for this table.</p>
                    @endif
            </div>
        </div>

@endsection
