@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-slate-800">Edit Transaksi</h1>
        <a href="{{ route('admin.transaksi.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white font-semibold rounded-lg shadow-sm transition duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200/60 p-6 max-w-2xl mx-auto">
        <form action="{{ route('admin.transaksi.update', $transaksi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="pelanggan_id" class="block text-sm font-medium text-slate-700 mb-1">Pelanggan</label>
                <select name="pelanggan_id" id="pelanggan_id" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                    @foreach($pelanggans as $p)
                        <option value="{{ $p->id }}" {{ $transaksi->pelanggan_id == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="jenis_sampah_id" class="block text-sm font-medium text-slate-700 mb-1">Jenis Sampah</label>
                <select name="jenis_sampah_id" id="jenis_sampah_id" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                    @foreach($jenisSampahs as $j)
                        <option value="{{ $j->id }}" {{ $transaksi->jenis_sampah_id == $j->id ? 'selected' : '' }}>{{ $j->nama }} (Rp {{ number_format($j->harga_per_kg, 0, ',', '.') }}/kg)</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="berat" class="block text-sm font-medium text-slate-700 mb-1">Berat (kg)</label>
                <input type="number" step="0.01" id="berat" name="berat" value="{{ old('berat', $transaksi->berat) }}" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
            </div>

            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-slate-700 mb-1">Alamat (opsional)</label>
                <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $transaksi->alamat) }}" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div class="mb-4">
                <label for="tanggal" class="block text-sm font-medium text-slate-700 mb-1">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $transaksi->tanggal->format('Y-m-d')) }}" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                <select name="status" id="status" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="selesai" {{ $transaksi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ $transaksi->status == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg shadow-sm transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V8l-4-4H4z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20v-6h8v6"/>
                    </svg>
                    Update
                </button>
                <a href="{{ route('admin.transaksi.index') }}" class="inline-flex items-center px-6 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold rounded-lg transition duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection