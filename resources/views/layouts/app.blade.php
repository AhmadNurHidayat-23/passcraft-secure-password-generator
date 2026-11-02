<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PassCraft — Generator kata sandi acak yang sederhana, cepat, dan mudah digunakan.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PassCraft') }} — Generator Kata Sandi Aman</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="passcraft-body">
    <div class="passcraft-wrapper">
        <x-header />

        <main class="passcraft-main">
            @yield('content')
        </main>

        <x-footer />
    </div>
</body>
</html>
