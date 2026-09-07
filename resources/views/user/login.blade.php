<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - EcoPoint</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="bg-green-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-green-700"><i class="fas fa-recycle"></i> EcoPoint</h1>
            <p class="text-slate-500 text-sm">Masuk ke akun Anda</p>
        </div>

        <!-- Tampilkan error jika login gagal -->
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-200 text-red-700 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400" required />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700">Password</label>
                <input type="password" name="password" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400" required />
            </div>
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition duration-200">Masuk</button>
        </form>
        <p class="mt-4 text-center text-sm text-slate-500">
            Belum punya akun? <a href="{{ route('register') }}" class="text-green-600 hover:underline">Daftar di sini</a>
        </p>
    </div>
</body>
</html>