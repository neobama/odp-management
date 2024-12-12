@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Manage ODPs</h1>

    <!-- Peta -->
    <div id="map" style="height: 500px; border: 1px solid #ccc;" class="mb-4"></div>
    <!-- Form Tambah ODP -->
    <div class="card mb-4">
        <div class="card-header">
            <h4>Add New ODP</h4>
        </div>
        <div class="card-body">
            <form id="odpForm" action="{{ route('odps.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">ODP Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter ODP name" required>
                </div>
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
                <div class="text-muted mb-3">
                    Click on the map to select ODP location. Latitude and Longitude will be auto-filled.
                </div>
                <div class="col-md-4 mb-3">
                  <label for="capacity" class="form-label">Capacity</label>
                  <input type="number" class="form-control" id="capacity" name="capacity" placeholder="16" value="16" required>
                 </div>
                <button type="submit" class="btn btn-primary" id="addOdpButton" disabled>Add ODP</button>
            </form>
        </div>
    </div>
    <!-- List ODPs -->
    <h2>List of ODPs</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Capacity</th>
                <th>Clients</th>
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
                    <td>{{ $odp->clients_count }}</td>
                    <td>
                        <!-- Tombol Manage Clients -->
                        <a href="{{ route('clients.manage', $odp->id) }}" class="btn btn-primary btn-sm">Manage Clients</a>

                        <!-- Form Delete ODP -->
                        <form action="{{ route('odps.destroy', $odp->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this ODP?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inisialisasi peta
        var map = L.map('map').setView([-6.2, 106.8], 13); // Default ke Jakarta

        // Tambahkan tile layer dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan marker ODP yang sudah ada
        var odps = @json($odps);
        odps.forEach(function(odp) {
            if (odp.latitude && odp.longitude) {
                L.marker([odp.latitude, odp.longitude])
                    .addTo(map)
                    .bindPopup(`<strong>${odp.name}</strong><br>Capacity: ${odp.capacity}`);
            }
        });

        // Marker baru untuk lokasi ODP
        var newMarker;
        map.on('click', function(e) {
            // Hapus marker sebelumnya jika ada
            if (newMarker) {
                map.removeLayer(newMarker);
            }

            // Tambahkan marker baru di lokasi yang diklik
            newMarker = L.marker(e.latlng).addTo(map);

            // Isi latitude dan longitude ke input form
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;

            // Aktifkan tombol submit
            document.getElementById('addOdpButton').disabled = false;
        });
    });
</script>
@endsection
