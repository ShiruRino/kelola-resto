@extends('layouts.app')
@section('title', 'Table ' . $order->table_number . ' - ' . $order->customer->name)
@section('content')
<a href="{{route('orders.index')}}" class="btn btn-danger mt-5 mb-5 btn-sm">Back</a>
<div class="card mb-4">
    <div class="card-header">{{"Table " . $order->table_number . ' - ' . $order->customer->name}}</div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            <div class="list-group-item">
                Table Number: {{$order->table->table_number}}
            </div>
            <div class="list-group-item">
                Customer: {{$order->customer->name}}
            </div>
            <div class="list-group-item">
                Status:
                <form action="{{route('orders.update',$order->id)}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm w-auto d-inline">
                        <option value="new" {{$order->status == 'new' ? 'selected' : ''}}>NEW</option>
                        <option value="process" {{$order->status == 'process' ? 'selected' : ''}}>PROCESS</option>
                        <option value="ready" {{$order->status == 'ready' ? 'selected' : ''}}>READY</option>
                    </select>
                </form>
            </div>
            <div class="list-group-item">
                User: {{$order->user->username}}
            </div>
        </div>
    </div>
</div>
<div class="card mb-5">
    <div class="card-header">Order Details</div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope='col'>#</th>
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
                @foreach ($order->orderDetails as $i)
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
    </div>
</div>
@endsection
