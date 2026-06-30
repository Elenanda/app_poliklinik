<x-layouts.app title="Dashboard Pasien">

<style>
    .stat-card { background:#fff; border-radius:16px; border:1px solid #e8ecf0; overflow:hidden; display:flex; flex-direction:column; }
    .stat-card-body { padding:20px 22px 14px; flex:1; }
    .stat-icon { width:42px; height:42px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:16px; margin-bottom:14px; }
    .stat-value { font-size:28px; font-weight:800; color:#1e293b; line-height:1; margin-bottom:4px; }
    .stat-label { font-size:11px; color:#94a3b8; font-weight:600; letter-spacing:.04em; text-transform:uppercase; }
    .stat-footer { padding:8px 22px; font-size:11px; font-weight:700; display:flex; align-items:center; gap:6px; border-top:1px solid #f1f5f9; }
    .section-card { background:#fff; border-radius:16px; border:1px solid #e8ecf0; overflow:hidden; }
    .section-header { padding:16px 22px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; }
    .section-title { display:flex; align-items:center; gap:10px; font-weight:700; font-size:14px; color:#1e293b; }
    .section-icon { width:30px; height:30px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:12px; }
    .badge { display:inline-flex; align-items:center; font-size:10px; font-weight:700; padding:2px 9px; border-radius:20px; }
    .quick-item { display:flex; align-items:center; gap:12px; padding:10px 14px; border-radius:12px; text-decoration:none; transition:background .15s; }
    .quick-item:hover { background:#f8fafc; }
    .quick-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:13px; flex-shrink:0; }
    .daftar-card { border-radius:14px; padding:14px 18px; display:flex; align-items:center; gap:14px; border:1px solid; margin-bottom:0; }
    .antrian-num { width:44px; height:44px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:18px; flex-shrink:0; }
</style>

{{-- ═══ GREETING ═══════════════════════════════════ --}}
<div style="margin-bottom:28px;">
    <h1 style="font-size:22px;font-weight:800;color:#1e293b;margin:0 0 4px;">
        Halo, {{ auth()->user()->nama }} 👋
    </h1>
    <p style="font-size:13px;color:#64748b;margin:0;">
        {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
        &nbsp;·&nbsp; Selamat datang di Poliklinik Kami
    </p>
</div>

{{-- ═══ ROW 1 — STAT CARDS ════════════════════════ --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:20px;">

    {{-- Total Daftar --}}
    <div class="stat-card">
        <div class="stat-card-body">
            <div class="stat-icon" style="background:#eff6ff;">
                <i class="fas fa-clipboard-list" style="color:#3b82f6;"></i>
            </div>
            <div class="stat-value">{{ $totalDaftar }}</div>
            <div class="stat-label">Total Pendaftaran</div>
        </div>
        <div class="stat-footer" style="background:#eff6ff;color:#3b82f6;">
            <i class="fas fa-history" style="font-size:10px;"></i> Sepanjang Waktu
        </div>
    </div>

    {{-- Aktif / Menunggu --}}
    <div class="stat-card">
        <div class="stat-card-body">
            <div class="stat-icon" style="background:{{ $totalAktif > 0 ? '#fffbeb' : '#f8fafc' }};">
                <i class="fas fa-hourglass-half" style="color:{{ $totalAktif > 0 ? '#f59e0b' : '#cbd5e1' }};"></i>
            </div>
            <div class="stat-value" style="color:{{ $totalAktif > 0 ? '#d97706' : '#94a3b8' }};">{{ $totalAktif }}</div>
            <div class="stat-label">Menunggu Periksa</div>
        </div>
        <div class="stat-footer" style="background:{{ $totalAktif > 0 ? '#fffbeb' : '#f8fafc' }};color:{{ $totalAktif > 0 ? '#d97706' : '#94a3b8' }};">
            <i class="fas fa-clock" style="font-size:10px;"></i>
            {{ $totalAktif > 0 ? 'Segera Hadir' : 'Tidak Ada Antrian' }}
        </div>
    </div>

    {{-- Total Diperiksa --}}
    <div class="stat-card">
        <div class="stat-card-body">
            <div class="stat-icon" style="background:#f0fdf4;">
                <i class="fas fa-circle-check" style="color:#22c55e;"></i>
            </div>
            <div class="stat-value" style="color:#16a34a;">{{ $totalDiperiksa }}</div>
            <div class="stat-label">Sudah Diperiksa</div>
        </div>
        <div class="stat-footer" style="background:#f0fdf4;color:#22c55e;">
            <i class="fas fa-stethoscope" style="font-size:10px;"></i> Riwayat Periksa
        </div>
    </div>

    {{-- Total Biaya --}}
    <div class="stat-card">
        <div class="stat-card-body">
            <div class="stat-icon" style="background:#faf5ff;">
                <i class="fas fa-wallet" style="color:#a855f7;"></i>
            </div>
            <div class="stat-value" style="font-size:22px;color:#7c3aed;">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
            <div class="stat-label">Total Biaya</div>
        </div>
        <div class="stat-footer" style="background:#faf5ff;color:#a855f7;">
            <i class="fas fa-receipt" style="font-size:10px;"></i> Akumulasi Biaya Periksa
        </div>
    </div>

</div>

{{-- ═══ ROW 2 — MAIN CONTENT ═══════════════════════ --}}
<div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">

    {{-- KOLOM KIRI --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Pendaftaran Aktif --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon" style="background:#fffbeb;">
                        <i class="fas fa-hourglass-half" style="color:#f59e0b;"></i>
                    </div>
                    Pendaftaran Aktif (Menunggu Periksa)
                    @if($totalAktif > 0)
                    <span class="badge" style="background:#fef3c7;color:#b45309;">{{ $totalAktif }}</span>
                    @endif
                </div>
                <a href="{{ route('pasien.daftar') }}"
                    style="font-size:12px;font-weight:700;background:#f59e0b;color:#fff;padding:6px 14px;border-radius:8px;text-decoration:none;display:flex;align-items:center;gap:6px;"
                    onmouseover="this.style.background='#d97706'" onmouseout="this.style.background='#f59e0b'">
                    <i class="fas fa-plus" style="font-size:10px;"></i> Daftar Poli
                </a>
            </div>

            <div style="padding:16px;display:flex;flex-direction:column;gap:10px;">
                @forelse($pendaftaranAktif as $d)
                @php $jadwal = $d->jadwalPeriksa; $dokter = $jadwal?->dokter; @endphp
                <div class="daftar-card" style="background:#fffbeb;border-color:#fde68a;">
                    <div class="antrian-num" style="background:#fef3c7;color:#b45309;">
                        {{ $d->no_antrian }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:14px;font-weight:700;color:#1e293b;">
                            {{ $dokter?->poli?->nama_poli ?? 'Poli tidak diketahui' }}
                        </div>
                        <div style="font-size:12px;color:#64748b;margin-top:2px;">
                            <i class="fas fa-user-doctor" style="font-size:10px;margin-right:4px;"></i>{{ $dokter?->nama ?? '-' }}
                            &nbsp;·&nbsp;
                            <i class="fas fa-calendar" style="font-size:10px;margin-right:4px;"></i>{{ $jadwal?->hari ?? '-' }}, {{ $jadwal?->jam_mulai ?? '' }} – {{ $jadwal?->jam_selesai ?? '' }}
                        </div>
                        @if($d->keluhan)
                        <div style="font-size:11px;color:#94a3b8;margin-top:3px;font-style:italic;">
                            "{{ Str::limit($d->keluhan, 60, '…') }}"
                        </div>
                        @endif
                    </div>
                    <span class="badge" style="background:#fef3c7;color:#b45309;flex-shrink:0;">
                        <i class="fas fa-clock" style="font-size:9px;margin-right:4px;"></i> Menunggu
                    </span>
                </div>
                @empty
                <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:40px;color:#cbd5e1;">
                    <i class="fas fa-calendar-check" style="font-size:36px;margin-bottom:10px;"></i>
                    <p style="margin:0 0 4px;font-size:13px;color:#94a3b8;">Tidak ada pendaftaran aktif.</p>
                    <p style="margin:0 0 12px;font-size:12px;color:#cbd5e1;">Anda belum mendaftar ke poli manapun.</p>
                    <a href="{{ route('pasien.daftar') }}"
                        style="font-size:12px;font-weight:700;background:#f59e0b;color:#fff;padding:7px 16px;border-radius:8px;text-decoration:none;">
                        + Daftar Sekarang
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Riwayat Periksa --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon" style="background:#f0fdf4;">
                        <i class="fas fa-notes-medical" style="color:#22c55e;"></i>
                    </div>
                    Riwayat Pemeriksaan
                </div>
            </div>

            @if($riwayatPeriksa->count())
            <div style="padding:16px;display:flex;flex-direction:column;gap:10px;">
                @foreach($riwayatPeriksa as $p)
                @php $daftar = $p->daftarPoli; $jadwal = $daftar?->jadwalPeriksa; $dokter = $jadwal?->dokter; @endphp
                <div class="daftar-card" style="background:#f0fdf4;border-color:#bbf7d0;">
                    <div style="width:44px;height:44px;border-radius:12px;background:#dcfce7;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-stethoscope" style="color:#16a34a;font-size:16px;"></i>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:14px;font-weight:700;color:#1e293b;">
                            {{ $dokter?->poli?->nama_poli ?? 'Poli' }}
                        </div>
                        <div style="font-size:12px;color:#64748b;margin-top:2px;">
                            <i class="fas fa-user-doctor" style="font-size:10px;margin-right:4px;"></i>{{ $dokter?->nama ?? '-' }}
                            &nbsp;·&nbsp;
                            <i class="fas fa-calendar" style="font-size:10px;margin-right:4px;"></i>{{ \Carbon\Carbon::parse($p->tgl_periksa)->locale('id')->isoFormat('D MMM YYYY') }}
                        </div>
                        @if($p->detailPeriksas->count())
                        <div style="font-size:11px;color:#94a3b8;margin-top:3px;">
                            💊 {{ $p->detailPeriksas->map(fn($d) => $d->obat->nama_obat ?? '-')->join(', ') }}
                        </div>
                        @endif
                    </div>
                    <div style="text-align:right;flex-shrink:0;">
                        <div style="font-size:13px;font-weight:700;color:#16a34a;">
                            Rp {{ number_format($p->biaya_periksa, 0, ',', '.') }}
                        </div>
                        <span class="badge" style="background:#dcfce7;color:#16a34a;margin-top:4px;">
                            <i class="fas fa-check" style="font-size:9px;margin-right:3px;"></i> Selesai
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div style="display:flex;flex-direction:column;align-items:center;padding:40px;color:#cbd5e1;">
                <i class="fas fa-notes-medical" style="font-size:36px;margin-bottom:10px;"></i>
                <p style="margin:0;font-size:13px;color:#94a3b8;">Belum ada riwayat pemeriksaan.</p>
            </div>
            @endif
        </div>

    </div>

    {{-- KOLOM KANAN --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Akses Cepat --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon" style="background:#f8fafc;">
                        <i class="fas fa-bolt" style="color:#64748b;"></i>
                    </div>
                    Akses Cepat
                </div>
            </div>
            <div style="padding:10px;">
                <a href="{{ route('pasien.daftar') }}" class="quick-item">
                    <div class="quick-icon" style="background:#fffbeb;">
                        <i class="fas fa-clipboard-list" style="color:#f59e0b;"></i>
                    </div>
                    <div>
                        <div style="font-size:13px;font-weight:700;color:#1e293b;">Daftar Poli</div>
                        <div style="font-size:11px;color:#94a3b8;">Daftarkan diri ke poli</div>
                    </div>
                    <i class="fas fa-chevron-right" style="color:#cbd5e1;font-size:11px;margin-left:auto;"></i>
                </a>
            </div>
        </div>

        {{-- Poli Tersedia --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon" style="background:#eff6ff;">
                        <i class="fas fa-hospital" style="color:#3b82f6;"></i>
                    </div>
                    Poli Tersedia
                    <span class="badge" style="background:#eff6ff;color:#3b82f6;">{{ $polisAktif->count() }}</span>
                </div>
            </div>
            <div style="padding:12px;display:flex;flex-direction:column;gap:6px;">
                @forelse($polisAktif as $poli)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 14px;border-radius:12px;background:#f8fafc;border:1px solid #f1f5f9;"
                    onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='#f8fafc'">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:32px;height:32px;border-radius:9px;background:#eff6ff;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-hospital" style="color:#3b82f6;font-size:12px;"></i>
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:700;color:#1e293b;">{{ $poli->nama_poli }}</div>
                            <div style="font-size:11px;color:#94a3b8;">{{ $poli->dokters_count }} dokter</div>
                        </div>
                    </div>
                    <a href="{{ route('pasien.daftar') }}"
                        style="font-size:10px;font-weight:700;background:#eff6ff;color:#2563eb;padding:4px 10px;border-radius:8px;text-decoration:none;">
                        Daftar
                    </a>
                </div>
                @empty
                <div style="text-align:center;padding:32px;color:#cbd5e1;">
                    <i class="fas fa-hospital" style="font-size:28px;margin-bottom:8px;display:block;"></i>
                    <p style="margin:0;font-size:12px;">Belum ada poli tersedia</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

</x-layouts.app>