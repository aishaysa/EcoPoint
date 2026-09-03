@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Profil Admin</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi akun Anda di sini</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            {{-- Bagian Avatar --}}
            <div class="px-6 py-8 flex items-center space-x-6 border-b border-gray-100 bg-gray-50/50">
                <img class="h-20 w-20 rounded-full object-cover border-4 border-white shadow-sm" src="https://ui-avatars.com/api/?name=Admin+User&background=0D8ABC&color=fff" alt="Admin Avatar">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Admin User</h2>
                    <p class="text-sm text-gray-500">admin@example.com</p>
                    <button class="mt-2 text-sm text-blue-600 hover:text-blue-800 font-medium">Ganti Foto</button>
                </div>
            </div>

            {{-- Form Update Profile --}}
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" value="Admin User" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" value="admin@example.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bio / Tentang Saya</label>
                    <textarea rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">Seorang admin yang mengelola sistem dengan penuh dedikasi.</textarea>
                </div>
                
                <div class="border-t border-gray-200 pt-6 flex justify-end">
                    <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection