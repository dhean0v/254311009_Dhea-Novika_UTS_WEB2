<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\penjual;
use App\Models\ulasan;

class penjualController extends Controller
{
        public function store(Request $request) {
        // Validasi input
        $request->validate([
            'Nama_Penjual' => 'required|string|max:255',
            'Deskripsi' => 'nullable|string',
            'Alamat_Penjual' => 'required|string|max:255',
            'No_Telp_Penjual' => 'required|string|max:15',
        ]);

        // Simpan data penjual ke database
        Penjual::updateOrCreate(
            ['Id_Penjual' => Auth::id()], // Gunakan Id_Penjual dari pengguna yang sedang login
            [
                'Nama_Penjual' => $request->Nama_Penjual,
                'Deskripsi' => $request->Deskripsi,
                'Alamat_Penjual' => $request->Alamat_Penjual,
                'No_Telp_Penjual' => $request->No_Telp_Penjual,
            ]
        );

        // Redirect ke halaman home setelah berhasil menyimpan penjual
        return redirect()->route('homePenjual')->with('success', 'Toko berhasil disimpan!');
        }

        public function hapusUlasan($id) {
        $data = ulasan::findOrFail($id);

        // Pastikan ulasan ini milik toko yang sedang login
        if ($data->Id_Penjual != Auth::id()) {
            abort(403);
        }

        $data->delete();

        return redirect()->route('penjual.ulasan')->with('success', 'Ulasan berhasil dihapus!');
        }
}
