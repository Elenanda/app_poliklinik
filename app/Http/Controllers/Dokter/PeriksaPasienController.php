<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $daftarPasien = DaftarPoli::with(['pasien', 'jadwalPeriksa', 'periksas'])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->orderBy('no_antrian')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPasien'));
    }

    public function create($id)
    {
        // Ambil semua obat beserta stok untuk ditampilkan di form
        $obats = Obat::orderBy('nama_obat')->get();
        return view('dokter.periksa-pasien.create', compact('obats', 'id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_daftar_poli' => 'required|exists:daftar_poli,id',
            'catatan'        => 'nullable|string',
            'biaya_periksa'  => 'required|integer|min:0',
            'obat_json'      => 'nullable|string',
        ]);

        // Decode daftar obat yang dipilih dokter
        $obatIds = [];
        if ($request->filled('obat_json')) {
            $obatIds = json_decode($request->obat_json, true) ?? [];
        }

        
        // VALIDASI STOK: Cek ketersediaan SEBELUM menyimpan data
      
        $stokKurang = [];
        foreach ($obatIds as $idObat) {
            $obat = Obat::find($idObat);
            if (!$obat) continue;

            if ($obat->stok <= 0) {
                $stokKurang[] = "{$obat->nama_obat} (stok habis)";
            }
        }

        if (!empty($stokKurang)) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan resep! Stok obat berikut tidak tersedia: ' . implode(', ', $stokKurang));
        }

      
        // SIMPAN DATA dengan DB Transaction agar konsisten
     
        try {
            DB::beginTransaction();

            // 1. Simpan data pemeriksaan
            $periksa = Periksa::create([
                'id_daftar_poli' => $request->id_daftar_poli,
                'tgl_periksa'    => now(),
                'catatan'        => $request->catatan,
                'biaya_periksa'  => $request->biaya_periksa + 150000,
            ]);

            // 2. Simpan detail obat & kurangi stok otomatis
            foreach ($obatIds as $idObat) {
                $obat = Obat::findOrFail($idObat);

                // Double-check stok sebelum kurangi (concurrency safety)
                if ($obat->stok <= 0) {
                    throw new \Exception("Stok obat {$obat->nama_obat} telah habis saat proses penyimpanan.");
                }

                // Simpan ke detail_periksa
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat'    => $idObat,
                ]);

                // Kurangi stok otomatis
                $obat->decrement('stok', 1);
            }

            DB::commit();

            return redirect()->route('periksa-pasien.index')
                ->with('success', 'Pemeriksaan berhasil disimpan dan stok obat telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}