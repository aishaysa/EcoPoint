@extends('layouts.user')

@section('title', 'Form Setoran')
@section('page_title', 'Form Setoran')

@section('content')

<link rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<style>
    .setoran-page {
        width: 100%;
        min-height: 100vh;
        background: #f7f9fb;
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
        font-weight: 700;
        color: #18212f;
    }

    .setoran-subtitle {
        margin-top: 4px;
        color: #8a95a5;
        font-size: .8rem;
    }

    .setoran-back {
        text-decoration: none;
        padding: 9px 14px;
        border: 1px solid #dfe5eb;
        border-radius: 10px;
        background: #fff;
        color: #667085;
    }

    .setoran-card {
        background: #fff;
        border: 1px solid #e6ebef;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(15, 23, 42, .05);
        overflow: hidden;
    }

    .setoran-body {
        padding: 28px;
    }

    .section {
        padding-bottom: 26px;
        margin-bottom: 26px;
        border-bottom: 1px solid #edf1f4;
    }

    .section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: 0;
    }

    .section-title {
        margin-bottom: 16px;
        font-size: .95rem;
        font-weight: 700;
        color: #273444;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .field label {
        display: block;
        margin-bottom: 7px;
        font-size: .74rem;
        font-weight: 700;
        color: #344054;
    }

    .input,
    .select,
    .textarea {
        width: 100%;
        border: 1px solid #dfe5eb;
        border-radius: 10px;
        background: #fbfcfd;
        padding: 10px 13px;
        font-size: .8rem;
        color: #344054;
        outline: none;
    }

    .textarea {
        min-height: 90px;
        resize: vertical;
    }

    .input:focus,
    .select:focus,
    .textarea:focus {
        background: #fff;
        border-color: #18a66f;
        box-shadow: 0 0 0 3px rgba(24,166,111,.08);
    }

    .readonly {
        background: #f3f5f7 !important;
    }

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
        border: 1px solid #e1e7ec;
        border-radius: 12px;
        cursor: pointer;
        transition: .2s ease;
    }

    .method-input:checked + .method-label {
        border-color: #3aac83;
        background: #f2fbf7;
    }

    .method-label strong {
        display: block;
        font-size: .8rem;
        color: #344054;
        margin-bottom: 3px;
    }

    .method-label span {
        font-size: .68rem;
        color: #98a2b3;
    }

    .recommendation {
        display: none;
        margin-top: 12px;
        padding: 13px;
        background: #f0faf5;
        border: 1px solid #cdebdc;
        border-radius: 11px;
    }

    .recommendation strong {
        color: #087d53;
    }

    .recommendation small {
        display: block;
        margin-top: 3px;
        color: #667085;
    }

    .location-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-bottom: 12px;
    }

    .location-button {
        border: 1px solid #bfd4fa;
        border-radius: 9px;
        background: #fff;
        color: #2563eb;
        padding: 9px 12px;
        font-size: .7rem;
        font-weight: 700;
        cursor: pointer;
    }

    .location-button:hover {
        background: #2563eb;
        color: white;
    }

    .location-status {
        margin-bottom: 12px;
        font-size: .7rem;
        color: #667085;
    }

    #map {
        width: 100%;
        height: 320px;
        border-radius: 11px;
        border: 1px solid #dde4ea;
    }

    .pickup-info {
        display: none;
        margin-top: 12px;
        padding: 12px;
        border-left: 4px solid #2563eb;
        background: #f0f6ff;
        border-radius: 9px;
    }

    .pickup-info strong {
        color: #0f172a;
    }

    .maps-button {
        display: inline-block;
        margin-top: 9px;
        padding: 7px 12px;
        border-radius: 8px;
        background: #2563eb;
        color: white;
        text-decoration: none;
        font-size: .7rem;
        font-weight: 700;
    }

    .branch-info {
        display: none;
        margin-top: 10px;
        padding: 12px;
        border-radius: 10px;
        background: #f8fafc;
        border: 1px solid #e6ebef;
    }

    .branch-info strong {
        color: #344054;
    }

    .branch-info small {
        display: block;
        color: #667085;
        margin-top: 4px;
    }

    .sampah-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0,1fr));
        gap: 10px;
    }

    .sampah-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 11px;
        border: 1px solid #e5eaef;
        border-radius: 10px;
        background: #fbfcfd;
    }

    .sampah-item input[type="checkbox"] {
        flex-shrink: 0;
    }

    .sampah-name {
        flex: 1;
        font-size: .75rem;
        font-weight: 600;
        color: #344054;
    }

    .weight {
        width: 70px;
        height: 34px;
        border: 1px solid #dfe5eb;
        border-radius: 8px;
        text-align: center;
        font-size: .72rem;
    }

    .alert {
        margin-bottom: 16px;
        padding: 11px 13px;
        border-radius: 10px;
        font-size: .73rem;
    }

    .alert-success {
        color: #147d4d;
        background: #effcf5;
        border: 1px solid #caeedb;
    }

    .alert-danger {
        color: #b42318;
        background: #fff3f3;
        border: 1px solid #f2cece;
    }

    .footer {
        display: flex;
        justify-content: flex-end;
        gap: 9px;
        padding: 17px 28px;
        background: #fafbfc;
        border-top: 1px solid #edf1f4;
    }

    .button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 41px;
        padding: 0 17px;
        border-radius: 9px;
        font-size: .75rem;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .button-cancel {
        border: 1px solid #dfe5eb;
        background: white;
        color: #667085;
    }

    .button-submit {
        border: none;
        background: #0d9b68;
        color: white;
    }

    @media(max-width:700px) {
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
            height: 280px;
        }
    }
