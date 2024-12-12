@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Manage Clients for ODP: {{ $odp->name }}</h1>

    <!-- Form Tambah Klien -->
    <div class="card mb-4">
        <div class="card-header">
            <h4>Add New Client</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('clients.store', $odp->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Client Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter client name" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Client</button>
            </form>
        </div>
    </div>

    <!-- List Klien -->
    <div class="card">
        <div class="card-header">
            <h4>Existing Clients</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>
                                <!-- Form Update Klien -->
                                <form action="{{ route('clients.update', $client->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" name="name" value="{{ $client->name }}" class="form-control-sm">
                                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                                </form>

                                <!-- Form Hapus Klien -->
                                <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this client?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
