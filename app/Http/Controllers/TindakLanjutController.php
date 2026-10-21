<?php

namespace App\Http\Controllers;

use App\Models\tindaklanjut;
use App\Models\ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TindakLanjutController extends Controller
{
    public function index()
    {
        $penjualId = Auth::id();

        $daftar = tindaklanjut::whereHas('ulasan', function ($q) use ($penjualId) {
            $q->where('Id_Penjual', $penjualId);
        })->with('ulasan')->latest()->get();

        $totalBaru = $daftar->where('Status', 'Baru')->count();
        $totalDiproses = $daftar->where('Status', 'Diproses')->count();
        $totalSelesai = $daftar->where('Status', 'Selesai')->count();

        return view('tindaklanjut.index', compact('daftar', 'totalBaru', 'totalDiproses', 'totalSelesai'));
    }

    public function create()
    {
        $penjualId = Auth::id();

        $keluhan = ulasan::where('Id_Penjual', $penjualId)
            ->where('Rating', '<=', 3)
            ->whereDoesntHave('tindakLanjut')
            ->get();

        return view('tindaklanjut.form', [
            'data' => null,
            'keluhan' => $keluhan
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'Id_Ulasan' => 'required|exists:ulasan,Id_Ulasan|unique:tindak_lanjut,Id_Ulasan',
            'Catatan'   => 'required|string|min:5',
            'Status'    => 'required|in:Baru,Diproses,Selesai',
        ], [
            'Id_Ulasan.required' => 'Pilih ulasan keluhan terlebih dahulu.',
            'Id_Ulasan.unique'   => 'Ulasan ini sudah dibuatkan tindak lanjut.',
            'Catatan.required'   => 'Catatan tindak lanjut wajib diisi.',
            'Catatan.min'        => 'Catatan minimal terdiri dari 5 karakter.',
            'Status.required'    => 'Pilih status tindak lanjut.',
        ]);

        $ulasan = ulasan::where('Id_Penjual', Auth::id())->findOrFail($request->Id_Ulasan);

        tindaklanjut::create([
            'Id_Ulasan' => $ulasan->Id_Ulasan,
            'Catatan'   => $request->Catatan,
            'Status'    => $request->Status,
        ]);

        return redirect()->route('tindaklanjut.index')->with('success', 'Tindak lanjut berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $penjualId = Auth::id();

        $data = tindaklanjut::whereHas('ulasan', function ($q) use ($penjualId) {
            $q->where('Id_Penjual', $penjualId);
        })->with('ulasan')->findOrFail($id);

        return view('tindaklanjut.form', [
            'data' => $data,
            'keluhan' => collect([$data->ulasan]) 
        ]);
    }

    public function update(Request $request, $id)
    {
        $penjualId = Auth::id();

        $data = tindaklanjut::whereHas('ulasan', function ($q) use ($penjualId) {
            $q->where('Id_Penjual', $penjualId);
        })->findOrFail($id);

        $request->validate([
            'Catatan' => 'required|string|min:5',
            'Status'  => 'required|in:Baru,Diproses,Selesai',
        ], [
            'Catatan.required' => 'Catatan wajib diisi.',
            'Catatan.min'      => 'Catatan minimal 5 karakter.',
            'Status.required'  => 'Status wajib dipilih.',
        ]);

        $data->update([
            'Catatan' => $request->Catatan,
            'Status'  => $request->Status,
        ]);

        return redirect()->route('tindaklanjut.index')->with('success', 'Tindak lanjut berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $penjualId = Auth::id();

        $data = tindaklanjut::whereHas('ulasan', function ($q) use ($penjualId) {
            $q->where('Id_Penjual', $penjualId);
        })->findOrFail($id);

        $data->delete();

        return redirect()->route('tindaklanjut.index')->with('success', 'Tindak lanjut berhasil dihapus!');
    }
}