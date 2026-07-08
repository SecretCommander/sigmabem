<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Forbidden</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-red-500 mb-4">403</h1>
        <p class="text-xl text-gray-600 mb-6">
            @if (Session::has('error'))
                {{ Session::get('error') }}
            @else
                Anda tidak memiliki akses ke halaman ini.
            @endif
        </p>
        <a href="{{ route('dashboard') }}"
            class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
            Kembali ke Dashboard
        </a>
    </div>
</body>

</html>
