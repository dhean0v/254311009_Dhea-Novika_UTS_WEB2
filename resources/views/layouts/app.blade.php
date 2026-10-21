<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'UlasinYuk') - UlasinYuk</title>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Libre+Baskerville:wght@400;700&family=Archivo:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="font-['Archivo',sans-serif] text-[#12294f] bg-white">
    <header class="flex items-center justify-between px-4 md:px-10 py-3 border-b border-[#dde1ea]">
        <div class="flex items-center gap-4">
            @guest
            <div class="flex items-center gap-3.5">
                <a href="{{ route('dashboard') }}" class="block">
                    <div class="font-['Libre_Baskerville',serif] text-2xl font-bold">UlasinYuk</div>
                    <small class="block text-[11px] text-[#6b7385]">Ulasan untuk Penjual Terpercaya</small>
                </a>
                <nav class="hidden md:flex items-center mt-2">
                    <a href="{{ route('dashboard') }}"
                        class="mx-4 {{ request()->routeIs('dashboard') ? 'text-[#12294f] font-bold' : 'text-[#6b7385]' }}">Beranda</a>
                    <a href="{{ route('dashboard') }}#daftar-penjual" class="mx-4 {{ request()->fullUrlIs(url('/dashboard') . '#daftar-penjual') ? 'text-[#12294f] font-bold' : 'text-[#6b7385]' }}">Daftar Penjual</a>
                </nav>
            </div>
            @endguest
            @auth
            <div>
                <a href="{{ route('homePenjual') }}" class="block">
                    <div class="font-['Libre_Baskerville',serif] text-2xl font-bold">UlasinYuk</div>
                    <small class="block text-[11px] text-[#6b7385]">Ulasan untuk Penjual Terpercaya</small>
                </a>
                <nav class="hidden md:flex items-center mt-2">
                </nav>
            </div>
            @endauth
        </div>


        <div class="flex items-center gap-3.5">
            @guest
            <a href="{{ route('login') }}" class="text-sm font-bold text-[#2878eb]">Login</a>
            <a href="{{ route('register') }}" class="text-sm font-bold px-4 py-2 rounded-lg bg-[#2878eb] text-white">Daftar</a>
            @endguest
            @auth
            <a href="{{ route('homePenjual') }}" class="flex items-center gap-3">
                <div class="w-[50px] h-[50px] bg-[#2878eb] text-white rounded-[10px] grid place-items-center font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="text-xs font-bold hidden sm:inline">{{ auth()->user()->name }} ▾</span>
            </a>
            @endauth
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>