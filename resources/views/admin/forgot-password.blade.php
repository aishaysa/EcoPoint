<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f4f7f6] flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-blue-600 px-6 py-8 text-center">
            <h2 class="text-2xl font-bold text-white">Reset Password</h2>
            <p class="text-blue-100 text-sm mt-1">Masukkan email Anda, kami akan kirim link reset</p>
        </div>

        <div class="p-8">
            @if(session('status'))
                <div class="mb-4 p-3 bg-green-100 border border-green-200 text-green-700 rounded-lg text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form action="#" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors">
                    Kirim Link Reset
                </button>

                <p class="text-center text-xs text-gray-500 mt-4">
                    Kembali ke <a href="{{ route('admin.login') }}" class="text-blue-600 hover:underline">Halaman Login</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>