
@section('title', 'Form Setoran')
@section('page_title', 'Form Setoran')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    /* ============================================================
       GLOBAL – SERAGAM DENGAN LAYOUT USER
    ============================================================ */

    .setoran-page {
        width: 100%;
        min-height: 100vh;
        background: #f0f7f2;   /* sama dengan background body di layout */
        padding: 28px 22px 50px;
    }

    .setoran-container {
        width: 100%;
        max-width: 1020px;
        margin: 0 auto;
    }

    .setoran-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
    }

    .setoran-title {
        margin: 0;
        font-size: 1.7rem;
        font-weight: 800;
        color: #0d2b1f;          /* hijau gelap */
    }

    .setoran-subtitle {
        margin-top: 4px;
        color: #2d5a43;          /* hijau sedang */
        font-size: 0.8rem;
    }

    .setoran-back {
        text-decoration: none;
        padding: 9px 14px;
        border: 1px solid #cde0d3;
        border-radius: 10px;
        background: #fff;
        color: #2d5a43;
        font-weight: 600;
        transition: 0.2s;
    }
    .setoran-back:hover {
        background: #e8f5e9;
        border-color: #6fcf97;
    }

    /* CARD */
    .setoran-card {
        background: #ffffff;
        border: 1px solid #d4e8db;
        border-radius: 24px;
        box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .setoran-body {
        padding: 28px 32px;
    }

    .section {
        padding-bottom: 26px;
        margin-bottom: 26px;
        border-bottom: 1px solid #d4e8db;
    }
    .section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: 0;
    }

    .section-title {
        margin-bottom: 16px;
        font-size: 0.95rem;
        font-weight: 700;
        color: #0d2b1f;
        letter-spacing: 0.3px;
    }

    /* FIELD */
    .field label {
        display: block;
        margin-bottom: 7px;
        font-size: 0.74rem;
        font-weight: 700;
        color: #1a3d2e;
    }

    .input,
    .select,
    .textarea {
        width: 100%;
        border: 1px solid #d4e8db;
        border-radius: 16px;
        background: #fafffc;
        padding: 10px 14px;
        font-size: 0.8rem;
        color: #1a2e24;
        outline: none;
        transition: 0.2s;
    }
    .input:focus,
    .select:focus,
    .textarea:focus {
        background: #ffffff;
        border-color: #2e7d5a;
        box-shadow: 0 0 0 4px rgba(46,125,90,0.12);
    }
    .readonly {
        background: #edf5f0 !important;
        color: #2d5a43;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    /* METODE RADIO */
    .method-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }
    .method-input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }
    .method-label {
        display: block;
        padding: 15px;
        border: 1px solid #d4e8db;
        border-radius: 16px;
        cursor: pointer;
        transition: 0.2s ease;
        background: #fafffc;
    }
    .method-input:checked + .method-label {
        border-color: #2e7d5a;
        background: #e8f5e9;
        box-shadow: 0 0 0 3px rgba(46,125,90,0.15);
    }
    .method-label strong {
        display: block;
        font-size: 0.8rem;
        color: #0d2b1f;
        margin-bottom: 3px;
    }
    .method-label span {
        font-size: 0.68rem;
        color: #4d7a63;
    }

    /* LOKASI */
    .location-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-bottom: 12px;
    }
    .location-button {
        border: 1px solid #b8d9c8;
        border-radius: 40px;
        background: #ffffff;
        color: #0d2b1f;
        padding: 9px 16px;
        font-size: 0.7rem;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
    }
    .location-button:hover {
        background: #2e7d5a;
        color: white;
        border-color: #2e7d5a;
    }
    .location-status {
        margin-bottom: 12px;
        font-size: 0.7rem;
        color: #2d5a43;
        font-weight: 500;
    }

    /* MAP */
    #map {
        width: 100%;
        height: 320px;
        border-radius: 16px;
        border: 1px solid #d4e8db;
    }
    .coordinate-text {
        margin-top: 9px;
        font-size: 0.68rem;
        color: #4d7a63;
    }

    /* CABANG TERDEKAT */
    .branch-info {
        display: none;
        margin-top: 12px;
        padding: 12px 16px;
        border-radius: 12px;
        background: #e8f5e9;
        border-left: 4px solid #2e7d5a;
    }
    .branch-info strong {
        color: #0d2b1f;
    }
    .branch-info small {
        display: block;
        color: #2d5a43;
        margin-top: 2px;
    }

    /* TITIK KUMPUL INFO */
    .pickup-info {
        display: none;
        margin-top: 12px;
        padding: 12px 16px;
        border-left: 4px solid #2e7d5a;
        background: #e8f5e9;
        border-radius: 12px;
    }
    .pickup-info strong {
        color: #0d2b1f;
    }
    .pickup-info div {
        margin-top: 2px;
        font-size: 0.75rem;
        color: #1a3d2e;
    }
    .maps-button {
        display: inline-block;
        margin-top: 9px;
        padding: 6px 14px;
        border-radius: 40px;
        background: #2e7d5a;
        color: white;
        text-decoration: none;
        font-size: 0.7rem;
        font-weight: 700;
        transition: 0.2s;
    }
    .maps-button:hover {
        background: #1a4532;
        color: white;
    }

    /* JENIS SAMPAH */
    .sampah-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }
    .sampah-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 11px 14px;
        border: 1px solid #d4e8db;
        border-radius: 16px;
        background: #fafffc;
        transition: 0.2s;
    }
    .sampah-item:hover {
        background: #f0f7f2;
    }
    .sampah-item input[type="checkbox"] {
        flex-shrink: 0;
        accent-color: #2e7d5a;
        width: 18px;
        height: 18px;
    }
    .sampah-name {
        flex: 1;
        font-size: 0.75rem;
        font-weight: 600;
        color: #0d2b1f;
        cursor: pointer;
    }
    .weight {
        width: 70px;
        height: 34px;
        border: 1px solid #d4e8db;
        border-radius: 10px;
        text-align: center;
        font-size: 0.72rem;
        background: white;
    }
    .weight:focus {
        border-color: #2e7d5a;
        box-shadow: 0 0 0 3px rgba(46,125,90,0.12);
    }

    /* ALERT */
    .alert {
        margin-bottom: 16px;
        padding: 12px 16px;
        border-radius: 16px;
        font-size: 0.73rem;
        font-weight: 500;
    }
    .alert-success {
        color: #155724;
        background: #d4edda;
        border: 1px solid #b8d9b8;
    }
    .alert-danger {
        color: #721c24;
        background: #f8d7da;
        border: 1px solid #f5c6cb;
    }
    .alert-danger ul {
        margin-top: 5px;
        padding-left: 18px;
    }

    /* FOOTER CARD */
    .footer-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding: 17px 32px;
        background: #f7fbf9;
        border-top: 1px solid #d4e8db;
    }
    .button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 41px;
        padding: 0 20px;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: 0.2s;
    }
    .button-cancel {
        border: 1px solid #d4e8db;
        background: white;
        color: #2d5a43;
    }
    .button-cancel:hover {
        background: #f0f7f2;
        border-color: #6fcf97;
    }
    .button-submit {
        background: #2e7d5a;
        color: white;
    }
    .button-submit:hover {
        background: #1a4532;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(46,125,90,0.3);
    }

    /* RESPONSIVE */
    @media (max-width: 700px) {
        .grid-2,
        .method-grid,
        .sampah-grid {
            grid-template-columns: 1fr;
        }
        .setoran-page {
            padding: 18px 12px 30px;
        }
        .setoran-body {
            padding: 20px;
        }
        #map {
            height: 240px;
        }
        .footer-actions {
            padding: 14px 20px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .button {
            flex: 1;
            min-width: 120px;
        }
    }
