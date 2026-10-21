@extends('layouts.penjual')
@section('title', 'Tindak Lanjut Keluhan')

@section('isi')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-3xl font-bold mb-1">Tindak Lanjut Keluhan</h1>
        <p class="text-sm text-[#6b7385]">Kelola dan atasi keluhan pelanggan dari ulasan rating 1 - 3.</p>
    </div>
    <a href="{{ route('tindaklanjut.create') }}" class="px-5 py-2.5 bg-black text-white rounded-full text-sm font-medium hover:bg-gray-800 transition">
        + Catat Tindak Lanjut
    </a>
</div>

@if(session('success'))
    <div class="p-4 mb-6 text-sm text-green-800 bg-green-100 rounded-2xl border border-green-200">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-7">
    <div class="p-6 border border-[#dde1ea] rounded-[24px] bg-white">
        <p class="text-xs text-[#6b7385] font-semibold uppercase tracking-wider">Status Baru</p>
        <p class="text-3xl font-bold text-[#2878eb] mt-2">{{ $totalBaru }}</p>
    </div>
    <div class="p-6 border border-[#dde1ea] rounded-[24px] bg-white">
        <p class="text-xs text-[#6b7385] font-semibold uppercase tracking-wider">Sedang Diproses</p>
        <p class="text-3xl font-bold text-[#2878eb] mt-2">{{ $totalDiproses }}</p>
    </div>
    <div class="p-6 border border-[#dde1ea] rounded-[24px] bg-white">
        <p class="text-xs text-[#6b7385] font-semibold uppercase tracking-wider">Selesai</p>
        <p class="text-3xl font-bold text-[#2878eb] mt-2">{{ $totalSelesai }}</p>
    </div>
</div>

<div class="border border-[#dde1ea] rounded-[32px] p-6 bg-white">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-[#dde1ea]">
                    <th class="text-left px-3 py-3">Pembeli & Ulasan</th>
                    <th class="text-left px-3 py-3">Catatan Penanganan</th>
                    <th class="text-center px-3 py-3">Status</th>
                    <th class="text-right px-3 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($daftar as $item)
                <tr class="border-b border-gray-100 last:border-0">
                    <td class="px-3 py-4 align-top">
                        <div class="font-semibold text-gray-900">{{ $item->ulasan?->Nama_Pembeli ?? 'Anonim' }}</div>
                        <div class="text-[#f5a623] text-xs my-0.5">{{ str_repeat('★', $item->ulasan?->Rating ?? 0) }}</div>
                        <p class="text-xs text-gray-600 italic">"{{ $item->ulasan?->Ulasan }}"</p>
                    </td>
                    <td class="px-3 py-4 align-top max-w-xs">
                        <p class="text-gray-800 leading-relaxed">{{ $item->Catatan }}</p>
                        <span class="text-[11px] text-gray-400 block mt-1">{{ $item->updated_at?->format('d M Y, H:i') }}</span>
                    </td>
                    <td class="px-3 py-4 align-top text-center">
                        @if($item->Status == 'Baru')
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">Baru</span>
                        @elseif($item->Status == 'Diproses')
                            <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">Diproses</span>
                        @else
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Selesai</span>
                        @endif
                    </td>
                    <td class="px-3 py-4 align-top text-right space-x-2">
                        <a href="{{ route('tindaklanjut.edit', $item->Id_Tindak_Lanjut) }}" class="inline-block text-xs font-medium text-blue-600 hover:underline">Ubah</a>
                        <form action="{{ route('tindaklanjut.destroy', $item->Id_Tindak_Lanjut) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-medium text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="py-8 text-center text-[#6b7385]">Belum ada tindak lanjut keluhan yang dicatat.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection