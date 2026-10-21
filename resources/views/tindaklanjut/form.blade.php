@extends('layouts.penjual')
@section('title', $data ? 'Ubah Tindak Lanjut' : 'Tambah Tindak Lanjut')

@section('isi')
<div class="max-w-2xl">
    <h1 class="text-3xl font-bold mb-1">{{ $data ? 'Ubah Tindak Lanjut' : 'Tambah Tindak Lanjut' }}</h1>
    <p class="text-sm text-[#6b7385] mb-6">Catat penanganan keluhan dari pembeli untuk evaluasi toko.</p>

    <div class="border border-[#dde1ea] rounded-[32px] p-7 bg-white">
        <form action="{{ $data ? route('tindaklanjut.update', $data->Id_Tindak_Lanjut) : route('tindaklanjut.store') }}" method="POST">
            @csrf
            @if($data)
                @method('PUT')
            @endif

            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">Pilih Ulasan Keluhan</label>
                @if($data)
                    <input type="hidden" name="Id_Ulasan" value="{{ $data->Id_Ulasan }}">
                    <div class="p-4 bg-gray-50 rounded-2xl border border-gray-200 text-sm">
                        <p class="font-semibold">{{ $data->ulasan?->Nama_Pembeli }} (Rating: {{ $data->ulasan?->Rating }}★)</p>
                        <p class="text-gray-600 text-xs italic mt-1">"{{ $data->ulasan?->Ulasan }}"</p>
                    </div>
                @else
                    <select name="Id_Ulasan" class="w-full px-4 py-3 border rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-black @error('Id_Ulasan') border-red-500 @enderror">
                        <option value="">-- Pilih Ulasan Keluhan (Rating 1 - 3) --</option>
                        @foreach($keluhan as $k)
                            <option value="{{ $k->Id_Ulasan }}" {{ old('Id_Ulasan') == $k->Id_Ulasan ? 'selected' : '' }}>
                                [★{{ $k->Rating }}] {{ $k->Nama_Pembeli }}: "{{ Str::limit($k->Ulasan, 40) }}"
                            </option>
                        @endforeach
                    </select>
                    @error('Id_Ulasan')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                @endif
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">Catatan Penanganan</label>
                <textarea name="Catatan" rows="4" placeholder="Tuliskan tindakan yang dilakukan (misal: Menghubungi pembeli untuk refund/penggantian produk)..." class="w-full px-4 py-3 border rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-black @error('Catatan') border-red-500 @enderror">{{ old('Catatan', $data?->Catatan) }}</textarea>
                @error('Catatan')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold mb-2">Status Penanganan</label>
                <select name="Status" class="w-full px-4 py-3 border rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-black @error('Status') border-red-500 @enderror">
                    <option value="Baru" {{ old('Status', $data?->Status) == 'Baru' ? 'selected' : '' }}>Baru</option>
                    <option value="Diproses" {{ old('Status', $data?->Status) == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ old('Status', $data?->Status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                @error('Status')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">Request tambah</label>
                <input type="text" 
                    name="request_tambah" 
                    value="{{ old('request_tambah', $data?->request_tambah) }}" 
                    placeholder="Masukkan request tambah..." 
                    class="w-full px-4 py-3 border rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-black @error('request_tambah') border-red-500 @enderror">
                @error('request_tambah')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center space-x-3">
                <button type="submit" class="px-6 py-3 bg-black text-white text-sm font-medium rounded-full hover:bg-gray-800 transition">
                    Simpan
                </button>
                <a href="{{ route('tindaklanjut.index') }}" class="px-6 py-3 border border-gray-300 text-sm font-medium rounded-full hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection