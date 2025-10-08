@extends('layouts.app')
@section('title', 'Activity Logs')
@section('content')
    <div class="card mt-5">
        <div class="card-header">Activity Logs</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope="col">User</th>
                        <th scope="col">Action</th>
                        <th scope="col">Table Name</th>
                        <th scope="col">Record ID</th>
                        <th scope="col">Description</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($histories as $i)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$i->user->username}}</td>
                        <td>{{$i->action}}</td>
                        <td>{{$i->table_name}}</td>
                        <td>{{$i->record_id}}</td>
                        <td>{{$i->description}}</td>
                        <td>{{$i->created_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $histories->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
