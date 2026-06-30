<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\Poli;
use App\Models\Periksa;
use App\Models\JadwalPeriksa;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pasien   = Auth::user();
        $pasienId = Auth::id();

        // ── Semua pendaftaran pasien ini ────────────────────────
        $semuaDaftar = DaftarPoli::where('id_pasien', $pasienId)
            ->with(['jadwalPeriksa.dokter.poli', 'periksas.detailPeriksas.obat'])
            ->orderBy('created_at', 'desc')
            ->get();

        // ── Pendaftaran aktif (belum diperiksa) ─────────────────
        $pendaftaranAktif = $semuaDaftar->filter(function ($d) {
            return $d->periksas->isEmpty();
        });

        // ── Riwayat periksa ─────────────────────────────────────
        $riwayatPeriksa = Periksa::whereHas('daftarPoli', function ($q) use ($pasienId) {
            $q->where('id_pasien', $pasienId);
        })->with(['daftarPoli.jadwalPeriksa.dokter.poli', 'detailPeriksas.obat'])
          ->orderBy('tgl_periksa', 'desc')
          ->take(5)
          ->get();

        // ── Stats ────────────────────────────────────────────────
        $totalDaftar    = $semuaDaftar->count();
        $totalDiperiksa = $riwayatPeriksa->count();
        $totalAktif     = $pendaftaranAktif->count();

        // ── Total biaya keseluruhan ─────────────────────────────
        $totalBiaya = $riwayatPeriksa->sum('biaya_periksa');

        // ── Poli tersedia ────────────────────────────────────────
        $polisAktif = Poli::withCount('dokters')->having('dokters_count', '>', 0)->get();

        return view('pasien.dashboard', compact(
            'pasien',
            'pendaftaranAktif',
            'riwayatPeriksa',
            'totalDaftar',
            'totalDiperiksa',
            'totalAktif',
            'totalBiaya',
            'polisAktif',
        ));
    }
}
