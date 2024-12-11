@extends('layouts.app')

@section('content')
<h1 class="mb-4">ODP Summary</h1>

<!-- Summary Total ODP dan Klien -->
<div class="row mb-4">
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

<!-- Form Pencarian -->
<form method="GET" action="{{ route('home') }}" class="mb-4">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search ODP or Client" value="{{ $search ?? '' }}">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>

<!-- Peta -->
<div id="map" style="height: 500px; margin-bottom: 20px;"></div>

<!-- Daftar ODP dan Klien -->
@foreach ($odps as $odp)
    <h3>{{ $odp->name }} ({{ $odp->clients_count }}/{{ $odp->capacity }})</h3>
    <table class="table table-bordered mb-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Client Name</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($odp->clients as $client)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $client->name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No clients in this ODP.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endforeach

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    const map = L.map('map').setView([-6.200000, 106.816666], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    @foreach ($odps as $odp)
        const isFull = {{ $odp->clients_count }} >= {{ $odp->capacity }};
        const markerColor = isFull ? 'red' : 'green';

        const markerIcon = L.divIcon({
            className: 'custom-div-icon',
            html: `<div style="background-color:${markerColor}; width:20px; height:20px; border-radius:50%;"></div>`,
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });

        L.marker([{{ $odp->latitude }}, {{ $odp->longitude }}], { icon: markerIcon }).addTo(map)
            .bindPopup(`
                <strong>{{ $odp->name }}</strong><br>
                Capacity: {{ $odp->capacity }}<br>
                Clients: {{ $odp->clients_count }}
            `);
    @endforeach
</script>
@endsection
