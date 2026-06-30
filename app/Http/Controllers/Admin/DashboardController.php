<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\Obat;
use App\Models\Periksa;
use App\Models\Poli;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // ─── Statistik Utama ───────────────────────────────────────
        $totalPoli    = Poli::count();
        $totalDokter  = User::where('role', 'dokter')->count();
        $totalPasien  = User::where('role', 'pasien')->count();
        $totalObat    = Obat::count();

        // ─── Statistik Stok ────────────────────────────────────────
        $stokHabis    = Obat::where('stok', '<=', 0)->count();
        $stokMenipis  = Obat::where('stok', '>', 0)->where('stok', '<', 10)->count();

        // ─── Daftar Obat Kritis (habis + menipis) ──────────────────
        $obatKritis = Obat::where('stok', '<', 10)
            ->orderBy('stok')
            ->take(5)
            ->get();

        // ─── Data Poli beserta jumlah dokter ───────────────────────
        $polis = Poli::withCount('dokters')->get();

        // ─── Pasien terdaftar hari ini ─────────────────────────────
        $pendaftaranHariIni = DaftarPoli::whereDate('created_at', today())->count();

        // ─── Daftar dokter + poli ──────────────────────────────────
        $dokters = User::where('role', 'dokter')
            ->with('poli')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPoli',
            'totalDokter',
            'totalPasien',
            'totalObat',
            'stokHabis',
            'stokMenipis',
            'obatKritis',
            'polis',
            'pendaftaranHariIni',
            'dokters',
        ));
    }
}
