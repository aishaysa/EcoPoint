@extends('layouts.admin')

@section('title', 'Detail Titik Kumpul')
@section('page_title', 'Detail Titik Kumpul')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 max-w-2xl">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Detail Titik Kumpul</h2>
            <a href="{{ route('admin.titik-kumpul.index') }}" class="text-sm bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">Kembali</a>
        </div>

        <div class="space-y-3">
            <div>
                <span class="text-sm font-medium text-gray-500">Nama</span>
                <p class="text-gray-900 font-semibold">{{ $titikKumpul->nama }}</p>
            </div>
            <div>
                <span class="text-sm font-medium text-gray-500">Alamat</span>
                <p class="text-gray-900">{{ $titikKumpul->alamat ?: '-' }}</p>
            </div>
            <div>
                <span class="text-sm font-medium text-gray-500">Kontak</span>
                <p class="text-gray-900">{{ $titikKumpul->kontak ?: '-' }}</p>
            </div>
            <div>
                <span class="text-sm font-medium text-gray-500">Status</span>
                <p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold 
                        {{ $titikKumpul->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $titikKumpul->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </p>
            </div>
            <div>
                <span class="text-sm font-medium text-gray-500">Latitude</span>
                <p class="text-gray-900">{{ $titikKumpul->latitude ?: '-' }}</p>
            </div>
            <div>
                <span class="text-sm font-medium text-gray-500">Longitude</span>
                <p class="text-gray-900">{{ $titikKumpul->longitude ?: '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection