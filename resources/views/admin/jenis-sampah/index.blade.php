@extends('layouts.admin')

@section('title', 'Sampah & Harga')
@section('page_title', 'Sampah & Harga')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">
            Data Jenis Sampah
        </h1>

        <a href="{{ route('admin.jenis-sampah.create') }}"
           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow transition duration-200">

            <svg class="w-5 h-5 mr-2"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4"/>

            </svg>

            Tambah Jenis Sampah
        </a>
    </div>

    {{-- PESAN ERROR --}}
    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- TABEL --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow-md border border-gray-200">

        <table class="min-w-full divide-y divide-gray-200">

            {{-- HEADER TABEL --}}
            <thead class="bg-gray-50">
                <tr>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        No
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Poin / Kg
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Deskripsi
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>

                </tr>
            </thead>

            {{-- ISI TABEL --}}
            <tbody class="bg-white divide-y divide-gray-200">

                @forelse($jenisSampahs as $item)

                    <tr class="hover:bg-gray-50 transition duration-150">

                        {{-- NO --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $loop->iteration }}
                        </td>

                        {{-- NAMA --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $item->nama }}
                        </td>

                        {{-- POIN --}}
                        <td class="px-6 py-4 whitespace-nowrap">

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800">
                                {{ $item->poin_per_kg }} poin
                            </span>

                        </td>

                        {{-- DESKRIPSI --}}
                        <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                            {{ $item->deskripsi ?? '-' }}
                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">

                            {{-- EDIT --}}
                            <a href="{{ route('admin.jenis-sampah.edit', $item->id) }}"
                               class="inline-flex items-center px-3 py-1 bg-green-100 hover:bg-green-200 text-green-700 rounded-md transition">

                                <svg class="w-4 h-4 mr-1"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>

                                </svg>

                                Edit
                            </a>

                            {{-- HAPUS --}}
                            <form action="{{ route('admin.jenis-sampah.destroy', $item->id) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus jenis sampah ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded-md transition">

                                    <svg class="w-4 h-4 mr-1"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>

                                    </svg>

                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5"
                            class="px-6 py-10 text-center text-gray-500">

                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>

                            </svg>

                            <p class="text-lg">
                                Belum ada jenis sampah
                            </p>

                            <p class="text-sm">
                                Klik tombol "Tambah Jenis Sampah"
                                untuk menambahkan data pertama.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- TOAST SUCCESS --}}
@if(session('success'))

<div id="toast"
     class="fixed top-6 right-6 z-50 max-w-sm w-full transform transition-all duration-700 ease-out translate-x-0 opacity-100">

    <div class="bg-white rounded-2xl shadow-2xl border border-green-100 overflow-hidden relative">

        {{-- PROGRESS BAR --}}
        <div id="toastProgress"
             class="h-1 bg-gradient-to-r from-green-400 to-green-600"
             style="width: 100%">
        </div>

        <div class="p-5 flex items-start gap-4">

            {{-- ICON --}}
            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-lg">

                <svg class="w-7 h-7 text-white"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2.5"
                          d="M5 13l4 4L19 7"/>

                </svg>

            </div>

            {{-- TEXT --}}
            <div class="flex-1 pt-0.5">

                <p class="text-sm font-semibold text-gray-800">
                    Berhasil!
                </p>

                <p class="text-sm text-gray-600 leading-relaxed">
                    {{ session('success') }}
                </p>

            </div>

            {{-- CLOSE --}}
            <button onclick="closeToast()"
                    class="flex-shrink-0 mt-1 text-gray-400 hover:text-gray-600 transition-colors duration-200">

                <svg class="w-5 h-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>

                </svg>

            </button>

        </div>

    </div>

</div>

<script>

let progressWidth = 100;

const progressInterval = setInterval(function() {

    progressWidth -= 0.25;

    const progressBar = document.getElementById('toastProgress');

    if (progressBar) {

        progressBar.style.width =
            Math.max(progressWidth, 0) + '%';

    }

    if (progressWidth <= 0) {

        clearInterval(progressInterval);

        closeToast();

    }

}, 10);


function closeToast() {

    const toast = document.getElementById('toast');

    if (toast) {

        toast.classList.remove(
            'translate-x-0',
            'opacity-100'
        );

        toast.classList.add(
            'translate-x-full',
            'opacity-0'
        );

        setTimeout(function() {

            toast.remove();

        }, 700);

    }

    clearInterval(progressInterval);

}

</script>

<style>

#toast {

    transition:
        transform 0.7s cubic-bezier(0.34, 1.56, 0.64, 1),
        opacity 0.5s ease;

}

#toast.translate-x-full {

    transform:
        translateX(calc(100% + 2rem));

}

#toast.opacity-0 {

    opacity: 0;

}

</style>

@endif

@endsection