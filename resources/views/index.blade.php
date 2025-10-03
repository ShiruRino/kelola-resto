@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="card mt-5 mb-5">
    <div class="card-header">Dashboard</div>
    <div class="card-body">Hello, {{ucfirst(Auth::user()->username)}}</div>
</div>
<div class="card mb-5">
    <div class="card-header">Data Counter</div>
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-header">Products</div>
                    <div class="card-body">
                        <p class="card-text fs-2">{{$productCount}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-header">Customers</div>
                    <div class="card-body">
                        <p class="card-text fs-2">{{$customerCount}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-header">Orders</div>
                    <div class="card-body">
                        <p class="card-text fs-2">{{$orderCount}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-header">Transactions</div>
                    <div class="card-body">
                        <p class="card-text fs-2">{{$transactionCount}}</p>
                    </div>
                </div>
            </div>
</div>
@endsection