</style>

<div class="setoran-page">

    <div class="setoran-container">

        <div class="setoran-header">

            <div>
                <h1 class="setoran-title">
                    Form Setoran
                </h1>

                <div class="setoran-subtitle">
                    Ajukan setoran sampah dengan lokasi otomatis
                </div>
            </div>

            <a href="{{ route('user.setoran') }}"
               class="setoran-back">
                Kembali
            </a>

        </div>


        <div class="setoran-card">

            <form action="{{ route('user.transaksi.store') }}"
                  method="POST">

                @csrf

                <div class="setoran-body">


                    {{-- ALERT --}}

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

                            <ul style="margin-top:5px;padding-left:18px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>
                    @endif


                    {{-- =====================================================
                         DATA PENGIRIM
                    ====================================================== --}}

                    <div class="section">

                        <div class="section-title">
                            01. Data Pengirim
                        </div>

                        <div class="grid-2">

                            <div class="field">

                                <label>
                                    Nama Pengirim
                                </label>

                                <input
                                    type="text"
                                    name="nama_pengirim"
                                    class="input readonly"
                                    value="{{ auth()->user()->name }}"
                                    readonly
                                >

                            </div>


                            <div class="field">

                                <label>
                                    Nomor HP
                                </label>

                                <input
                                    type="text"
                                    name="no_hp"
                                    class="input"
                                    value="{{ old('no_hp', auth()->user()->pelanggan->no_hp ?? '') }}"
                                    placeholder="08xxxxxxxxxx"
                                    required
                                >

                            </div>

                        </div>

                    </div>


                    {{-- =====================================================
                         METODE
                    ====================================================== --}}

                    <div class="section">

                        <div class="section-title">
                            02. Metode Setoran
                        </div>

                        <div class="method-grid">

                            <div>

                                <input
                                    type="radio"
                                    name="metode"
                                    value="jemput"
                                    id="metodeJemput"
                                    class="method-input"
                                    {{ old('metode','jemput') === 'jemput' ? 'checked' : '' }}
                                >

                                <label
                                    for="metodeJemput"
                                    class="method-label"
                                >

                                    <strong>
                                        Jemput Sampah
                                    </strong>

                                    <span>
                                        Petugas datang ke lokasi Anda
                                    </span>

                                </label>

                            </div>


                            <div>

                                <input
                                    type="radio"
                                    name="metode"
                                    value="antar"
                                    id="metodeAntar"
                                    class="method-input"
                                    {{ old('metode') === 'antar' ? 'checked' : '' }}
                                >

                                <label
                                    for="metodeAntar"
                                    class="method-label"
                                >

                                    <strong>
                                        Antar ke Titik Kumpul
                                    </strong>

                                    <span>
                                        Anda mengantar langsung
                                    </span>

                                </label>

                            </div>

                        </div>

                    </div>


                    {{-- =====================================================
                         LOKASI
                    ====================================================== --}}

                    <div class="section">

                        <div class="section-title">
                            03. Lokasi
                        </div>


                        {{-- STATUS LOKASI --}}

                        <div
                            id="locationStatus"
                            class="location-status"
                        >
                            Meminta izin lokasi...
                        </div>


                        <div class="location-actions">

                            <button
                                type="button"
                                id="btnLocation"
                                class="location-button"
                            >
                                Gunakan Lokasi Saya
                            </button>

                            <button
                                type="button"
                                id="btnRefreshLocation"
                                class="location-button"
                            >
                                Perbarui Lokasi
                            </button>

                        </div>


                        {{-- =================================================
                             JEMPUT
                        ================================================== --}}

                        <div id="jemputArea">

                            <div class="field">

                                <label>
                                    Alamat Jemput
                                    <span style="color:red">*</span>
                                </label>

                                <textarea
                                    name="alamat_jemput"
                                    id="alamat_jemput"
                                    class="textarea"
                                    placeholder="Alamat akan otomatis terisi dari lokasi Anda..."
                                >{{ old('alamat_jemput') }}</textarea>

                            </div>


                            <div
                                id="cabangInfo"
                                class="branch-info"
                            >
                                <strong>
                                    Cabang terdekat
                                </strong>

                                <small id="cabangNama">
                                    -
                                </small>

                                <small id="cabangJarak">
                                    -
                                </small>
                            </div>

                        </div>


                        {{-- =================================================
                             ANTAR
                        ================================================== --}}

                        <div
                            id="antarArea"
                            style="display:none;"
                        >

                            <div class="field">

                                <label>
                                    Titik Kumpul
                                    <span style="color:red">*</span>
                                </label>

                                <select
                                    name="titik_kumpul_id"
                                    id="titikKumpulSelect"
                                    class="select"
                                >

                                    <option value="">
                                        Memuat titik kumpul...
                                    </option>

                                    @foreach($titikKumpuls as $item)

                                        <option
                                            value="{{ $item->id }}"
                                            data-lat="{{ $item->latitude }}"
                                            data-lng="{{ $item->longitude }}"
                                            data-alamat="{{ $item->alamat }}"
                                            {{ old('titik_kumpul_id') == $item->id ? 'selected' : '' }}
                                        >
                                            {{ $item->nama }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div
                                id="titikInfo"
                                class="pickup-info"
                            >

                                <strong id="titikNama">
                                    -
                                </strong>

                                <div>
                                    <strong>Alamat:</strong>
                                    <span id="titikAlamat">-</span>
                                </div>

                                <div>
                                    <strong>Jarak:</strong>
                                    <span id="titikJarak">-</span>
                                </div>

                                <a
                                    href="#"
                                    id="mapsLink"
                                    target="_blank"
                                    class="maps-button"
                                >
                                    Buka Google Maps
                                </a>

                            </div>

                        </div>


                        {{-- =================================================
                             MAP
                        ================================================== --}}

                        <div style="margin-top:15px;">

                            <div id="map"></div>

                        </div>


                        <div
                            style="
                                margin-top:9px;
                                font-size:.68rem;
                                color:#667085;
                            "
                        >
                            Koordinat:
                            <span id="coordinateText">
                                -
                            </span>
                        </div>


                        <input
                            type="hidden"
                            name="latitude"
                            id="latitude"
                            value="{{ old('latitude') }}"
                        >

                        <input
                            type="hidden"
                            name="longitude"
                            id="longitude"
                            value="{{ old('longitude') }}"
                        >

                    </div>


                    {{-- =====================================================
                         JENIS SAMPAH
                    ====================================================== --}}

                    <div class="section">

                        <div class="section-title">
                            04. Jenis Sampah
                        </div>

                        <div class="sampah-grid">

                            @forelse($jenisSampahs as $js)

                                <div class="sampah-item">

                                    <input
                                        type="checkbox"
                                        class="sampah-check"
                                        id="check_{{ $js->id }}"
                                        data-id="{{ $js->id }}"
                                    >

                                    <label
                                        for="check_{{ $js->id }}"
                                        class="sampah-name"
                                    >
                                        {{ $js->nama }}
                                    </label>

                                    <input
                                        type="number"
                                        name="jenis_sampah_data[{{ $js->id }}]"
                                        id="berat_{{ $js->id }}"
                                        class="weight"
                                        min="0.1"
                                        step="0.1"
                                        value="{{ old('jenis_sampah_data.' . $js->id, 0) }}"
                                        disabled
                                    >

                                    <span style="font-size:.65rem;color:#98a2b3;">
                                        kg
                                    </span>

                                </div>

                            @empty

                                <div style="grid-column:1/-1;color:#98a2b3;font-size:.75rem;">
                                    Belum ada jenis sampah.
                                </div>

                            @endforelse

                        </div>

                    </div>


                </div>


                <div class="footer">

                    <a
                        href="{{ route('user.setoran') }}"
                        class="button button-cancel"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="button button-submit"
                    >
                        Ajukan Setoran
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | DATA DARI DATABASE
    |--------------------------------------------------------------------------
    */

    const cabangs = @json($cabangs->values());

    const titikKumpuls = @json($titikKumpuls->values());


    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const metodeJemput =
        document.getElementById('metodeJemput');

    const metodeAntar =
        document.getElementById('metodeAntar');

    const jemputArea =
        document.getElementById('jemputArea');

    const antarArea =
        document.getElementById('antarArea');

    const alamatInput =
        document.getElementById('alamat_jemput');

    const titikSelect =
        document.getElementById('titikKumpulSelect');

    const locationStatus =
        document.getElementById('locationStatus');

    const latitudeInput =
        document.getElementById('latitude');

    const longitudeInput =
        document.getElementById('longitude');

    const coordinateText =
        document.getElementById('coordinateText');


    /*
    |--------------------------------------------------------------------------
    | MAP
    |--------------------------------------------------------------------------
    */

    const defaultLat =
        {{ $centerLat }};

    const defaultLng =
        {{ $centerLng }};

    let currentLat =
        parseFloat(latitudeInput.value) || defaultLat;

    let currentLng =
        parseFloat(longitudeInput.value) || defaultLng;


    const map =
        L.map('map').setView(
            [currentLat, currentLng],
            13
        );


    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }
    ).addTo(map);


    let marker =
        L.marker(
            [currentLat, currentLng],
            {
                draggable: true
            }
        ).addTo(map);


    /*
    |--------------------------------------------------------------------------
    | HITUNG JARAK
    |--------------------------------------------------------------------------
    */

    function distanceKm(
        lat1,
        lng1,
        lat2,
        lng2
    ) {

        const R = 6371;

        const dLat =
            (lat2 - lat1) *
            Math.PI / 180;

        const dLng =
            (lng2 - lng1) *
            Math.PI / 180;

        const a =
            Math.sin(dLat / 2) *
            Math.sin(dLat / 2) +
            Math.cos(
                lat1 * Math.PI / 180
            ) *
            Math.cos(
                lat2 * Math.PI / 180
            ) *
            Math.sin(dLng / 2) *
            Math.sin(dLng / 2);

        const c =
            2 *
            Math.atan2(
                Math.sqrt(a),
                Math.sqrt(1 - a)
            );

        return R * c;
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE LOKASI
    |--------------------------------------------------------------------------
    */

    function updateLocation(
        lat,
        lng
    ) {

        currentLat = parseFloat(lat);
        currentLng = parseFloat(lng);

        latitudeInput.value =
            currentLat.toFixed(8);

        longitudeInput.value =
            currentLng.toFixed(8);

        coordinateText.textContent =
            currentLat.toFixed(6) +
            ', ' +
            currentLng.toFixed(6);

        marker.setLatLng([
            currentLat,
            currentLng
        ]);

        map.setView([
            currentLat,
            currentLng
        ], 15);

        cariCabangTerdekat();
        cariTitikKumpulTerdekat();
    }


    /*
    |--------------------------------------------------------------------------
    | ALAMAT OTOMATIS
    |--------------------------------------------------------------------------
    */

    async function getAddress(
        lat,
        lng
    ) {

        try {

            const response =
                await fetch(
                    'https://nominatim.openstreetmap.org/reverse?' +
                    new URLSearchParams({
                        format: 'json',
                        lat: lat,
                        lon: lng,
                        zoom: 18,
                        addressdetails: 1
                    })
                );

            if (!response.ok) {
                throw new Error();
            }

            const data =
                await response.json();

            return data.display_name || '';

        } catch (error) {

            return '';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CABANG TERDEKAT
    |--------------------------------------------------------------------------
    */

    function cariCabangTerdekat() {

        const info =
            document.getElementById('cabangInfo');

        if (!cabangs.length) {

            info.style.display = 'none';

            return;
        }


        let terdekat = null;


        cabangs.forEach(
            function (cabang) {

                const lat =
                    parseFloat(cabang.latitude);

                const lng =
                    parseFloat(cabang.longitude);

                if (
                    Number.isNaN(lat) ||
                    Number.isNaN(lng)
                ) {
                    return;
                }


                const jarak =
                    distanceKm(
                        currentLat,
                        currentLng,
                        lat,
                        lng
                    );


                if (
                    !terdekat ||
                    jarak < terdekat.jarak
                ) {

                    terdekat = {
                        id: cabang.id,
                        nama: cabang.nama,
                        latitude: lat,
                        longitude: lng,
                        jarak: jarak
                    };
                }
            }
        );


        if (!terdekat) {
            info.style.display = 'none';
            return;
        }


        info.style.display = 'block';

        document.getElementById(
            'cabangNama'
        ).textContent =
            terdekat.nama;

        document.getElementById(
            'cabangJarak'
        ).textContent =
            terdekat.jarak.toFixed(2) +
            ' km dari lokasi Anda';
    }


    /*
    |--------------------------------------------------------------------------
    | TITIK KUMPUL TERDEKAT
    |--------------------------------------------------------------------------
    */

    function cariTitikKumpulTerdekat() {

        if (!titikKumpuls.length) {
            return;
        }


        let terdekat = null;


        titikKumpuls.forEach(
            function (titik) {

                const lat =
                    parseFloat(titik.latitude);

                const lng =
                    parseFloat(titik.longitude);

                if (
                    Number.isNaN(lat) ||
                    Number.isNaN(lng)
                ) {
                    return;
                }


                const jarak =
                    distanceKm(
                        currentLat,
                        currentLng,
                        lat,
                        lng
                    );


                if (
                    !terdekat ||
                    jarak < terdekat.jarak
                ) {

                    terdekat = {
                        id: titik.id,
                        nama: titik.nama,
                        alamat: titik.alamat,
                        latitude: lat,
                        longitude: lng,
                        jarak: jarak
                    };
                }
            }
        );


        if (!terdekat) {
            return;
        }


        /*
        |--------------------------------------------------------------
        | OTOMATIS PILIH YANG TERDEKAT
        |--------------------------------------------------------------
        */

        if (!titikSelect.dataset.userSelected) {

            titikSelect.value =
                terdekat.id;
        }

        updateTitikInfo();
    }


    /*
    |--------------------------------------------------------------------------
    | INFO TITIK KUMPUL
    |--------------------------------------------------------------------------
    */

    function updateTitikInfo() {

        const option =
            titikSelect.options[
                titikSelect.selectedIndex
            ];


        if (
            !option ||
            !option.value
        ) {

            document.getElementById(
                'titikInfo'
            ).style.display = 'none';

            return;
        }


        const lat =
            parseFloat(
                option.dataset.lat
            );

        const lng =
            parseFloat(
                option.dataset.lng
            );

        const alamat =
            option.dataset.alamat || '';

        const nama =
            option.textContent.trim();


        if (
            Number.isNaN(lat) ||
            Number.isNaN(lng)
        ) {
            return;
        }


        const jarak =
            distanceKm(
                currentLat,
                currentLng,
                lat,
                lng
            );


        document.getElementById(
            'titikInfo'
        ).style.display = 'block';


        document.getElementById(
            'titikNama'
        ).textContent =
            nama;


        document.getElementById(
            'titikAlamat'
        ).textContent =
            alamat;


        document.getElementById(
            'titikJarak'
        ).textContent =
            jarak.toFixed(2) +
            ' km dari lokasi Anda';


        document.getElementById(
            'mapsLink'
        ).href =
            'https://www.google.com/maps/dir/?api=1' +
            '&origin=' +
            currentLat +
            ',' +
            currentLng +
            '&destination=' +
            lat +
            ',' +
            lng;
    }


    /*
    |--------------------------------------------------------------------------
    | GANTI METODE
    |--------------------------------------------------------------------------
    */

    function updateMetode() {

        if (metodeJemput.checked) {

            jemputArea.style.display =
                'block';

            antarArea.style.display =
                'none';

            alamatInput.required =
                true;

            titikSelect.required =
                false;

        } else {

            jemputArea.style.display =
                'none';

            antarArea.style.display =
                'block';

            alamatInput.required =
                false;

            titikSelect.required =
                true;

            cariTitikKumpulTerdekat();
        }


        setTimeout(
            function () {
                map.invalidateSize();
            },
            200
        );
    }


    metodeJemput.addEventListener(
        'change',
        updateMetode
    );

    metodeAntar.addEventListener(
        'change',
        updateMetode
    );


    /*
    |--------------------------------------------------------------------------
    | PILIH TITIK MANUAL
    |--------------------------------------------------------------------------
    */

    titikSelect.addEventListener(
        'change',
        function () {

            this.dataset.userSelected =
                '1';

            updateTitikInfo();
        }
    );


    /*
    |--------------------------------------------------------------------------
    | MARKER DRAG
    |--------------------------------------------------------------------------
    */

    marker.on(
        'dragend',
        async function () {

            const posisi =
                marker.getLatLng();

            updateLocation(
                posisi.lat,
                posisi.lng
            );


            const alamat =
                await getAddress(
                    posisi.lat,
                    posisi.lng
                );


            if (
                alamat &&
                metodeJemput.checked
            ) {

                alamatInput.value =
                    alamat;
            }
        }
    );


    /*
    |--------------------------------------------------------------------------
    | KLIK PETA
    |--------------------------------------------------------------------------
    */

    map.on(
        'click',
        async function (event) {

            updateLocation(
                event.latlng.lat,
                event.latlng.lng
            );


            const alamat =
                await getAddress(
                    event.latlng.lat,
                    event.latlng.lng
                );


            if (
                alamat &&
                metodeJemput.checked
            ) {

                alamatInput.value =
                    alamat;
            }
        }
    );


    /*
    |--------------------------------------------------------------------------
    | LOKASI USER
    |--------------------------------------------------------------------------
    */

    function ambilLokasi() {

        if (!navigator.geolocation) {

            locationStatus.textContent =
                'Browser tidak mendukung lokasi.';

            return;
        }


        locationStatus.textContent =
            'Meminta izin lokasi...';


        navigator.geolocation.getCurrentPosition(

            async function (position) {

                const lat =
                    position.coords.latitude;

                const lng =
                    position.coords.longitude;


                updateLocation(
                    lat,
                    lng
                );


                locationStatus.textContent =
                    'Lokasi berhasil ditemukan.';


                const alamat =
                    await getAddress(
                        lat,
                        lng
                    );


                if (
                    alamat &&
                    metodeJemput.checked
                ) {

                    alamatInput.value =
                        alamat;
                }
            },

            function (error) {

                if (
                    error.code ===
                    error.PERMISSION_DENIED
                ) {

                    locationStatus.textContent =
                        'Izin lokasi ditolak. Pilih lokasi dari peta.';

                } else {

                    locationStatus.textContent =
                        'Gagal mendapatkan lokasi.';
                }
            },

            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }


    document.getElementById(
        'btnLocation'
    ).addEventListener(
        'click',
        ambilLokasi
    );


    document.getElementById(
        'btnRefreshLocation'
    ).addEventListener(
        'click',
        ambilLokasi
    );


    /*
    |--------------------------------------------------------------------------
    | CHECKBOX JENIS SAMPAH
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.sampah-check'
    ).forEach(
        function (checkbox) {

            checkbox.addEventListener(
                'change',
                function () {

                    const id =
                        this.dataset.id;

                    const weight =
                        document.getElementById(
                            'berat_' + id
                        );

                    weight.disabled =
                        !this.checked;

                    if (
                        !this.checked
                    ) {

                        weight.value = 0;

                    } else {

                        weight.focus();
                    }
                }
            );
        }
    );


    /*
    |--------------------------------------------------------------------------
    | JALANKAN AWAL
    |--------------------------------------------------------------------------
    */

    updateMetode();

    ambilLokasi();

});
</script>
@endsection