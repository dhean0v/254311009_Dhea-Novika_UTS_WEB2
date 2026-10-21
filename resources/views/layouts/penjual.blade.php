@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row min-h-[calc(100vh-80px)]">
    <aside class="md:w-[230px] border-b md:border-b-0 md:border-r border-[#dde1ea] p-4 md:p-[18px] md:pt-8 flex flex-row md:flex-col flex-wrap gap-2 md:gap-[22px]">
        <a href="{{ route('homePenjual') }}"
           class="px-3 py-3 rounded-xl font-['Libre_Baskerville',serif] text-[15px] {{ request()->routeIs('homePenjual') ? 'bg-[linear-gradient(180deg,#82b4ff,#cfc4ff)] text-[#2878eb] font-bold' : '' }}">⌂ Dashboard</a>
        <a href="{{ route('penjual.edit') }}"
           class="px-3 py-3 rounded-xl font-['Libre_Baskerville',serif] text-[15px] {{ request()->routeIs('penjual.edit') ? 'bg-[linear-gradient(180deg,#82b4ff,#cfc4ff)] text-[#2878eb] font-bold' : '' }}">♙ Profil Toko</a>
        <a href="{{ route('penjual.ulasan') }}"
           class="px-3 py-3 rounded-xl font-['Libre_Baskerville',serif] text-[15px] {{ request()->routeIs('penjual.ulasan') ? 'bg-[linear-gradient(180deg,#82b4ff,#cfc4ff)] text-[#2878eb] font-bold' : '' }}">★ Ulasan</a>
        <a href="{{ route('tindaklanjut.index') }}"
           class="px-3 py-3 rounded-xl font-['Libre_Baskerville',serif] text-[15px] {{ request()->routeIs('tindaklanjut.*') ? 'bg-[linear-gradient(180deg,#82b4ff,#cfc4ff)] text-[#2878eb] font-bold' : '' }}">✎ Tindak Lanjut</a>
        
        <form method="POST" action="{{ route('auth.logout') }}" class="md:mt-auto">
            @csrf
            <button type="submit" class="px-3 py-3 text-[#e03a3a] font-bold cursor-pointer">⇥ Logout</button>
        </form>
    </aside>

    <section class="flex-1 p-5 md:p-10">
        @yield('isi')
    </section>
</div>
@endsection