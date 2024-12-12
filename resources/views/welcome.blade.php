@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Summary ODP Management</h1>

    <!-- Summary Cards -->
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total ODP</h5>
                    <p class="card-text">{{ $totalOdps }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Clients</h5>
                    <p class="card-text">{{ $totalClients }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Full ODPs</h5>
                    <p class="card-text">{{ $fullOdps }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('home') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Search ODP or Client" value="{{ request('query') }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <!-- ODP Tables -->
    <h2 class="mb-4">Clients in ODPs</h2>
    <div class="row">
        @forelse ($odps as $index => $odp)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <strong>{{ $odp->name }}</strong>
                        <span class="badge {{ $odp->clients_count >= $odp->capacity ? 'bg-danger' : 'bg-success' }}">
                            {{ $odp->clients_count }}/{{ $odp->capacity }}
                        </span>
                    </div>
                    <div class="card-body">
                        @if ($odp->clients->isEmpty())
                            <p>No clients added yet.</p>
                        @else
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Client Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($odp->clients as $client)
                                        <tr>
                                            <td>{{ $client->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                        <a href="{{ route('clients.manage', $odp->id) }}" class="btn btn-primary btn-sm">Manage ODP</a>
                    </div>
                </div>
            </div>

            <!-- Baris baru setelah setiap 3 tabel -->
            @if (($index + 1) % 3 == 0)
                </div><div class="row">
            @endif
        @empty
            <div class="col-12">
                <p class="text-center">No ODPs or Clients match your search.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
