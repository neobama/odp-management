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

    <!-- ODP and Client List -->
    <div class="card">
        <div class="card-header bg-secondary text-white">
            List of ODPs and Clients
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ODP Name</th>
                        <th>Total Clients</th>
                        <th>Capacity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($odps as $odp)
                        <tr>
                            <td>{{ $odp->name }}</td>
                            <td>{{ $odp->clients_count }}</td>
                            <td>{{ $odp->capacity }}</td>
                            <td>
                                <a href="{{ route('odps.show', $odp->id) }}" class="btn btn-info btn-sm">View Clients</a>
                                <a href="{{ route('odps.edit', $odp->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
