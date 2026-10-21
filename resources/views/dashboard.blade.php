@extends('layouts.app')
@section('title', 'Beranda')

@section('content')
<section class="bg-[linear-gradient(180deg,#82b4ff,#cfc4ff)] rounded-[40px] mx-4 md:mx-10 my-6 px-6 md:px-11 py-12">
    <h1 class="font-['Anton',sans-serif] font-normal text-4xl md:text-[44px] leading-tight">Temukan Penjual<br>Terbaik dari Ulasan Pembeli</h1>
    <p class="text-[#6b7385] mt-2.5 mb-4">Bantu pembeli lain dengan memberikan ulasan jujur.</p>
    <form onsubmit="return false" class="flex max-w-[470px]">
        <input type="text" id="cari" placeholder="Cari nama penjual atau alamat..."
               class="flex-1 min-w-0 px-4 py-3.5 border border-[#dde1ea] rounded-l-[10px] outline-none bg-white text-sm">
        <button type="submit" class="w-12 bg-[#2878eb] text-white rounded-r-[10px]">⌕</button>
    </form>
</section>

<section id="daftar-penjual" class="px-5 md:px-[55px] pb-12">
    <h2 class="text-[26px] font-bold">Daftar Penjual</h2>
    <p class="text-sm text-[#6b7385] mb-5">Pilih penjual lalu isi ulasan tanpa login.</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
        @forelse($penjualList as $i => $p)
            @php $rata = $p->ulasan->avg('Rating') ?? 0; @endphp
            <div class="kartu-penjual border border-[#dde1ea] rounded-[40px] p-3 bg-white"
                 data-nama="{{ strtolower($p->Nama_Penjual . ' ' . $p->Alamat_Penjual) }}">
                <!-- <div class="h-[116px] rounded-[26px] bg-[linear-gradient(180deg,#82b4ff,#cfc4ff)] grid place-items-center text-[#2878eb] font-bold text-xl">
                    FOTO {{ $i + 1 }}
                </div> -->
                <h3 class="text-base font-bold mt-4 mx-1 mb-2">{{ $p->Nama_Penjual }}</h3>
                <small class="block text-sm text-[#6b7385] mx-1 mb-3.5 line-clamp-1">{{ $p->Alamat_Penjual }}</small>
                <p class="text-[#f5a623] font-['Libre_Baskerville',serif] text-sm mx-1 mb-2.5">
                    ★ {{ number_format($rata, 1) }} ({{ $p->ulasan->count() }} ulasan)
                </p>
                <a href="{{ route('penjual.detail', $p->Id_Penjual) }}"
                   class="block w-full text-center py-2.5 rounded-lg font-bold border border-[#2878eb] text-[#2878eb] bg-white">Lihat Detail</a>
            </div>
        @empty
            <p class="col-span-full py-8 text-center text-[#6b7385]">Belum ada data penjual terdaftar.</p>
        @endforelse
    </div>

    <p id="tidakAda" class="hidden py-8 text-center text-[#6b7385]">Penjual tidak ditemukan.</p>
</section>

<script>
    document.getElementById('cari').addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        let ada = false;
        document.querySelectorAll('.kartu-penjual').forEach(function (k) {
            const cocok = k.dataset.nama.includes(q);
            k.classList.toggle('hidden', !cocok);
            if (cocok) ada = true;
        });
        document.getElementById('tidakAda').classList.toggle('hidden', ada || q === '');
    });
</script>
@endsection