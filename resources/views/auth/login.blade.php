<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Website</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex">
    <div class="w-1/2 flex flex-col justify-center px-20">
        <h2 class="text-4xl font-bold text-green-900 mb-10">Login Here!</h2>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block font-semibold text-lg mb-1 text-green-900">Email</label>
                <input type="email" name="email" class="w-full border border-gray-400 rounded-md p-3 focus:outline-none focus:ring focus:ring-green-300" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block font-semibold text-lg mb-1 text-green-900">Password</label>
                <input type="password" name="password" class="w-full border border-gray-400 rounded-md p-3 focus:outline-none focus:ring focus:ring-green-300" required>
            </div>
            <div class="flex gap-4 mt-6">
                <button type="submit" class="bg-green-900 text-white text-lg font-semibold px-8 py-2 rounded shadow-md hover:bg-green-800">Login</button>
                <a href="{{ route('register') }}" class="bg-orange-500 text-white text-lg font-semibold px-8 py-2 rounded shadow-md hover:bg-orange-600">Register</a>
            </div>
        </form>
    </div>
    <div class="w-1/2 bg-[#09111a] text-white flex items-center justify-center">
        <img src="{{ asset('img/logopetatani.png') }}" alt="Logo Petatani" class="max-w-sm">
    </div>
</body>
</html> 