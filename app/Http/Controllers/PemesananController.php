<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Models\Transaction;


use Illuminate\Http\Request;

class PemesananController extends Controller
{
    public function index()
    {
        return view('wisatawan.pemesanan');
    }

    public function store(Request $request)
    {
        // Validasi form jika diperlukan
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nomor_handphone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'ktp' => 'required|string|max:255',
            'metode_pembayaran' => 'required|string|max:255',
            // Tambahkan field lain sesuai kebutuhan
        ]);

        // Simpan data pembayaran ke dalam tabel transactions
        Transaction::create([
            'user_id' => auth()->id(), // Sesuaikan dengan cara Anda mendapatkan user ID
            'wisata_id' => Session::get('wisata_id'), // Sesuaikan dengan cara Anda mendapatkan wisata ID
            'tanggal' => Session::get('tanggal_pemesanan'),
            'nama_lengkap' => $request->nama_lengkap,
            'nomor_handphone' => $request->nomor_handphone,
            'email' => $request->email,
            'ktp' => $request->ktp,
            'metode_pembayaran' => $request->metode_pembayaran,
            // Tambahkan field lain sesuai kebutuhan
        ]);

        // Alihkan pengguna ke halaman sukses atau halaman yang sesuai
        return redirect()->route('history')->with('success', 'Pembayaran berhasil.');
    }

    public function prosesPilihTiket(Request $request)
    {
        // Validasi form jika diperlukan
        $request->validate([
            'tanggal' => 'required|date', // Sesuaikan dengan aturan validasi yang Anda inginkan
        ]);

        // Simpan tanggal ke dalam sesi
        Session::put('tanggal_pemesanan', $request->tanggal);
        Session::put('wisata_id', $request->wisata_id);

        return redirect()->route('halamanPemesanan');
    }


    public function halamanPemesanan()
    {
        $tanggalPemesanan = Session::get('tanggal_pemesanan');
        $wisataId = Session::get('wisata_id');

        $wisata = \App\Models\Wisata::find($wisataId);

        return view('wisatawan.pemesanan', [
            'tanggalPemesanan' => $tanggalPemesanan,
            'wisata' => $wisata,
        ]);
    }
}
