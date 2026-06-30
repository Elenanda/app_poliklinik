<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Periksa;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();
        $dokter   = Auth::user();

        // ── Jadwal milik dokter ini ─────────────────────────────
        $jadwals = JadwalPeriksa::where('id_dokter', $dokterId)
            ->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->get();

        $totalJadwal = $jadwals->count();

        // ── Antrian pasien hari ini (berdasarkan hari) ──────────
        $hariIni = now()->locale('id')->isoFormat('dddd'); // 'Senin','Selasa', dst.
        $jadwalHariIni = JadwalPeriksa::where('id_dokter', $dokterId)
            ->where('hari', $hariIni)
            ->first();

        $antrianHariIni = 0;
        $sudahDiperiksa = 0;
        $menunggu       = 0;

        if ($jadwalHariIni) {
            $antrianHariIni = DaftarPoli::where('id_jadwal', $jadwalHariIni->id)->count();
            $sudahDiperiksa = DaftarPoli::where('id_jadwal', $jadwalHariIni->id)
                ->whereHas('periksas')
                ->count();
            $menunggu = $antrianHariIni - $sudahDiperiksa;
        }

        // ── Total pasien yang pernah diperiksa ──────────────────
        $totalPasienDiperiksa = Periksa::whereHas('daftarPoli.jadwalPeriksa', function ($q) use ($dokterId) {
            $q->where('id_dokter', $dokterId);
        })->count();

        // ── Pasien antrian hari ini ─────────────────────────────
        $daftarPasienHariIni = collect();
        if ($jadwalHariIni) {
            $daftarPasienHariIni = DaftarPoli::where('id_jadwal', $jadwalHariIni->id)
                ->with(['pasien', 'periksas'])
                ->orderBy('no_antrian')
                ->get();
        }

        // ── Riwayat 5 periksa terakhir ──────────────────────────
        $riwayatTerbaru = Periksa::whereHas('daftarPoli.jadwalPeriksa', function ($q) use ($dokterId) {
            $q->where('id_dokter', $dokterId);
        })->with(['daftarPoli.pasien', 'detailPeriksas.obat'])
          ->orderBy('tgl_periksa', 'desc')
          ->take(5)
          ->get();

        return view('dokter.dashboard', compact(
            'dokter',
            'jadwals',
            'totalJadwal',
            'hariIni',
            'jadwalHariIni',
            'antrianHariIni',
            'sudahDiperiksa',
            'menunggu',
            'totalPasienDiperiksa',
            'daftarPasienHariIni',
            'riwayatTerbaru',
        ));
    }
}
