@extends('layouts.user')

@section('title', 'Form Setoran / Jemput')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2"><i class="fas fa-plus-circle text-success me-2"></i> Form Setoran</h1>
        <a href="{{ route('user.setoran') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('user.setoran.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    {{-- Nama & No HP --}}
                    <div class="col-md-6">
                        <label for="nama_pengirim" class="form-label">Nama Pengirim</label>
                        <input type="text" class="form-control @error('nama_pengirim') is-invalid @enderror" id="nama_pengirim" name="nama_pengirim" value="{{ old('nama_pengirim') }}" required>
                        @error('nama_pengirim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                        @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- METODE SETORAN --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">Metode Setoran</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metode" id="metodeJemput" value="jemput" {{ old('metode', 'jemput') == 'jemput' ? 'checked' : '' }} onchange="toggleMetode()">
                                <label class="form-check-label" for="metodeJemput">
                                    <i class="fas fa-truck text-primary me-1"></i> Jemput (dijemput petugas)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metode" id="metodeAntar" value="antar" {{ old('metode') == 'antar' ? 'checked' : '' }} onchange="toggleMetode()">
                                <label class="form-check-label" for="metodeAntar">
                                    <i class="fas fa-store text-success me-1"></i> Antar (ke titik kumpul)
                                </label>
                            </div>
                        </div>
                        @error('metode') <div class="text-danger small">{{ $message }}</div> @enderror

                        {{-- TAMBAHAN: INFO LOKASI ECOPOINT SAAT MODE ANTAR --}}
                        <div id="infoLokasiAntar" class="alert alert-info mt-2" style="display: none;">
                            <i class="fas fa-location-dot me-1"></i> <strong>Lokasi Titik Kumpul EcoPoint:</strong><br>
                            <span id="alamatEcoPoint">Gedung EcoPoint Indonesia, Jl. Sudirman No. 10, Jakarta Pusat</span>
                            <br>
                            <small>Koordinat: <span id="koordinatEcoPoint">{{ config('ecopoint.base_lat', -6.200000) }}, {{ config('ecopoint.base_lng', 106.816666) }}</span></small>
                            <br>
                            <a href="#" id="linkMaps" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                <i class="fab fa-google-maps me-1"></i> Buka Petunjuk Arah di Google Maps
                            </a>
                        </div>
                        {{-- END TAMBAHAN --}}
                    </div>

                    {{-- ALAMAT JEMPUT (hanya untuk metode jemput) --}}
                    <div class="col-12" id="alamatJemputWrapper">
                        <label for="alamat_jemput" class="form-label">Alamat Jemput</label>
                        <textarea class="form-control @error('alamat_jemput') is-invalid @enderror" id="alamat_jemput" name="alamat_jemput" rows="2">{{ old('alamat_jemput') }}</textarea>
                        @error('alamat_jemput') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- PETA & KOORDINAT --}}
                    <div class="col-12" id="petaWrapper">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-bold mb-0">Pilih Lokasi di Peta</label>
                            <button type="button" id="btnGeolocation" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-location-dot me-1"></i> Gunakan Lokasi Saya
                            </button>
                        </div>
                        <div class="mb-2" style="position: relative;">
                            <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Cari alamat (maks. 20 km)...">
                            <div id="autocomplete-list" class="list-group" style="position: absolute; width: 100%; z-index: 1000; background: white; border: 1px solid #ddd; display: none; max-height: 200px; overflow-y: auto;"></div>
                        </div>
                        <div id="map" style="height: 350px; border-radius: 10px; border: 1px solid #ddd;"></div>
                        <small class="text-secondary" id="infoKoordinat">
                            Lat: {{ old('latitude', config('ecopoint.base_lat', -6.200000)) }}, 
                            Lng: {{ old('longitude', config('ecopoint.base_lng', 106.816666)) }}
                        </small>
                        @error('latitude') <div class="text-danger small">{{ $message }}</div> @enderror
                        @error('longitude') <div class="text-danger small">{{ $message }}</div> @enderror
                        <div id="geolocationStatus" class="small mt-1"></div>
                    </div>

                    {{-- Hidden koordinat --}}
                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', config('ecopoint.base_lat', -6.200000)) }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', config('ecopoint.base_lng', 106.816666)) }}">

                    {{-- JENIS SAMPAH --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">Jenis Sampah & Berat (kg)</label>
                        <div class="row g-2" id="jenisSampahContainer">
                            @if(isset($jenisSampahs) && count($jenisSampahs) > 0)
                                @foreach($jenisSampahs as $js)
                                    <div class="col-md-4">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">
                                                <input type="checkbox" class="form-check-input mt-0" 
                                                       id="check_{{ $js->id }}" 
                                                       onchange="toggleBerat({{ $js->id }})">
                                            </span>
                                            <span class="input-group-text">{{ $js->nama }}</span>
                                            <input type="number" step="0.1" min="0" 
                                                   class="form-control berat-input" 
                                                   id="berat_{{ $js->id }}" 
                                                   name="jenis_sampah_data[{{ $js->id }}]" 
                                                   value="{{ old('jenis_sampah_data.' . $js->id, 0) }}" 
                                                   disabled>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                {{-- PERUBAHAN: PESAN LEBIH RAMAH PENGGUNA --}}
                                <div class="col-12 text-muted">
                                    <i class="far fa-frown me-1"></i> Maaf, pilihan jenis sampah belum tersedia saat ini.
                                </div>
                            @endif
                        </div>
                        @error('jenis_sampah_data') 
                            <div class="text-danger small">{{ $message }}</div> 
                        @enderror
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i> Ajukan Penjemputan</button>
                        <a href="{{ route('user.setoran') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    function toggleBerat(id) {
        const checkbox = document.getElementById('check_' + id);
        const beratInput = document.getElementById('berat_' + id);
        beratInput.disabled = !checkbox.checked;
        if (!checkbox.checked) beratInput.value = 0;
        else beratInput.focus();
    }

    function toggleMetode() {
        const metodeJemput = document.getElementById('metodeJemput').checked;
        const alamatWrapper = document.getElementById('alamatJemputWrapper');
        const petaWrapper = document.getElementById('petaWrapper');
        const infoLokasiAntar = document.getElementById('infoLokasiAntar');
        const alamatInput = document.getElementById('alamat_jemput');
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        if (metodeJemput) {
            alamatWrapper.style.display = 'block';
            petaWrapper.style.display = 'block';
            infoLokasiAntar.style.display = 'none';
            alamatInput.required = true;
        } else {
            alamatWrapper.style.display = 'none';
            petaWrapper.style.display = 'none';
            infoLokasiAntar.style.display = 'block';
            alamatInput.required = false;
            
            // Set koordinat ke pusat EcoPoint
            const baseLat = {{ config('ecopoint.base_lat', -6.200000) }};
            const baseLng = {{ config('ecopoint.base_lng', 106.816666) }};
            latInput.value = baseLat;
            lngInput.value = baseLng;
            
            // Update link Google Maps otomatis
            const linkMaps = document.getElementById('linkMaps');
            linkMaps.href = `https://www.google.com/maps/dir/?api=1&destination=${baseLat},${baseLng}`;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi Tampilan Sesuai Metode
        toggleMetode();

        // Konfigurasi Radius Maksimal
        const MAX_RADIUS = 20; // Kilometer
        const baseLatPusat = {{ config('ecopoint.base_lat', -6.200000) }};
        const baseLngPusat = {{ config('ecopoint.base_lng', 106.816666) }};

        const defaultLat = parseFloat(document.getElementById('latitude').value) || baseLatPusat;
        const defaultLng = parseFloat(document.getElementById('longitude').value) || baseLngPusat;

        const map = L.map('map').setView([defaultLat, defaultLng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);
        window.mapInstance = map;
        window.mapInstance.marker = marker;

        function updatePosition(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
            document.getElementById('infoKoordinat').innerHTML =
                'Lat: ' + lat.toFixed(6) + ', Lng: ' + lng.toFixed(6);
        }

        marker.on('dragend', function (e) {
            const pos = marker.getLatLng();
            updatePosition(pos.lat, pos.lng);
        });

        map.on('click', function (e) {
            const latlng = e.latlng;
            marker.setLatLng(latlng);
            updatePosition(latlng.lat, latlng.lng);
        });

        function haversine(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat/2) ** 2 + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon/2) ** 2;
            return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        }

        // Search Autocomplete (dengan filter radius 20 km)
        const searchInput = document.getElementById('searchInput');
        const autoList = document.getElementById('autocomplete-list');

        searchInput.addEventListener('input', function() {
            const query = this.value;
            if (query.length < 3) {
                autoList.style.display = 'none';
                return;
            }

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&limit=5&countrycodes=ID`, {
                headers: { 'User-Agent': 'EcoPoint-Localhost' }
            })
            .then(response => response.json())
            .then(data => {
                autoList.innerHTML = ''; 
                let validResults = 0;

                data.forEach(item => {
                    const lat = parseFloat(item.lat);
                    const lng = parseFloat(item.lon);
                    
                    const distance = haversine(lat, lng, baseLatPusat, baseLngPusat);

                    if (distance <= MAX_RADIUS) {
                        validResults++;
                        const div = document.createElement('div');
                        div.className = 'list-group-item list-group-item-action';
                        div.style.cursor = 'pointer';
                        div.style.padding = '8px 12px';
                        div.textContent = item.display_name;
                        div.innerHTML += ` <small class="text-muted">(${distance.toFixed(1)} km)</small>`;

                        div.addEventListener('click', function() {
                            if (haversine(lat, lng, baseLatPusat, baseLngPusat) > MAX_RADIUS) {
                                alert(`Maaf, lokasi ini di luar radius ${MAX_RADIUS} km.`);
                                autoList.style.display = 'none';
                                return;
                            }

                            marker.setLatLng([lat, lng]);
                            map.setView([lat, lng], 15);
                            updatePosition(lat, lng);
                            
                            searchInput.value = item.display_name;
                            autoList.style.display = 'none';
                        });
                        autoList.appendChild(div);
                    }
                });

                if (validResults === 0) {
                    const div = document.createElement('div');
                    div.className = 'list-group-item text-warning';
                    div.textContent = `Tidak ada lokasi valid dalam radius ${MAX_RADIUS} km.`;
                    autoList.appendChild(div);
                }
                autoList.style.display = 'block';
            })
            .catch(error => {
                console.error("Error API:", error);
                autoList.innerHTML = `<div class="list-group-item text-danger">Gagal terhubung ke server pencarian.</div>`;
                autoList.style.display = 'block';
            });
        });

        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !autoList.contains(e.target)) {
                autoList.style.display = 'none';
            }
        });

        // Geolokasi
        const btnGeo = document.getElementById('btnGeolocation');
        const statusDiv = document.getElementById('geolocationStatus');

        btnGeo.addEventListener('click', function () {
            statusDiv.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mendapatkan lokasi...';

            if (!navigator.geolocation) {
                statusDiv.innerHTML = `<span class="text-danger"><i class="fas fa-exclamation-circle"></i> Browser tidak mendukung geolokasi.</span>`;
                return;
            }

            navigator.geolocation.getCurrentPosition(
                function (pos) {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    
                    const distance = haversine(lat, lng, baseLatPusat, baseLngPusat);
                    if (distance > MAX_RADIUS) {
                        statusDiv.innerHTML = `<span class="text-danger"><i class="fas fa-exclamation-circle"></i> Lokasi Anda di luar jangkauan (${distance.toFixed(1)} km).</span>`;
                        return;
                    }

                    marker.setLatLng([lat, lng]);
                    map.setView([lat, lng], 15);
                    updatePosition(lat, lng);
                    statusDiv.innerHTML = `<span class="text-success"><i class="fas fa-check-circle"></i> Lokasi berhasil didapatkan (${distance.toFixed(1)} km).</span>`;
                },
                function (error) {
                    let msg = 'Gagal mengambil lokasi.';
                    if (error.code === error.PERMISSION_DENIED) msg = 'Izin lokasi ditolak.';
                    statusDiv.innerHTML = `<span class="text-danger"><i class="fas fa-exclamation-circle"></i> ${msg}</span>`;
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        });
    });
</script>
@endsection