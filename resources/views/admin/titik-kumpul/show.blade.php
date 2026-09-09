@extends('layouts.admin')

@section('title', 'Detail Titik Kumpul')
@section('page_title', 'Detail Titik Kumpul')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                {{-- Ikon header diubah jadi hijau --}}
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $titikKumpul->nama }}
            </h2>
            <div class="flex gap-2 mt-2 sm:mt-0">
                {{-- Tombol Edit hijau --}}
                <a href="{{ route('admin.titik-kumpul.edit', $titikKumpul->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.titik-kumpul.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition">
                    Kembali
                </a>
            </div>
        </div>

        {{-- Body --}}
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama --}}
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 mt-1">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</p>
                        <p class="text-gray-900 font-semibold">{{ $titikKumpul->nama }}</p>
                    </div>
                </div>

                {{-- Status --}}
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 mt-1">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status</p>
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-bold 
                            {{ $titikKumpul->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $titikKumpul->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>

                {{-- Alamat --}}
                <div class="flex items-start space-x-3 md:col-span-2">
                    <div class="flex-shrink-0 mt-1">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</p>
                        <p class="text-gray-900">{{ $titikKumpul->alamat ?: '-' }}</p>
                    </div>
                </div>

                {{-- Kontak --}}
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 mt-1">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</p>
                        <p class="text-gray-900">{{ $titikKumpul->kontak ?: '-' }}</p>
                    </div>
                </div>

                {{-- Latitude --}}
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 mt-1">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Latitude</p>
                        <p class="text-gray-900">{{ $titikKumpul->latitude ?: '-' }}</p>
                    </div>
                </div>

                {{-- Longitude --}}
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 mt-1">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Longitude</p>
                        <p class="text-gray-900">{{ $titikKumpul->longitude ?: '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Link Google Maps dengan warna hijau --}}
            @if($titikKumpul->latitude && $titikKumpul->longitude)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <a href="https://www.google.com/maps?q={{ $titikKumpul->latitude }},{{ $titikKumpul->longitude }}" 
                   target="_blank" 
                   class="inline-flex items-center text-sm text-green-600 hover:text-green-800 font-medium">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    Lihat di Google Maps
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection