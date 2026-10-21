@extends('layouts.app')
@section('title', 'Detail Penjual')

@section('content')
@php
    $ulasanList = $penjual->ulasan->sortByDesc('created_at')->values();
    $rata = $ulasanList->avg('Rating') ?? 0;
@endphp

<div class="max-w-[1120px] mx-auto px-5 py-10">
    <h1 class="text-3xl font-bold mb-1.5">Detail Penjual</h1>
    <p class="text-sm text-[#6b7385] mb-7">Pengunjung dapat melihat ulasan dan langsung memberi ulasan tanpa login.</p>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-7 items-start">
        <div>
            <!-- Informasi Toko -->
            <div class="border border-[#dde1ea] rounded-[32px] p-7 bg-white">
                <div class="flex items-center gap-5">
                    <div class="w-[138px] h-[106px] shrink-0 rounded-[22px] bg-[linear-gradient(180deg,#82b4ff,#cfc4ff)] grid place-items-center text-[#2878eb] font-bold">TOKO</div>
                    <div>
                        <h2 class="text-[22px] font-bold mb-1.5">{{ $penjual->Nama_Penjual }}</h2>
                        <p class="text-sm text-[#6b7385]">
                            {{ $penjual->Alamat_Penjual ?? '-' }} | {{ $penjual->No_Telp_Penjual ?? '-' }}
                        </p>
                        <p class="mt-2.5 text-[#f5a623] font-['Libre_Baskerville',serif]">
                            ★ {{ number_format($rata, 1) }} &bull; {{ $ulasanList->count() }} ulasan
                        </p>
                    </div>
                </div>
                <p class="mt-5 text-sm text-[#6b7385]">{{ $penjual->Deskripsi ?? 'Tidak ada deskripsi.' }}</p>
            </div>

            <!-- Daftar Ulasan Pembeli -->
            <div class="border border-[#dde1ea] rounded-[40px] p-7 bg-white mt-6">
                <h2 class="text-[22px] font-bold mb-4">Ulasan Pembeli</h2>

                @forelse($ulasanList as $index => $u)
                    <div class="review-item flex items-start gap-3.5 py-4 border-b border-[#dde1ea] last:border-b-0 {{ $index >= 3 ? 'extra-review hidden' : '' }}">
                        <span class="w-5 h-5 rounded-full bg-[#2878eb] shrink-0 mt-1"></span>
                        <div class="flex-1 text-sm">
                            <b class="block mb-1">{{ $u->Nama_Pembeli }}</b>
                            <span class="text-[#f5a623]">{{ str_repeat('★', $u->Rating) }}</span>
                            <p class="mt-1 text-gray-800">{{ $u->Ulasan }}</p>

                            {{-- Menampilkan balasan penjual jika sudah ada --}}
                            @if($u->respon)
                                <div class="mt-3 p-3 bg-gray-50 rounded-xl border border-[#dde1ea] text-xs text-gray-700">
                                    <span class="font-bold text-gray-900 block mb-0.5">Balasan dari Penjual:</span>
                                    {{ $u->respon->Respon }}
                                </div>
                            @endif
                        </div>
                        <span class="text-xs text-[#6b7385] whitespace-nowrap">{{ $u->created_at?->locale('id')->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="py-8 text-center text-[#6b7385]">Belum ada ulasan. Jadilah yang pertama!</p>
                @endforelse

                @if($ulasanList->count() > 3)
                    <button id="toggleReviewBtn" type="button"
                            class="mt-4 px-4 py-2 border border-[#dde1ea] rounded-lg text-sm font-bold cursor-pointer hover:bg-gray-50 transition">
                        Lihat Selengkapnya ({{ $ulasanList->count() - 3 }} ulasan lagi)
                    </button>
                @endif
            </div>
        </div>

        <!-- Form Tambah Ulasan untuk Pengunjung -->
        <div>
            @include('form-ulasan')
        </div>
    </div>
</div>

@if($ulasanList->count() > 3)
<script>
    const btn = document.getElementById('toggleReviewBtn');
    const sisa = {{ $ulasanList->count() - 3 }};
    btn.addEventListener('click', function () {
        const extra = document.querySelectorAll('.extra-review');
        const sembunyi = extra[0].classList.contains('hidden');
        extra.forEach(function (el) { el.classList.toggle('hidden', !sembunyi); });
        btn.textContent = sembunyi ? 'Tampilkan Lebih Sedikit' : 'Lihat Selengkapnya (' + sisa + ' ulasan lagi)';
    });
</script>
@endif
@endsection