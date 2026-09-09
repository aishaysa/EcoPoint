@extends('layouts.admin')

@section('title', 'Paket Penukaran Poin')
@section('page_title', 'Paket Penukaran Poin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Paket Penukaran Poin</h1>
        <a href="{{ route('admin.exchange-package.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow transition duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Paket
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow-md border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poin</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Uang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($packages as $pkg)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $pkg->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ number_format($pkg->points) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Rp {{ number_format($pkg->amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $pkg->description ?? '—' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                     {{ $pkg->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $pkg->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-1.5">
                        <a href="{{ route('admin.exchange-package.edit', $pkg->id) }}" 
                           class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-md text-xs font-medium transition">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <button type="button" 
                                class="delete-btn inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-md text-xs font-medium transition"
                                data-id="{{ $pkg->id }}"
                                data-nama="Paket {{ $pkg->points }} Poin"
                                data-form-id="delete-form-{{ $pkg->id }}">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                        <form action="{{ route('admin.exchange-package.destroy', $pkg->id) }}" 
                              method="POST" 
                              id="delete-form-{{ $pkg->id }}" 
                              class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-lg">Belum ada paket penukaran</p>
                        <p class="text-sm">Tambahkan paket baru untuk memulai.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL & TOAST sama seperti transaksi --}}
@endsection