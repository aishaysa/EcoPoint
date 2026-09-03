@extends('layouts.admin')

@section('title', 'Tambah Jenis Sampah')
@section('page_title', 'Tambah Jenis Sampah')

@section('content')

<div class="container mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">

        <h1 class="text-2xl font-bold text-gray-800">
            Tambah Jenis Sampah
        </h1>

        <a href="{{ route('admin.jenis-sampah.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow transition duration-200">

            <svg class="w-5 h-5 mr-2"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>

            </svg>

            Kembali

        </a>

    </div>


    {{-- ERROR --}}
    @if($errors->any())

        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow-sm">

            <ul class="list-disc list-inside">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- FORM --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 max-w-2xl mx-auto">

        <form action="{{ route('admin.jenis-sampah.store') }}"
              method="POST">

            @csrf


            {{-- NAMA --}}
            <div class="mb-4">

                <label for="nama"
                       class="block text-sm font-medium text-gray-700 mb-1">

                    Nama Sampah

                </label>

                <input type="text"
                       id="nama"
                       name="nama"
                       value="{{ old('nama') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                       placeholder="Contoh: Botol Plastik, Kertas, Kaca"
                       required>

            </div>


            {{-- POIN --}}
            <div class="mb-4">

                <label for="poin_per_kg"
                       class="block text-sm font-medium text-gray-700 mb-1">

                    Poin per Kg

                </label>

                <input type="number"
                       id="poin_per_kg"
                       name="poin_per_kg"
                       value="{{ old('poin_per_kg', 1) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                       placeholder="Contoh: 5"
                       min="0"
                       required>

                <p class="text-xs text-gray-500 mt-1">

                    * Jumlah poin yang didapat pelanggan
                    per kg sampah ini

                </p>

            </div>


            {{-- DESKRIPSI --}}
            <div class="mb-6">

                <label for="deskripsi"
                       class="block text-sm font-medium text-gray-700 mb-1">

                    Deskripsi (Opsional)

                </label>

                <textarea id="deskripsi"
                          name="deskripsi"
                          rows="3"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                          placeholder="Deskripsi singkat tentang jenis sampah ini">{{ old('deskripsi') }}</textarea>

            </div>


            {{-- BUTTON --}}
            <div class="flex items-center gap-3">

                <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow transition duration-200">

                    <svg class="w-5 h-5 mr-2"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 4v16m8-8H4"/>

                    </svg>

                    Simpan

                </button>


                <a href="{{ route('admin.jenis-sampah.index') }}"
                   class="inline-flex items-center px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg transition duration-200">

                    Batal

                </a>

            </div>

        </form>

    </div>

</div>

@endsection