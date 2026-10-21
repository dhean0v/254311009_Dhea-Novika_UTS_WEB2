@extends('layouts.penjual')
@section('title', 'Ulasan Pelanggan')

@section('isi')
@php $ulasanList = $penjual?->ulasan ?? collect(); @endphp

<h1 class="text-3xl font-bold mb-1.5">Ulasan Pelanggan</h1>
<p class="text-sm text-[#6b7385] mb-7">Semua ulasan yang masuk ke toko.</p>

{{-- Notifikasi Sukses --}}
@if(session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
        {{ session('success') }}
    </div>
@endif

<div class="border border-[#dde1ea] rounded-[40px] p-7 bg-white">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr>
                    <th class="text-left px-3 py-2.5">Nama Pembeli</th>
                    <th class="text-left px-3 py-2.5">Rating</th>
                    <th class="text-left px-3 py-2.5">Komentar & Respon</th>
                    <th class="text-right px-3 py-2.5">Tanggal</th>
                    <th class="text-right px-3 py-2.5">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($ulasanList->sortByDesc('created_at') as $u)
                <tr>
                    <!-- Nama Pembeli -->
                    <td class="px-3 py-5 border-t border-[#dde1ea] font-medium align-top">
                        {{ $u->Nama_Pembeli }}
                    </td>

                    <!-- Rating Bintang -->
                    <td class="px-3 py-5 border-t border-[#dde1ea] text-[#f5a623] align-top">
                        {{ str_repeat('★', $u->Rating) }}
                    </td>

                    <!-- Komentar & Form Respon -->
                    <td class="px-3 py-5 border-t border-[#dde1ea] align-top">
                        <div class="mb-2 font-medium text-gray-900">"{{ $u->Ulasan }}"</div>

                        {{-- Jika ulasan sudah direspon, tampilkan balasannya. Jika belum, tampilkan form input respon --}}
                        @if($u->respon)
                            <div class="mt-2 p-2.5 bg-gray-50 rounded-lg text-xs text-gray-700 border border-[#dde1ea]">
                                <span class="font-bold text-gray-900">Balasan Anda:</span> {{ $u->respon->Respon }}
                            </div>
                        @else
                            <form action="{{ route('respon.store') }}" method="POST" class="mt-3 flex gap-2">
                                @csrf
                                <input type="hidden" name="Id_Respon" value="{{ $u->Id_Ulasan }}">
                                <input type="text" name="Respon" placeholder="Tulis balasan..." class="border border-[#dde1ea] rounded px-2.5 py-1.5 text-xs w-full focus:outline-none focus:border-black" required>
                                <button type="submit" class="bg-black text-white px-3 py-1.5 rounded text-xs font-semibold hover:bg-gray-800 transition">Kirim</button>
                            </form>
                        @endif
                    </td>

                    <!-- Tanggal -->
                    <td class="px-3 py-5 border-t border-[#dde1ea] text-right text-[#6b7385] whitespace-nowrap align-top">
                        {{ $u->created_at?->format('d M Y, H:i') }}
                    </td>

                    <!-- Aksi Hapus Ulasan -->
                    <td class="px-3 py-5 border-t border-[#dde1ea] text-right align-top">
                        <form method="POST" action="{{ route('ulasan.destroy', $u->Id_Ulasan) }}" onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold border border-[#e03a3a] text-[#e03a3a] cursor-pointer hover:bg-red-50 transition">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-[#6b7385]">Belum ada ulasan yang masuk untuk toko Anda.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection