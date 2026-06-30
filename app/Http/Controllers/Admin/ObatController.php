<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::orderBy('nama_obat')->get();
        return view('admin.obat.index', compact('obats'));
    }

    public function create()
    {
        return view('admin.obat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan'   => 'nullable|string|max:50',
            'harga'     => 'required|integer|min:0',
            'stok'      => 'required|integer|min:0',
        ]);

        Obat::create([
            'nama_obat' => $request->nama_obat,
            'kemasan'   => $request->kemasan,
            'harga'     => $request->harga,
            'stok'      => $request->stok,
        ]);

        return redirect()->route('obat.index')
            ->with('success', 'Data obat berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $obat = Obat::findOrFail($id);
        return view('admin.obat.edit', compact('obat'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan'   => 'nullable|string|max:50',
            'harga'     => 'required|integer|min:0',
            'stok'      => 'required|integer|min:0',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'kemasan'   => $request->kemasan,
            'harga'     => $request->harga,
            'stok'      => $request->stok,
        ]);

        return redirect()->route('obat.index')
            ->with('success', 'Data obat berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('obat.index')
            ->with('success', 'Data obat berhasil dihapus.');
    }

    /**
     * Tambah stok obat secara manual oleh Admin.
     */
    public function tambahStok(Request $request, string $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ], [
            'jumlah.required' => 'Jumlah penambahan stok wajib diisi.',
            'jumlah.integer'  => 'Jumlah harus berupa angka bulat.',
            'jumlah.min'      => 'Jumlah penambahan minimal 1.',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->increment('stok', $request->jumlah);

        return redirect()->route('obat.index')
            ->with('success', "Stok {$obat->nama_obat} berhasil ditambah {$request->jumlah} unit. Total stok: {$obat->fresh()->stok}.");
    }

    /**
     * Kurangi stok obat secara manual oleh Admin.
     */
    public function kurangStok(Request $request, string $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ], [
            'jumlah.required' => 'Jumlah pengurangan stok wajib diisi.',
            'jumlah.integer'  => 'Jumlah harus berupa angka bulat.',
            'jumlah.min'      => 'Jumlah pengurangan minimal 1.',
        ]);

        $obat = Obat::findOrFail($id);

        if ($request->jumlah > $obat->stok) {
            return redirect()->route('obat.index')
                ->with('error', "Gagal mengurangi stok! Stok {$obat->nama_obat} hanya tersisa {$obat->stok} unit.");
        }

        $obat->decrement('stok', $request->jumlah);

        return redirect()->route('obat.index')
            ->with('success', "Stok {$obat->nama_obat} berhasil dikurangi {$request->jumlah} unit. Sisa stok: {$obat->fresh()->stok}.");
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ObatExport, 'data_obat.xlsx');
    }
}