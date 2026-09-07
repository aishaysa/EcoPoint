@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-slate-800">Edit Paket Penukaran</h1>
        <a href="{{ route('admin.exchange-packages.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white font-semibold rounded-lg shadow-sm transition duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200/60 p-6 max-w-2xl mx-auto">
        <form action="{{ route('admin.exchange-packages.update', $exchangePackage) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Paket</label>
                <input type="text" id="description" name="description" value="{{ old('description', $exchangePackage->description) }}" 
                       class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                       placeholder="Contoh: Paket 50 Poin">
            </div>

            <div class="mb-4">
                <label for="points" class="block text-sm font-medium text-slate-700 mb-1">Jumlah Poin</label>
                <input type="number" id="points" name="points" value="{{ old('points', $exchangePackage->points) }}" 
                       class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                       required min="1">
            </div>

            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-slate-700 mb-1">Jumlah Uang (Rp)</label>
                <input type="number" id="amount" name="amount" value="{{ old('amount', $exchangePackage->amount) }}" 
                       class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                       required min="1">
            </div>

            <div class="mb-6">
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ $exchangePackage->is_active ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500">
                    <label for="is_active" class="text-sm font-medium text-slate-700">Aktif</label>
                </div>
                <p class="text-xs text-slate-500 mt-1">Jika aktif, paket akan muncul di menu penukaran user.</p>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg shadow-sm transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V8l-4-4H4z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20v-6h8v6"/>
                    </svg>
                    Update
                </button>
                <a href="{{ route('admin.exchange-packages.index') }}" 
                   class="inline-flex items-center px-6 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold rounded-lg transition duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Toast Sukses --}}
@if(session('success'))
<div id="toast" class="fixed top-6 right-6 z-50 max-w-sm w-full transform transition-all duration-700 ease-out translate-x-0 opacity-100">
    <div class="bg-white rounded-2xl shadow-2xl border border-emerald-100 overflow-hidden relative">
        <div id="toastProgress" class="h-1 bg-gradient-to-r from-emerald-400 to-emerald-600 transition-all duration-[4000ms] ease-linear" style="width: 100%"></div>
        <div class="p-5 flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div class="flex-1 pt-0.5">
                <p class="text-sm font-semibold text-slate-800">Berhasil!</p>
                <p class="text-sm text-slate-600 leading-relaxed">{{ session('success') }}</p>
            </div>
            <button onclick="closeToast()" class="flex-shrink-0 mt-1 text-slate-400 hover:text-slate-600 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>
@endif

<script>
    @if(session('success'))
    let progressWidth = 100;
    const progressInterval = setInterval(function() {
        progressWidth -= 0.25;
        const progressBar = document.getElementById('toastProgress');
        if (progressBar) {
            progressBar.style.width = Math.max(progressWidth, 0) + '%';
        }
        if (progressWidth <= 0) {
            clearInterval(progressInterval);
            closeToast();
        }
    }, 10);

    function closeToast() {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.classList.remove('translate-x-0', 'opacity-100');
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => toast.remove(), 700);
        }
        clearInterval(progressInterval);
    }

    document.addEventListener('click', function(e) {
        const toast = document.getElementById('toast');
        if (toast && !toast.contains(e.target)) {
            closeToast();
        }
    });
    @endif
</script>

<style>
    #toast {
        transition: transform 0.7s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.5s ease;
    }
    #toast.translate-x-full {
        transform: translateX(calc(100% + 2rem));
    }
    #toast.opacity-0 {
        opacity: 0;
    }
    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    #toastProgress {
        transition: width 10ms linear;
    }
</style>
@endsection