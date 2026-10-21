@extends('layouts.penjual')
@section('title', 'Profil Toko')

@section('isi')
<h1 class="text-3xl font-bold mb-1.5">Profil Toko</h1>
<p class="text-sm text-[#6b7385] mb-7">Informasi toko yang tampil pada halaman publik.</p>

<div class="border border-[#dde1ea] rounded-[40px] p-7 bg-white">
    <div class="bg-[linear-gradient(180deg,#82b4ff,#cfc4ff)] rounded-[26px] p-6 flex items-center gap-6 mb-8">
        <!-- <div class="font-bold text-[#2878eb] min-w-[100px] text-center">FOTO TOKO</div> -->
        <div>
            <h2 class="text-[22px] font-bold mb-1">{{ $penjual->Nama_Penjual ?? 'Toko belum diisi' }}</h2>
            <p class="text-sm text-[#6b7385]">{{ $penjual->Alamat_Penjual ?? '-' }}</p>
        </div>
    </div>

    <h2 class="text-[22px] font-bold mb-4">Form Profil / Edit Data Toko</h2>

    @if($errors->any())
        <div class="px-4 py-3 rounded-[10px] mb-4 text-sm bg-[#fdeaea] text-[#e03a3a]">
            <ul class="list-disc ml-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('penjual.store') }}">
        @csrf
        @foreach([
            ['Nama_Penjual', 'Nama Toko/Penjual', true],
            ['Alamat_Penjual', 'Alamat', true],
            ['No_Telp_Penjual', 'No. Telepon', true],
        ] as [$name, $label, $req])
            <div class="flex flex-col md:flex-row md:items-start gap-2 md:gap-5 mb-6">
                <label for="{{ $name }}" class="md:w-[140px] text-[13px] font-bold md:pt-4">{{ $label }}</label>
                <input type="text" id="{{ $name }}" name="{{ $name }}"
                       value="{{ old($name, $penjual->$name ?? '') }}" {{ $req ? 'required' : '' }}
                       class="w-full max-w-[550px] px-3.5 py-3.5 border border-[#dde1ea] rounded-xl text-sm outline-none focus:border-[#2878eb]">
            </div>
        @endforeach

        <div class="flex flex-col md:flex-row md:items-start gap-2 md:gap-5 mb-6">
            <label for="Deskripsi" class="md:w-[140px] text-[13px] font-bold md:pt-4">Deskripsi Toko</label>
            <textarea id="Deskripsi" name="Deskripsi" rows="3"
                      class="w-full max-w-[550px] min-h-[110px] px-3.5 py-3.5 border border-[#dde1ea] rounded-xl text-sm outline-none focus:border-[#2878eb] resize-y">{{ old('Deskripsi', $penjual->Deskripsi ?? '') }}</textarea>
        </div>

        <div class="max-w-[880px] text-right">
            <a href="{{ route('homePenjual') }}" class="mr-4 text-sm text-[#6b7385]">Batal</a>
            <button type="submit" class="inline-block px-6 py-2.5 rounded-lg font-bold bg-[#2878eb] text-white cursor-pointer">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection