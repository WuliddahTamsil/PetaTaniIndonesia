<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Website</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex">
    <div class="w-1/2 flex flex-col justify-center px-20">
        <h2 class="text-4xl font-bold text-green-900 mb-10">Create Account</h2>
        <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block font-semibold text-lg mb-1 text-green-900">Name</label>
                <input type="text" name="name" class="w-full border border-gray-400 rounded-md p-3" required>
            </div>
            <div>
                <label class="block font-semibold text-lg mb-1 text-green-900">Email</label>
                <input type="email" name="email" class="w-full border border-gray-400 rounded-md p-3" required>
            </div>
            <div>
                <label class="block font-semibold text-lg mb-1 text-green-900">Password</label>
                <input type="password" name="password" class="w-full border border-gray-400 rounded-md p-3" required>
            </div>
            <div>
                <label class="block font-semibold text-lg mb-1 text-green-900">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full border border-gray-400 rounded-md p-3" required>
            </div>
            <button type="submit" class="bg-orange-500 text-white text-lg font-semibold px-8 py-2 rounded shadow-md hover:bg-orange-600 w-full">Register</button>
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-green-800 font-semibold text-sm">Already have an account? Login here</a>
            </div>
        </form>
    </div>
    <div class="w-1/2 bg-[#09111a] text-white flex items-center justify-center">
        <img src="{{ asset('img/logopetatani.png') }}" alt="Logo Petatani" class="max-w-sm">
    </div>
</body>
</html>
