@extends('layouts.admin')

@section('title', 'Edit Paket Penukaran')
@section('page_title', 'Edit Paket Penukaran')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Paket Penukaran</h1>
        <a href="{{ route('admin.exchange-package.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-medium transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 max-w-lg">
        <form action="{{ route('admin.exchange-package.update', $package->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="points" class="block text-sm font-medium text-gray-700">Jumlah Poin <span class="text-red-600">*</span></label>
                <input type="number" name="points" id="points" 
                       value="{{ old('points', $package->points) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                       min="1" required>
            </div>

            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah Uang (Rp) <span class="text-red-600">*</span></label>
                <input type="number" name="amount" id="amount" 
                       value="{{ old('amount', $package->amount) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                       min="1" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <input type="text" name="description" id="description" 
                       value="{{ old('description', $package->description) }}"
                       placeholder="Paket Hemat"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="is_active" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="is_active" id="is_active" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="1" {{ old('is_active', $package->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('is_active', $package->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition shadow">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4z M8 8h8v2H8V8z M8 12h8v2H8v-2z M8 16h4v2H8v-2z"/>
                </svg>
                Update Paket
            </button>
        </form>
    </div>
</div>
@endsection