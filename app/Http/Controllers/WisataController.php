<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisata;
use App\Models\WisataImage;
use App\Models\Transaction;
use Yajra\DataTables\DataTables;
use Auth;


class WisataController extends Controller
{
    public function store(Request $request)
    {
        $jadwal = implode(',', $request->input('jadwal', []));

        // Handle first image for backward compatibility
        $imagePath = null;
        if ($request->hasFile('images')) {
            $firstImage = $request->file('images')[0];
            $filename = time() . '.' . $firstImage->getClientOriginalExtension();
            $firstImage->storeAs('public/images', $filename);
            $imagePath = 'images/' . $filename;
        }

        $wisata = Wisata::create([
            'user_id' => auth()->id(),
            'nama' => $request->nama,
            'noHp' => $request->noHp,
            'alamatEmail' => $request->alamatEmail,
            'alamatLengkap' => $request->alamatLengkap,
            'detail' => $request->detail,
            'provinsi'  => $request->provinsi,
            'kecamatan'  => $request->kecamatan,
            'harga'  => $request->harga,
            'jumlahTiket' => $request->jumlahTiket,
            'jadwal' => $jadwal,
            'informasi'  => $request->informasi,
            'syarat'  => $request->syarat,
            'image'  => $imagePath,
        ]);

        // Save all images to wisata_images table
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $img) {
                $fname = time() . '_' . $index . '.' . $img->getClientOriginalExtension();
                $img->storeAs('public/images', $fname);
                WisataImage::create([
                    'wisata_id' => $wisata->id,
                    'image_path' => 'images/' . $fname,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('mitra')->with('success', 'Wisata berhasil ditambahkan.');
    }



    public function index(){
        return view('mitra.regist');
    }
    public function kelola(){
        return view('mitra.kelola');
    }
    
    public function mitra(){
        $user_id = auth()->id();

        // Mengambil maksimal 3 wisata untuk user yang sedang login
        $wisatas = Wisata::with('images')->where('user_id', $user_id)->take(3)->get();
        return view('mitra.dashboard', compact('wisatas'));
    }

    public function informasi($id){
        $wisata = Wisata::with('images')->findOrFail($id);
        return view('wisatawan.informasi', ['wisatas' => collect([$wisata])]);
    }
    public function getWisata(){
        $data = Wisata::all();
        return Datatables::of($data)->make(true);
    }
    public function asal(){
        $data = Wisata::all();
        return Datatables::of($data)->make(true);
    }

    public function search(Request $request)
{
    $keyword = $request->input('search');

    $wisatas = Wisata::where('nama', 'LIKE', '%' . $keyword . '%')
        ->orWhere('alamatLengkap', 'LIKE', '%' . $keyword . '%')
        ->orWhere('provinsi', 'LIKE', '%' . $keyword . '%')
        ->get();

    if ($wisatas->isEmpty()) {
        return redirect()->back()->with('error', 'Tidak ada hasil ditemukan untuk kata kunci "' . $keyword . '"');
    }

    return view('wisatawan.informasi', compact('wisatas'));
}


    // public function show(Wisata $Wisata) //tampilan view buat ngedit
    // {
    //     return view('mitra.editWisata', compact('wisata'));
    // }


    public function edit($id)
{
    $wisata = Wisata::with('images')->findOrFail($id);
    return view('mitra.editWisata', compact('wisata'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required',
        'harga' => 'required|numeric',
    ]);

    $wisata = Wisata::findOrFail($id);

    $wisata->update([
        'nama' => $request->input('nama'),
        'harga' => $request->input('harga'),
    ]);

    // Delete selected images
    if ($request->has('delete_images')) {
        WisataImage::whereIn('id', $request->delete_images)->where('wisata_id', $id)->delete();
    }

    // Add new images
    if ($request->hasFile('images')) {
        $currentCount = $wisata->images()->count();
        foreach ($request->file('images') as $index => $img) {
            if ($currentCount + $index >= 10) break; // Max 10
            $fname = time() . '_' . $index . '.' . $img->getClientOriginalExtension();
            $img->storeAs('public/images', $fname);
            WisataImage::create([
                'wisata_id' => $wisata->id,
                'image_path' => 'images/' . $fname,
                'sort_order' => $currentCount + $index,
            ]);
        }
        // Update main image field with first image
        $firstImage = $wisata->images()->first();
        if ($firstImage) {
            $wisata->update(['image' => $firstImage->image_path]);
        }
    }

    return redirect()->route('mitra')->with('success', 'Data wisata berhasil diperbarui.');
}

public function delete($id)
{
    $wisata = Wisata::findOrFail($id);
    $wisata->delete();

    return redirect()->route('mitra')->with('success', 'Wisata berhasil dihapus.');
}


// public function historyTransactions()
// {
//     // Mendapatkan user yang sedang login
//     $user = Auth::user();


//     // Mendapatkan transaksi berdasarkan user ID
//     $transactions = Transaction::where('user_id', $user->id)->get();

//     return view('wisatawan.history_transactions', compact('transactions'));
// }

public function historyTransactions()
{
    // Mendapatkan user yang sedang login
    $user = Auth::user();

    // Mendapatkan transaksi berdasarkan user ID dengan informasi wisata terkait
    $transactions = Transaction::with('wisata')
        ->where('user_id', $user->id)
        ->get();

    return view('wisatawan.history_transactions', compact('transactions'));
}







}