</style>

<div class="setoran-page">

    <div class="setoran-container">

        <!-- HEADER -->
        <div class="setoran-header">
            <div>
                <h1 class="setoran-title">
                    <i class="fas fa-plus-circle" style="color:#2e7d5a; margin-right:8px;"></i>
                    Form Setoran
                </h1>
                <div class="setoran-subtitle">
                    Ajukan setoran sampah dengan lokasi otomatis
                </div>
            </div>
            <a href="{{ route('user.setoran') }}" class="setoran-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- CARD -->
        <div class="setoran-card">

            <form action="{{ route('user.transaksi.store') }}" method="POST">

                @csrf

                <div class="setoran-body">

                    <!-- ALERT -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <strong>Data belum lengkap.</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- ==================================================
                         01. DATA PENGIRIM
                    ================================================== -->
                    <div class="section">
                        <div class="section-title">
                            01. Data Pengirim
                        </div>
                        <div class="grid-2">
                            <div class="field">
                                <label>Nama Pengirim</label>
                                <input type="text" name="nama_pengirim"
                                       class="input readonly"
                                       value="{{ auth()->user()->name }}"
                                       readonly>
                            </div>
                            <div class="field">
                                <label>Nomor HP</label>
                                <input type="text" name="no_hp"
                                       class="input"
                                       value="{{ old('no_hp', auth()->user()->pelanggan->no_hp ?? '') }}"
                                       placeholder="08xxxxxxxxxx"
                                       required>
                            </div>
                        </div>
                    </div>

                    <!-- ==================================================
                         02. METODE SETORAN
                    ================================================== -->
                    <div class="section">
                        <div class="section-title">
                            02. Metode Setoran
                        </div>
                        <div class="method-grid">
                            <div>
                                <input type="radio" name="metode" value="jemput"
                                       id="metodeJemput" class="method-input"
                                       {{ old('metode','jemput') === 'jemput' ? 'checked' : '' }}>
                                <label for="metodeJemput" class="method-label">
                                    <strong>Jemput Sampah</strong>
                                    <span>Petugas datang ke lokasi Anda</span>
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="metode" value="antar"
                                       id="metodeAntar" class="method-input"
                                       {{ old('metode') === 'antar' ? 'checked' : '' }}>
                                <label for="metodeAntar" class="method-label">
                                    <strong>Antar ke Titik Kumpul</strong>
                                    <span>Anda mengantar langsung</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- ==================================================
                         03. LOKASI
                    ================================================== -->
                    <div class="section">
                        <div class="section-title">
                            03. Lokasi
                        </div>

                        <!-- Status -->
                        <div id="locationStatus" class="location-status">
                            Meminta izin lokasi...
                        </div>

                        <!-- Tombol -->
                        <div class="location-actions">
                            <button type="button" id="btnLocation" class="location-button">
                                <i class="fas fa-location-dot"></i> Gunakan Lokasi Saya
                            </button>
                            <button type="button" id="btnRefreshLocation" class="location-button">
                                <i class="fas fa-rotate"></i> Perbarui Lokasi
                            </button>
                        </div>

                        <!-- AREA JEMPUT -->
                        <div id="jemputArea">
                            <div class="field">
                                <label>Alamat Jemput <span style="color:red;">*</span></label>
                                <textarea name="alamat_jemput" id="alamat_jemput"
                                          class="textarea" placeholder="Alamat akan otomatis terisi dari lokasi Anda...">{{ old('alamat_jemput') }}</textarea>
                            </div>
                            <!-- Cabang terdekat -->
                            <div id="cabangInfo" class="branch-info">
                                <strong>Cabang terdekat</strong>
                                <small id="cabangNama">-</small>
                                <small id="cabangJarak">-</small>
                            </div>
                        </div>

                        <!-- AREA ANTAR -->
                        <div id="antarArea" style="display:none;">
                            <div class="field">
                                <label>Titik Kumpul <span style="color:red;">*</span></label>
                                <select name="titik_kumpul_id" id="titikKumpulSelect" class="select">
                                    <option value="">Memuat titik kumpul...</option>
                                    @foreach($titikKumpuls as $item)
                                        <option value="{{ $item->id }}"
                                                data-lat="{{ $item->latitude }}"
                                                data-lng="{{ $item->longitude }}"
                                                data-alamat="{{ $item->alamat }}"
                                                {{ old('titik_kumpul_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="titikInfo" class="pickup-info">
                                <strong id="titikNama">-</strong>
                                <div><strong>Alamat:</strong> <span id="titikAlamat">-</span></div>
                                <div><strong>Jarak:</strong> <span id="titikJarak">-</span></div>
                                <a href="#" id="mapsLink" target="_blank" class="maps-button">
                                    <i class="fas fa-map-location-dot"></i> Buka Google Maps
                                </a>
                            </div>
                        </div>

                        <!-- MAP -->
                        <div style="margin-top:15px;">
                            <div id="map"></div>
                        </div>

                        <!-- Koordinat -->
                        <div class="coordinate-text">
                            Koordinat: <span id="coordinateText">-</span>
                        </div>

                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

                    </div>

                    <!-- ==================================================
                         04. JENIS SAMPAH
                    ================================================== -->
                    <div class="section">
                        <div class="section-title">
                            04. Jenis Sampah
                        </div>
                        <div class="sampah-grid">
                            @forelse($jenisSampahs as $js)
                                <div class="sampah-item">
                                    <input type="checkbox" class="sampah-check"
                                           id="check_{{ $js->id }}" data-id="{{ $js->id }}">
                                    <label for="check_{{ $js->id }}" class="sampah-name">
                                        {{ $js->nama }}
                                    </label>
                                    <input type="number" name="jenis_sampah_data[{{ $js->id }}]"
                                           id="berat_{{ $js->id }}" class="weight"
                                           min="0.1" step="0.1"
                                           value="{{ old('jenis_sampah_data.' . $js->id, 0) }}"
                                           disabled>
                                    <span style="font-size:0.65rem;color:#4d7a63;">kg</span>
                                </div>
                            @empty
                                <div style="grid-column:1/-1; color:#4d7a63; font-size:0.75rem;">
                                    Belum ada jenis sampah.
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div> <!-- end .setoran-body -->

                <!-- FOOTER -->
                <div class="footer-actions">
                    <a href="{{ route('user.setoran') }}" class="button button-cancel">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="button button-submit">
                        <i class="fas fa-paper-plane"></i> Ajukan Setoran
                    </button>
                </div>

            </form>

        </div> <!-- end .setoran-card -->

    </div> <!-- end .container -->

</div> <!-- end .setoran-page -->


<!-- ============================================================
     SCRIPTS
============================================================ -->

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ============================================================
    // DATA DARI DATABASE
    // ============================================================

    const cabangs = @json($cabangs->values());
    const titikKumpuls = @json($titikKumpuls->values());

    // ============================================================
    // ELEMENT
    // ============================================================

    const metodeJemput = document.getElementById('metodeJemput');
    const metodeAntar  = document.getElementById('metodeAntar');
    const jemputArea   = document.getElementById('jemputArea');
    const antarArea    = document.getElementById('antarArea');
    const alamatInput  = document.getElementById('alamat_jemput');
    const titikSelect  = document.getElementById('titikKumpulSelect');
    const locationStatus = document.getElementById('locationStatus');
    const latInput     = document.getElementById('latitude');
    const lngInput     = document.getElementById('longitude');
    const coordText    = document.getElementById('coordinateText');

    // ============================================================
    // MAP
    // ============================================================

    const defaultLat = {{ $centerLat }};
    const defaultLng = {{ $centerLng }};

    let currentLat = parseFloat(latInput.value) || defaultLat;
    let currentLng = parseFloat(lngInput.value) || defaultLng;

    const map = L.map('map').setView([currentLat, currentLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    let marker = L.marker([currentLat, currentLng], { draggable: true }).addTo(map);

    // ============================================================
    // FUNGSI JARAK (Haversine)
    // ============================================================

    function distanceKm(lat1, lng1, lat2, lng2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;
        const a = Math.sin(dLat/2)**2 +
                  Math.cos(lat1 * Math.PI/180) * Math.cos(lat2 * Math.PI/180) *
                  Math.sin(dLng/2)**2;
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    // ============================================================
    // UPDATE LOKASI
    // ============================================================

    function updateLocation(lat, lng) {
        currentLat = parseFloat(lat);
        currentLng = parseFloat(lng);
        latInput.value = currentLat.toFixed(8);
        lngInput.value = currentLng.toFixed(8);
        coordText.textContent = currentLat.toFixed(6) + ', ' + currentLng.toFixed(6);
        marker.setLatLng([currentLat, currentLng]);
        map.setView([currentLat, currentLng], 15);
        cariCabangTerdekat();
        cariTitikKumpulTerdekat();
    }

    // ============================================================
    // REVERSE GEOCODE (ALAMAT OTOMATIS)
    // ============================================================

    async function getAddress(lat, lng) {
        try {
            const response = await fetch(
                'https://nominatim.openstreetmap.org/reverse?' +
                new URLSearchParams({
                    format: 'json',
                    lat: lat,
                    lon: lng,
                    zoom: 18,
                    addressdetails: 1
                })
            );
            if (!response.ok) throw new Error();
            const data = await response.json();
            return data.display_name || '';
        } catch {
            return '';
        }
    }

    // ============================================================
    // CABANG TERDEKAT
    // ============================================================

    function cariCabangTerdekat() {
        const info = document.getElementById('cabangInfo');
        if (!cabangs.length) { info.style.display = 'none'; return; }

        let terdekat = null;
        cabangs.forEach(cabang => {
            const lat = parseFloat(cabang.latitude);
            const lng = parseFloat(cabang.longitude);
            if (isNaN(lat) || isNaN(lng)) return;
            const jarak = distanceKm(currentLat, currentLng, lat, lng);
            if (!terdekat || jarak < terdekat.jarak) {
                terdekat = { nama: cabang.nama, jarak };
            }
        });

        if (!terdekat) { info.style.display = 'none'; return; }

        info.style.display = 'block';
        document.getElementById('cabangNama').textContent = terdekat.nama;
        document.getElementById('cabangJarak').textContent =
            terdekat.jarak.toFixed(2) + ' km dari lokasi Anda';
    }

    // ============================================================
    // TITIK KUMPUL TERDEKAT (AUTO SELECT)
    // ============================================================

    function cariTitikKumpulTerdekat() {
        if (!titikKumpuls.length) return;

        let terdekat = null;
        titikKumpuls.forEach(titik => {
            const lat = parseFloat(titik.latitude);
            const lng = parseFloat(titik.longitude);
            if (isNaN(lat) || isNaN(lng)) return;
            const jarak = distanceKm(currentLat, currentLng, lat, lng);
            if (!terdekat || jarak < terdekat.jarak) {
                terdekat = {
                    id: titik.id,
                    nama: titik.nama,
                    alamat: titik.alamat,
                    latitude: lat,
                    longitude: lng,
                    jarak
                };
            }
        });

        if (!terdekat) return;

        if (!titikSelect.dataset.userSelected) {
            titikSelect.value = terdekat.id;
        }
        updateTitikInfo();
    }

    // ============================================================
    // INFO TITIK KUMPUL
    // ============================================================

    function updateTitikInfo() {
        const option = titikSelect.options[titikSelect.selectedIndex];
        if (!option || !option.value) {
            document.getElementById('titikInfo').style.display = 'none';
            return;
        }

        const lat = parseFloat(option.dataset.lat);
        const lng = parseFloat(option.dataset.lng);
        const alamat = option.dataset.alamat || '';
        const nama = option.textContent.trim();

        if (isNaN(lat) || isNaN(lng)) return;

        const jarak = distanceKm(currentLat, currentLng, lat, lng);

        document.getElementById('titikInfo').style.display = 'block';
        document.getElementById('titikNama').textContent = nama;
        document.getElementById('titikAlamat').textContent = alamat;
        document.getElementById('titikJarak').textContent =
            jarak.toFixed(2) + ' km dari lokasi Anda';
        document.getElementById('mapsLink').href =
            'https://www.google.com/maps/dir/?api=1' +
            '&origin=' + currentLat + ',' + currentLng +
            '&destination=' + lat + ',' + lng;
    }

    // ============================================================
    // METODE TOGGLE
    // ============================================================

    function updateMetode() {
        if (metodeJemput.checked) {
            jemputArea.style.display = 'block';
            antarArea.style.display = 'none';
            alamatInput.required = true;
            titikSelect.required = false;
        } else {
            jemputArea.style.display = 'none';
            antarArea.style.display = 'block';
            alamatInput.required = false;
            titikSelect.required = true;
            cariTitikKumpulTerdekat();
        }
        setTimeout(() => map.invalidateSize(), 200);
    }

    metodeJemput.addEventListener('change', updateMetode);
    metodeAntar.addEventListener('change', updateMetode);

    // ============================================================
    // PILIH TITIK MANUAL
    // ============================================================

    titikSelect.addEventListener('change', function () {
        this.dataset.userSelected = '1';
        updateTitikInfo();
    });

    // ============================================================
    // DRAG MARKER
    // ============================================================

    marker.on('dragend', async function () {
        const pos = marker.getLatLng();
        updateLocation(pos.lat, pos.lng);
        const alamat = await getAddress(pos.lat, pos.lng);
        if (alamat && metodeJemput.checked) {
            alamatInput.value = alamat;
        }
    });

    // ============================================================
    // KLIK PETA
    // ============================================================

    map.on('click', async function (e) {
        updateLocation(e.latlng.lat, e.latlng.lng);
        const alamat = await getAddress(e.latlng.lat, e.latlng.lng);
        if (alamat && metodeJemput.checked) {
            alamatInput.value = alamat;
        }
    });

    // ============================================================
    // LOKASI USER (GEOLOCATION)
    // ============================================================

    function ambilLokasi() {
        if (!navigator.geolocation) {
            locationStatus.textContent = 'Browser tidak mendukung lokasi.';
            return;
        }
        locationStatus.textContent = 'Meminta izin lokasi...';
        navigator.geolocation.getCurrentPosition(
            async function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                updateLocation(lat, lng);
                locationStatus.textContent = 'Lokasi berhasil ditemukan.';
                const alamat = await getAddress(lat, lng);
                if (alamat && metodeJemput.checked) {
                    alamatInput.value = alamat;
                }
            },
            function (error) {
                if (error.code === error.PERMISSION_DENIED) {
                    locationStatus.textContent = 'Izin lokasi ditolak. Pilih lokasi dari peta.';
                } else {
                    locationStatus.textContent = 'Gagal mendapatkan lokasi.';
                }
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    }

    document.getElementById('btnLocation').addEventListener('click', ambilLokasi);
    document.getElementById('btnRefreshLocation').addEventListener('click', ambilLokasi);

    // ============================================================
    // CHECKBOX JENIS SAMPAH (enable/disable berat)
    // ============================================================

    document.querySelectorAll('.sampah-check').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const id = this.dataset.id;
            const weight = document.getElementById('berat_' + id);
            weight.disabled = !this.checked;
            if (!this.checked) {
                weight.value = 0;
            } else {
                weight.focus();
            }
        });
    });

    // ============================================================
    // INISIALISASI
    // ============================================================

    updateMetode();
    ambilLokasi();

});
</script>

@endsection