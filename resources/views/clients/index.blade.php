@extends('layouts.app')

@section('content')
<h1>Clients in {{ $odp->name }}</h1>
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<a href="{{ route('odps.index') }}" class="btn btn-secondary mb-4">Back to ODP List</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Client Name</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($clients as $client)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $client->name }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2">No clients found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<h2>Add New Client</h2>
<form method="POST" action="{{ route('clients.store', $odp) }}">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Client Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Add Client</button>
</form>
@endsection
