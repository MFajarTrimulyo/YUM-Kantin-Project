<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - YUM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-6 font-sans">

    <div class="max-w-5xl w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        
        <div class="w-full max-w-md mx-auto">
            <div class="mb-8">
                <span class="bg-yum-primary text-white px-4 py-1 text-3xl font-medium inline-block">Haii!</span>
                <h1 class="text-3xl md:text-4xl font-medium mt-2 text-gray-900">Selamat Datang di <span class="font-fredoka font-semibold text-yum-primary">Y</span><span class="font-fredoka font-semibold text-yum-yellow">U</span><span class="font-fredoka font-semibold text-black">M</span>!</h1>
                <p class="text-lg mt-2 text-gray-600">Website Kantin Universitas Negeri Malang</p>
            </div>

            <div class="border-2 border-slate-300 p-8 bg-white shadow-[8px_8px_0px_0px_rgba(37,99,235,0.2)] rounded-sm">
                @yield('content')
            </div>
        </div>

        <div class="hidden md:flex justify-end relative">
            <img src="{{ asset('pictures/happy-cakra.png') }}" alt="YUM Mascot" class="max-w-sm w-full object-contain drop-shadow-2xl">
        </div>

    </div>

</body>
</html>