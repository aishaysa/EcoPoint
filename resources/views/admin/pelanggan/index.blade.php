@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Pelanggan</h1>
            <p class="text-sm text-slate-500">Daftar semua pelanggan terdaftar beserta aktivitas setoran</p>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow-sm border border-slate-200/60">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">No HP</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Alamat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Poin</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Total Setoran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-100">
                @forelse($pelanggans as $p)
                <tr class="hover:bg-slate-50/80 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $p->nama }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $p->no_hp ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600 max-w-xs truncate">{{ $p->alamat ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-emerald-100 text-emerald-800">
                            {{ $p->poin }}
                        </span>
                    </td>
                    {{-- 🔥 INI PERBAIKAN: Total Setoran --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                        {{ $p->setorans_count ?? 0 }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        {{-- Detail --}}
                        <a href="{{ route('admin.pelanggan.show', $p->id) }}" 
                           class="inline-flex items-center px-3 py-1.5 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-md transition text-xs font-medium">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Detail
                        </a>

                        {{-- Form hapus --}}
                        <form action="{{ route('admin.pelanggan.destroy', $p->id) }}" 
                              method="POST" 
                              id="delete-form-{{ $p->id }}" 
                              class="inline">
                            @csrf
                            @method('DELETE')
                        </form>

                        {{-- Tombol Hapus (trigger modal) --}}
                        <button type="button" 
                                class="delete-btn inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-md transition text-xs font-medium"
                                data-id="{{ $p->id }}"
                                data-nama="{{ $p->nama }}"
                                data-form-id="delete-form-{{ $p->id }}">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                        <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p class="text-lg font-medium">Belum ada pelanggan</p>
                        <p class="text-sm">Klik tombol "Tambah Pelanggan" untuk menambahkan data pertama.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
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

{{-- Toast Batal --}}
<div id="cancelToastContainer"></div>

{{-- ===== MODAL KONFIRMASI HAPUS ===== --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur-sm transition-all duration-300">
    <div id="deleteModalContent" class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0 p-6">
        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-center text-slate-800 mb-2">Hapus Pelanggan?</h3>
        <p class="text-sm text-center text-slate-600 mb-6">
            Apakah Anda yakin ingin menghapus pelanggan <span id="modalNama" class="font-semibold text-slate-800"></span>? 
            Tindakan ini tidak dapat dibatalkan.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button id="modalCancelBtn" 
                    class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2">
                Batal
            </button>
            <button id="modalConfirmBtn" 
                    class="px-6 py-2.5 bg-white border-2 border-red-600 text-red-600 hover:bg-red-50 rounded-lg text-sm font-medium transition focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    // === Toast Sukses ===
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
            setTimeout(function() {
                toast.remove();
            }, 700);
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

    // === Toast Batal ===
    function showCancelToast(message) {
        const container = document.getElementById('cancelToastContainer');
        container.innerHTML = '';
        const toast = document.createElement('div');
        toast.id = 'cancelToast';
        toast.className = 'fixed top-6 right-6 z-50 max-w-sm w-full transform transition-all duration-700 ease-out translate-x-0 opacity-100';
        toast.innerHTML = `
            <div class="bg-white rounded-2xl shadow-2xl border border-yellow-100 overflow-hidden relative">
                <div class="p-5 flex items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="flex-1 pt-0.5">
                        <p class="text-sm font-semibold text-slate-800">Dibatalkan</p>
                        <p class="text-sm text-slate-600 leading-relaxed">${message}</p>
                    </div>
                    <button onclick="this.closest('#cancelToast').remove()" class="flex-shrink-0 mt-1 text-slate-400 hover:text-slate-600 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(toast);

        setTimeout(() => {
            const el = document.getElementById('cancelToast');
            if (el) {
                el.classList.remove('translate-x-0', 'opacity-100');
                el.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => el.remove(), 700);
            }
        }, 2500);
    }

    // === MODAL KONFIRMASI HAPUS ===
    (function() {
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('deleteModalContent');
        const modalNama = document.getElementById('modalNama');
        const cancelBtn = document.getElementById('modalCancelBtn');
        const confirmBtn = document.getElementById('modalConfirmBtn');

        let currentFormId = null;

        function showModal(nama, formId) {
            modalNama.textContent = nama;
            currentFormId = formId;
            modal.classList.remove('hidden');
            requestAnimationFrame(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            });
            setTimeout(() => cancelBtn.focus(), 150);
        }

        function hideModal() {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                currentFormId = null;
            }, 300);
        }

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const nama = this.dataset.nama;
                const formId = this.dataset.formId;
                if (formId) {
                    showModal(nama, formId);
                }
            });
        });

        cancelBtn.addEventListener('click', function() {
            const nama = modalNama.textContent;
            hideModal();
            showCancelToast('Penghapusan pelanggan "' + nama + '" dibatalkan');
        });

        confirmBtn.addEventListener('click', function() {
            if (currentFormId) {
                const form = document.getElementById(currentFormId);
                if (form) {
                    form.submit();
                }
            }
            hideModal();
        });

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                const nama = modalNama.textContent;
                hideModal();
                showCancelToast('Penghapusan pelanggan "' + nama + '" dibatalkan');
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                const nama = modalNama.textContent;
                hideModal();
                showCancelToast('Penghapusan pelanggan "' + nama + '" dibatalkan');
            }
        });
    })();
</script>

<style>
    #toast, #cancelToast {
        transition: transform 0.7s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.5s ease;
    }
    #toast.translate-x-full, #cancelToast.translate-x-full {
        transform: translateX(calc(100% + 2rem));
    }
    #toast.opacity-0, #cancelToast.opacity-0 {
        opacity: 0;
    }
    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    #toastProgress {
        transition: width 10ms linear;
    }
    #deleteModalContent {
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
    }
    #deleteModal:not(.hidden) {
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }
    button:focus-visible {
        outline: 2px solid transparent;
    }
</style>
@endsection