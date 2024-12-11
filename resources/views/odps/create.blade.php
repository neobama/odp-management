@extends('layouts.app')

@section('content')
<h1 class="mb-4">Create New ODP</h1>
<form method="POST" action="{{ route('odps.store') }}" class="needs-validation" novalidate>
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="capacity" class="form-label">Capacity:</label>
        <input type="number" name="capacity" class="form-control" required>
    </div>
    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">
    <div id="map"></div>
    <p class="mt-2">Click on the map to set the ODP location.</p>
    <button type="submit" class="btn btn-success">Save</button>
    <a href="{{ route('odps.index') }}" class="btn btn-secondary">Back</a>
</form>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    const map = L.map('map').setView([-6.200000, 106.816666], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    let marker;
    map.on('click', function (e) {
        const { lat, lng } = e.latlng;
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker([lat, lng]).addTo(map);
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
    });
</script>
@endsection
