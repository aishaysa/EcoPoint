<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - EcoPoint</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            Login Admin
        </h2>

        {{-- pesan sukses --}}
        @if (session('status'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        {{-- pesan error --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            {{-- EMAIL --}}
            <div class="mb-4">
                <label
                    for="email"
                    class="block text-sm font-medium text-gray-700 mb-1"
                >
                    Alamat Email
                </label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg
                           focus:ring-2 focus:ring-green-500
                           focus:border-green-500
                           outline-none transition-colors
                           @error('email') border-red-500 @enderror"
                    placeholder="admin@example.com"
                >

                @error('email')
                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- PASSWORD --}}
            <div class="mb-6">
                <label
                    for="password"
                    class="block text-sm font-medium text-gray-700 mb-1"
                >
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg
                           focus:ring-2 focus:ring-green-500
                           focus:border-green-500
                           outline-none transition-colors
                           @error('password') border-red-500 @enderror"
                    placeholder="********"
                >

                @error('password')
                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            

            {{-- REMEMBER + LUPA PASSWORD --}}
            <div class="flex items-center justify-between mb-6">

                <label class="flex items-center text-sm text-gray-600">
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        class="mr-2 rounded border-gray-300
                               text-green-600 focus:ring-green-500"
                    >
                    Ingat saya
                </label>

                {{-- sementara jangan pakai href # --}}
                <span class="text-sm text-gray-400 cursor-not-allowed">
                    Lupa password?
                </span>

            </div>

            {{-- BUTTON --}}
            <button
                type="submit"
                class="w-full bg-green-600 hover:bg-green-700
                       text-white font-semibold py-2 px-4
                       rounded-lg transition duration-200"
            >
                Masuk
            </button>
        </form>

        {{-- KEMBALI KE HOME --}}
        <div class="mt-4 text-center text-sm text-gray-500">
            <a
                href="{{ route('home') }}"
                class="hover:underline"
            >
                Kembali ke Beranda
            </a>
        </div>

    </div>

</body>
</html>