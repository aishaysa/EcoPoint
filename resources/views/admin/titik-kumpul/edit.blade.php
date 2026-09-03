@extends('layouts.admin')

@section('title', 'Edit Titik Kumpul')
@section('page_title', 'Edit Titik Kumpul')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 350px; width: 100%; border-radius: 8px; border: 1px solid #d1d9e0; margin-top: 5px; }
    .form-group { margin-bottom: 1rem; }
    .form-label { display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem; }
    .form-control { width: 100%; padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; }
    .form-control:focus { outline: none; border-color: #059669; box-shadow: 0 0 0 3px rgba(5,150,105,0.25); }
    .form-control:read-only { background-color: #f3f4f6; }
    .btn { padding: 0.5rem 1.5rem; border-radius: 0.5rem; font-weight: 500; transition: all 0.15s; cursor: pointer; border: none; }
    .btn-primary { background-color: #059669; color: white; }
    .btn-primary:hover { background-color: #047857; }
    .btn-secondary { background-color: #e5e7eb; color: #374151; }
    .btn-secondary:hover { background-color: #d1d5db; }
    .text-danger { color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem; }
    .coord-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-top: 0.5rem; }
    .coord-label { display: block; font-size: 0.7rem; color: #6b7280; }
    .alert-error { background-color: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1rem; }
    .card { background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 1.5rem; max-width: 640px; }
    .search-results { position: absolute; z-index: 9999; background: white; border: 1px solid #d1d5db; border-radius: 0.5rem; max-height: 200px; overflow-y: auto; width: calc(100% - 2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); display: none; }
    .search-results .result-item { padding: 0.5rem 1rem; cursor: pointer; border-bottom: 1px solid #f3f4f6; }
    .search-results .result-item:hover { background-color: #f0fdf4; }
    .search-wrapper { position: relative; }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="card mx-auto">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Edit Titik Kumpul</h2>
        <p class="text-sm text-gray-500 mb-6">Ubah data titik kumpul.</p>

        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.titik-kumpul.update', $titikKumpul->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="nama">Nama <span class="text-red-500">*</span></label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $titikKumpul->nama) }}" required class="form-control">
                @error('nama') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="alamat">Alamat</label>
                <div class="search-wrapper">
                    <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $titikKumpul->alamat) }}" class="form-control" placeholder="Cari alamat..." autocomplete="off">
                    <div id="searchResults" class="search-results"></div>
                </div>
                @error('alamat') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Lokasi di Peta</label>
                <div id="map"></div>
                <div class="coord-grid">
                    <div>
                        <label class="coord-label">Latitude</label>
                        <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $titikKumpul->latitude ?? '-6.2088') }}" class="form-control" readonly>
                    </div>
                    <div>
                        <label class="coord-label">Longitude</label>
                        <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $titikKumpul->longitude ?? '106.8456') }}" class="form-control" readonly>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-1">
                    Klik peta atau geser marker untuk menentukan lokasi.
                </p>
            </div>

            <div class="form-group">
                <label class="form-label" for="kontak">Kontak</label>
                <input type="text" id="kontak" name="kontak" value="{{ old('kontak', $titikKumpul->kontak) }}" class="form-control">
                @error('kontak') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            {{-- Status Aktif --}}
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="flex items-center" style="cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $titikKumpul->is_active) ? 'checked' : '' }}
                           style="width: 1rem; height: 1rem; color: #059669; border-color: #d1d5db; border-radius: 0.25rem;">
                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                </label>
            </div>

            <div class="flex space-x-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.titik-kumpul.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const defaultLat = parseFloat(document.getElementById('latitude').value) || -6.2088;
        const defaultLng = parseFloat(document.getElementById('longitude').value) || 106.8456;
        const center = [defaultLat, defaultLng];

        const map = L.map('map').setView(center, 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        const marker = L.marker(center, { draggable: true }).addTo(map);

        marker.on('dragend', function() {
            const pos = marker.getLatLng();
            document.getElementById('latitude').value = pos.lat.toFixed(8);
            document.getElementById('longitude').value = pos.lng.toFixed(8);
        });

        map.on('click', function(e) {
            const pos = e.latlng;
            marker.setLatLng(pos);
            document.getElementById('latitude').value = pos.lat.toFixed(8);
            document.getElementById('longitude').value = pos.lng.toFixed(8);
        });

        const input = document.getElementById('alamat');
        const resultsContainer = document.getElementById('searchResults');
        let searchTimeout;

        input.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            if (query.length < 3) {
                resultsContainer.style.display = 'none';
                return;
            }
            searchTimeout = setTimeout(function() {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&limit=5`)
                    .then(response => response.json())
                    .then(data => {
                        resultsContainer.innerHTML = '';
                        if (data.length === 0) {
                            resultsContainer.style.display = 'none';
                            return;
                        }
                        data.forEach(function(item) {
                            const div = document.createElement('div');
                            div.className = 'result-item';
                            div.textContent = item.display_name;
                            div.addEventListener('click', function() {
                                const lat = parseFloat(item.lat);
                                const lng = parseFloat(item.lon);
                                const center = [lat, lng];
                                map.setView(center, 15);
                                marker.setLatLng(center);
                                document.getElementById('latitude').value = lat.toFixed(8);
                                document.getElementById('longitude').value = lng.toFixed(8);
                                document.getElementById('alamat').value = item.display_name;
                                resultsContainer.style.display = 'none';
                            });
                            resultsContainer.appendChild(div);
                        });
                        resultsContainer.style.display = 'block';
                    })
                    .catch(function() {
                        resultsContainer.style.display = 'none';
                    });
            }, 500);
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.search-wrapper')) {
                resultsContainer.style.display = 'none';
            }
        });
    });
</script>
@endpush