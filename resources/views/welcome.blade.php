@extends('layouts.app')

@section('content')
<h1>Welcome to ODP Management</h1>
<div class="row">
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
                <h5 class="card-title">Full ODP</h5>
                <p class="card-text">{{ $fullOdps }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
