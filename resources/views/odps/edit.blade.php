@extends('layouts.app')

@section('content')
<h1 class="mb-4">Edit ODP</h1>

<form method="POST" action="{{ route('odps.update', $odp) }}" class="needs-validation" novalidate>
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input type="text" name="name" value="{{ $odp->name }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="capacity" class="form-label">Capacity:</label>
        <input type="number" name="capacity" value="{{ $odp->capacity }}" class="form-control" required>
    </div>

    <input type="hidden" name="latitude" id="latitude" value="{{ $odp->latitude }}">
    <input type="hidden" name="longitude" id="longitude" value="{{ $odp->longitude }}">

    <div id="map" style="height: 500px; margin-bottom: 20px;"></div>
    <p>Drag the marker to update the ODP location.</p>

    <button type="submit" class="btn btn-success">Update</button>
    <a href="{{ route('odps.index') }}" class="btn btn-secondary">Back</a>
</form>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    const map = L.map('map').setView([{{ $odp->latitude }}, {{ $odp->longitude }}], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    let marker = L.marker([{{ $odp->latitude }}, {{ $odp->longitude }}], { draggable: true }).addTo(map);

    marker.on('dragend', function (e) {
        const { lat, lng } = marker.getLatLng();
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
    });
</script>
@endsection
