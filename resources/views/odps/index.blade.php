@extends('layouts.app')

@section('content')
<h1 class="mb-4">ODP List</h1>

<a href="{{ route('odps.create') }}" class="btn btn-primary mb-4">Add New ODP</a>

<div id="map" style="height: 500px; margin-bottom: 20px;"></div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Capacity</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($odps as $odp)
            <tr>
                <td>{{ $odp->name }}</td>
                <td>{{ $odp->latitude }}</td>
                <td>{{ $odp->longitude }}</td>
                <td>{{ $odp->capacity }}</td>
                <td>
                    <a href="{{ route('clients.index', $odp) }}" class="btn btn-info btn-sm">View Clients</a>
                    <a href="{{ route('odps.edit', $odp) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('odps.destroy', $odp) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    const map = L.map('map').setView([-6.200000, 106.816666], 13); // Default lokasi Jakarta

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    @foreach ($odps as $odp)
        L.marker([{{ $odp->latitude }}, {{ $odp->longitude }}]).addTo(map)
            .bindPopup("{{ $odp->name }} ({{ $odp->capacity }} slots)");
    @endforeach
</script>
@endsection
