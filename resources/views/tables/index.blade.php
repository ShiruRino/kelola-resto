@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
@if (Auth::user()->role === 'admin')
<a href="{{ route('tables.create') }}" class="btn btn-success btn-sm mt-5 mb-4">Create</a>
@endif

<div class="card">
    <div class="card-header">Tables</div>
    <div class="card-body d-flex flex-wrap" style="overflow-x: scroll;">
        <table class="table">
            <thead>
                <tr>
                    <th scope='col'>#</th>
                    <th>Table Number</th>
                    <th>Seats</th>
                    <th>Status</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tables as $i)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $i->table_number }}</td>
                        <td>
                            @if (Auth::user()->role === 'admin')
                            <form action="{{ route('tables.update', $i->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('PUT')
                                <input type="number" class="form-control" value="{{ $i->seats }}" name="seats" min="1" style="width: 80px; display: inline;" />
                                <button class="btn btn-success btn-sm" id="btn-seats-{{ $i->id }}" type="submit" style="display: none; padding: 0.375rem 0.75rem; font-size: 0.875rem; min-width: 75px; text-align: center;">
                                    Submit
                                </button>
                            </form>
                            @else
                            {{ $i->seats }}
                            @endif
                        </td>
                        <td>
                            @if (Auth::user()->role === 'admin')
                            <form action="{{ route('tables.update', $i->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="available" {{ $i->status == 'available' ? 'selected' : '' }}>AVAILABLE</option>
                                    <option value="unavailable" {{ $i->status == 'unavailable' ? 'selected' : '' }}>UNAVAILABLE</option>
                                </select>
                            </form>
                            @else
                            {{ Str::upper($i->status) }}
                            @endif
                        </td>
                        <td>
                            @if (Auth::user()->role === 'admin')
                            <form action="{{ route('tables.update', $i->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="location" class="form-select" onchange="this.form.submit()">
                                    <option value="indoor" {{ $i->location == 'indoor' ? 'selected' : '' }}>INDOOR</option>
                                    <option value="outdoor" {{ $i->location == 'outdoor' ? 'selected' : '' }}>OUTDOOR</option>
                                    <option value="vip" {{ $i->location == 'vip' ? 'selected' : '' }}>VIP ROOM</option>
                                </select>
                            </form>
                            @else
                            {{ Str::upper($i->location) }}
                            @endif
                        </td>
                        <td class="d-flex flex-row flex-wrap" style="gap: 0.5rem;">
                            <a href="{{ route('tables.show', $i->id) }}" class="btn btn-primary btn-sm">Show</a>
                            @if (Auth::user()->role === 'admin')
                            <form action="{{ route('tables.destroy', $i->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No tables found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $tables->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('input[name="seats"]').forEach(input => {
        input.addEventListener('input', function() {
            const btn = document.getElementById('btn-seats-' + this.closest('tr').querySelector('form').getAttribute('action').split('/').pop());
            if (this.value != this.defaultValue) {
                btn.style.display = 'inline';
            } else {
                btn.style.display = 'none';
            }
        });
    });
</script>
@endsection
