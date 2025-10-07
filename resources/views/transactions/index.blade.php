@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<a href="{{route('transactions.create')}}" class="btn btn-success mt-5 mb-4 btn-sm">Create Transaction</a>
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
<div class="card mb-5">
    <div class="card-header">Transactions</div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection
