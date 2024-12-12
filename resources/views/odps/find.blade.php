@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Find Nearest ODP</h1>
    <p>Drag the marker to your desired location to find the nearest ODP.</p>

    <!-- Map Container -->
    <div id="find-map" style="height: 500px; border: 1px solid #ccc;" class="mb-4"></div>

    <!-- Form untuk menyimpan koordinat -->
    <form id="find-odp-form" class="mt-4">
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <button type="button" id="find-odp-btn" class="btn btn-primary">Find Nearest ODP</button>
    </form>

    <!-- Hasil -->
    <div id="odp-result" class="mt-4"></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const mapDiv = document.getElementById('find-map');
        // Inisialisasi peta
        const map = L.map('find-map').setView([-6.200054, 106.856697], 20);

        // Tambahkan tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);


        let marker = L.marker([-6.200054, 106.856697]).addTo(map);

        // Fungsi untuk mengupdate posisi marker dan koordinat di input
        function updateMarker(lat, lng) {
            if (marker) {
                map.removeLayer(marker); // Hapus marker lama
            }
            marker = L.marker([lat, lng]).addTo(map); // Tambahkan marker baru
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            console.log(`Marker updated to: ${lat}, ${lng}`);
        }

        // Event click pada map untuk memindahkan marker
        map.on('click', function (e) {
            const { lat, lng } = e.latlng; // Dapatkan koordinat klik
            updateMarker(lat, lng); // Perbarui marker dan input
        });

        // Tombol Find Nearest ODP
        document.getElementById('find-odp-btn').addEventListener('click', async function () {
            const latitude = document.getElementById('latitude').value;
            const longitude = document.getElementById('longitude').value;

            if (!latitude || !longitude) {
                alert('Please drag the marker to select a location.');
                return;
            }

            try {
                const response = await fetch("{{ route('find.nearest.odp') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ latitude, longitude })
                });

                const data = await response.json();

                if (response.ok) {
                    document.getElementById('odp-result').innerHTML = `
                        <div class="alert alert-success">
                            Nearest ODP: <strong>${data.odp.name}</strong><br>
                            Point-to-Point Distance: <strong>${data.distance} km</strong>
                        </div>
                    `;
                } else {
                    document.getElementById('odp-result').innerHTML = `
                        <div class="alert alert-danger">${data.message}</div>
                    `;
                }
            } catch (error) {
                document.getElementById('odp-result').innerHTML = `
                    <div class="alert alert-danger">Something went wrong. Please try again later.</div>
                `;
            }
        });
    });
</script>
@endsection
