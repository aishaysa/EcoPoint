@extends('layouts.admin')

@section('title', 'Pengaturan Poin')
@section('page_title', ' Pengaturan Poin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 max-w-lg">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Atur Konversi Poin</h2>
        <p class="text-sm text-gray-600 mb-4">
            Tentukan berapa poin yang didapat user per 1 kg sampah yang disetor.
        </p>

        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="poin_per_kg" class="block text-sm font-medium text-gray-700">Poin per 1 kg</label>
                <input type="number" name="poin_per_kg" id="poin_per_kg"
                       value="{{ old('poin_per_kg', $poinPerKg) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                       min="1" required>
                <p class="text-xs text-gray-500 mt-1">Contoh: 100 = 1 kg dapat 100 poin</p>
            </div>

            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4z M8 8h8v2H8V8z M8 12h8v2H8v-2z M8 16h4v2H8v-2z"/>
                </svg>
                Simpan Pengaturan
            </button>
        </form>
    </div>
</div>
@endsection