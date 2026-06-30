<x-layouts.app title="Dashboard Dokter">

<style>
    .stat-card { background:#fff; border-radius:16px; border:1px solid #e8ecf0; overflow:hidden; display:flex; flex-direction:column; }
    .stat-card-body { padding:20px 22px 14px; flex:1; }
    .stat-icon { width:42px; height:42px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:16px; margin-bottom:14px; }
    .stat-value { font-size:30px; font-weight:800; color:#1e293b; line-height:1; margin-bottom:4px; }
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
    .dash-table { width:100%; border-collapse:collapse; }
    .dash-table th { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#94a3b8; padding:10px 20px; background:#f8fafc; border-bottom:1px solid #f1f5f9; }
    .dash-table td { padding:13px 20px; font-size:13px; color:#334155; border-bottom:1px solid #f8fafc; }
    .dash-table tbody tr:last-child td { border-bottom:none; }
    .dash-table tbody tr:hover td { background:#f8fafc; }
    .jadwal-chip { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; border-radius:20px; font-size:11px; font-weight:700; }
</style>

{{-- ═══ GREETING ═══════════════════════════════════ --}}
<div style="margin-bottom:28px;">
    <h1 style="font-size:22px;font-weight:800;color:#1e293b;margin:0 0 4px;">
        Selamat Datang, dr. {{ auth()->user()->nama }} 👨‍⚕️
    </h1>
    <p style="font-size:13px;color:#64748b;margin:0;">
        {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
        &nbsp;·&nbsp;
        @if($jadwalHariIni)
            <span style="color:#22c55e;font-weight:600;"><i class="fas fa-circle" style="font-size:8px;"></i> Jadwal Praktik Hari Ini Tersedia</span>
        @else
            <span style="color:#94a3b8;"><i class="fas fa-moon" style="font-size:10px;"></i> Tidak Ada Jadwal Praktik Hari Ini</span>
        @endif
    </p>
</div>

{{-- ═══ ROW 1 — STAT CARDS ════════════════════════ --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:20px;">

    {{-- Total Jadwal --}}
    <div class="stat-card">
        <div class="stat-card-body">
            <div class="stat-icon" style="background:#eff6ff;">
                <i class="fas fa-calendar-days" style="color:#3b82f6;"></i>
            </div>
            <div class="stat-value">{{ $totalJadwal }}</div>
            <div class="stat-label">Total Jadwal</div>
        </div>
        <div class="stat-footer" style="background:#eff6ff;color:#3b82f6;">
            <i class="fas fa-calendar-week" style="font-size:10px;"></i> Jadwal Per Minggu
        </div>
    </div>

    {{-- Antrian Hari Ini --}}
    <div class="stat-card">
        <div class="stat-card-body">
            <div class="stat-icon" style="background:#f0fdf4;">
                <i class="fas fa-users" style="color:#22c55e;"></i>
            </div>
            <div class="stat-value">{{ $antrianHariIni }}</div>
            <div class="stat-label">Antrian Hari Ini</div>
        </div>
        <div class="stat-footer" style="background:#f0fdf4;color:#22c55e;">
            <i class="fas fa-clock" style="font-size:10px;"></i>
            @if($jadwalHariIni) {{ $jadwalHariIni->jam_mulai }} – {{ $jadwalHariIni->jam_selesai }} @else Tidak ada jadwal @endif
        </div>
    </div>

    {{-- Sudah Diperiksa --}}
    <div class="stat-card">
        <div class="stat-card-body">
            <div class="stat-icon" style="background:#f0fdf4;">
                <i class="fas fa-circle-check" style="color:#16a34a;"></i>
            </div>
            <div class="stat-value" style="color:#16a34a;">{{ $sudahDiperiksa }}</div>
            <div class="stat-label">Sudah Diperiksa</div>
        </div>
        <div class="stat-footer" style="background:#f0fdf4;color:#16a34a;">
            <i class="fas fa-check" style="font-size:10px;"></i> Selesai Hari Ini
        </div>
    </div>

    {{-- Menunggu --}}
    <div class="stat-card">
        <div class="stat-card-body">
            <div class="stat-icon" style="background:{{ $menunggu > 0 ? '#fffbeb' : '#f8fafc' }};">
                <i class="fas fa-hourglass-half" style="color:{{ $menunggu > 0 ? '#f59e0b' : '#cbd5e1' }};"></i>
            </div>
            <div class="stat-value" style="color:{{ $menunggu > 0 ? '#d97706' : '#94a3b8' }};">{{ $menunggu }}</div>
            <div class="stat-label">Menunggu</div>
        </div>
        <div class="stat-footer" style="background:{{ $menunggu > 0 ? '#fffbeb' : '#f8fafc' }};color:{{ $menunggu > 0 ? '#d97706' : '#94a3b8' }};">
            <i class="fas fa-person-walking-arrow-right" style="font-size:10px;"></i> Antrian Menunggu
        </div>
    </div>

</div>

{{-- ═══ ROW 2 — MAIN CONTENT ═══════════════════════ --}}
<div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">

    {{-- KOLOM KIRI --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Antrian Pasien Hari Ini --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon" style="background:#f0fdf4;">
                        <i class="fas fa-users" style="color:#22c55e;"></i>
                    </div>
                    Antrian Pasien Hari Ini
                    <span class="badge" style="background:#f0fdf4;color:#16a34a;">{{ $antrianHariIni }} pasien</span>
                </div>
                @if($antrianHariIni > 0)
                <a href="{{ route('periksa-pasien.index') }}"
                    style="font-size:12px;font-weight:700;background:#22c55e;color:#fff;padding:6px 14px;border-radius:8px;text-decoration:none;display:flex;align-items:center;gap:6px;"
                    onmouseover="this.style.background='#16a34a'" onmouseout="this.style.background='#22c55e'">
                    <i class="fas fa-stethoscope" style="font-size:10px;"></i> Mulai Periksa
                </a>
                @endif
            </div>

            @if($daftarPasienHariIni->count())
            <table class="dash-table">
                <thead>
                    <tr>
                        <th style="text-align:center;width:60px;">Antrian</th>
                        <th style="text-align:left;">Nama Pasien</th>
                        <th style="text-align:left;">Keluhan</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daftarPasienHariIni as $daftar)
                    @php $sudah = $daftar->periksas->isNotEmpty(); @endphp
                    <tr>
                        <td style="text-align:center;">
                            <span style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:50%;background:{{ $sudah ? '#f0fdf4' : '#eff6ff' }};font-weight:800;font-size:13px;color:{{ $sudah ? '#16a34a' : '#3b82f6' }};">
                                {{ $daftar->no_antrian }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight:700;color:#1e293b;">{{ $daftar->pasien->nama ?? '-' }}</div>
                            <div style="font-size:11px;color:#94a3b8;">{{ $daftar->pasien->email ?? '' }}</div>
                        </td>
                        <td style="color:#64748b;font-size:12px;">
                            {{ Str::limit($daftar->keluhan ?? 'Tidak ada keluhan', 40, '…') }}
                        </td>
                        <td style="text-align:center;">
                            @if($sudah)
                                <span class="badge" style="background:#dcfce7;color:#16a34a;">
                                    <i class="fas fa-check" style="font-size:9px;margin-right:3px;"></i> Selesai
                                </span>
                            @else
                                <span class="badge" style="background:#fffbeb;color:#d97706;">
                                    <i class="fas fa-hourglass-half" style="font-size:9px;margin-right:3px;"></i> Menunggu
                                </span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            @if(!$sudah)
                            <a href="{{ route('periksa-pasien.create', $daftar->id) }}"
                                style="display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:700;background:#eff6ff;color:#2563eb;padding:5px 12px;border-radius:8px;text-decoration:none;"
                                onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#eff6ff'">
                                <i class="fas fa-stethoscope" style="font-size:9px;"></i> Periksa
                            </a>
                            @else
                            <span style="font-size:11px;color:#94a3b8;">— Selesai —</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @elseif($jadwalHariIni)
            <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px;color:#cbd5e1;">
                <i class="fas fa-user-clock" style="font-size:36px;margin-bottom:10px;"></i>
                <p style="margin:0;font-size:13px;color:#94a3b8;">Belum ada pasien yang mendaftar hari ini.</p>
            </div>
            @else
            <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px;color:#cbd5e1;">
                <i class="fas fa-calendar-xmark" style="font-size:36px;margin-bottom:10px;"></i>
                <p style="margin:0;font-size:13px;color:#94a3b8;">Tidak ada jadwal praktik hari ini ({{ $hariIni }}).</p>
                <a href="{{ route('jadwal-periksa.create') }}" style="margin-top:12px;font-size:12px;font-weight:700;color:#3b82f6;text-decoration:none;">+ Tambah Jadwal</a>
            </div>
            @endif
        </div>

        {{-- Riwayat Periksa Terakhir --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon" style="background:#f8fafc;">
                        <i class="fas fa-clock-rotate-left" style="color:#64748b;"></i>
                    </div>
                    Riwayat Pemeriksaan Terbaru
                </div>
                <a href="{{ route('riwayat-pasien.index') }}" style="font-size:12px;font-weight:700;color:#64748b;text-decoration:none;">Semua →</a>
            </div>

            @if($riwayatTerbaru->count())
            <table class="dash-table">
                <thead>
                    <tr>
                        <th style="text-align:left;">Pasien</th>
                        <th style="text-align:left;">Tanggal</th>
                        <th style="text-align:left;">Obat</th>
                        <th style="text-align:right;">Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayatTerbaru as $p)
                    <tr>
                        <td>
                            <div style="font-weight:700;color:#1e293b;">{{ $p->daftarPoli->pasien->nama ?? '-' }}</div>
                        </td>
                        <td style="font-size:12px;color:#64748b;">
                            {{ \Carbon\Carbon::parse($p->tgl_periksa)->locale('id')->isoFormat('D MMM YYYY') }}
                        </td>
                        <td style="font-size:12px;color:#64748b;">
                            @if($p->detailPeriksas->count())
                                {{ $p->detailPeriksas->map(fn($d) => $d->obat->nama_obat ?? '-')->join(', ') }}
                            @else
                                <span style="color:#cbd5e1;font-style:italic;">Tanpa resep</span>
                            @endif
                        </td>
                        <td style="text-align:right;font-weight:700;color:#1e293b;">
                            Rp {{ number_format($p->biaya_periksa, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div style="display:flex;flex-direction:column;align-items:center;padding:48px;color:#cbd5e1;">
                <i class="fas fa-notes-medical" style="font-size:36px;margin-bottom:10px;"></i>
                <p style="margin:0;font-size:13px;">Belum ada riwayat pemeriksaan.</p>
            </div>
            @endif
        </div>

    </div>

    {{-- KOLOM KANAN --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Jadwal Praktik --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon" style="background:#eff6ff;">
                        <i class="fas fa-calendar-days" style="color:#3b82f6;"></i>
                    </div>
                    Jadwal Praktik
                </div>
                <a href="{{ route('jadwal-periksa.index') }}" style="font-size:12px;font-weight:700;color:#3b82f6;text-decoration:none;">Kelola →</a>
            </div>
            <div style="padding:12px;display:flex;flex-direction:column;gap:6px;">
                @forelse($jadwals as $j)
                @php
                    $isToday = strtolower($j->hari) === strtolower($hariIni);
                @endphp
                <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 14px;border-radius:12px;
                    background:{{ $isToday ? '#eff6ff' : '#f8fafc' }};border:1px solid {{ $isToday ? '#bfdbfe' : '#f1f5f9' }};">
                    <div style="display:flex;align-items:center;gap:8px;">
                        @if($isToday)
                        <span style="width:8px;height:8px;border-radius:50%;background:#3b82f6;flex-shrink:0;"></span>
                        @else
                        <span style="width:8px;height:8px;border-radius:50%;background:#e2e8f0;flex-shrink:0;"></span>
                        @endif
                        <span style="font-size:13px;font-weight:{{ $isToday ? '800' : '600' }};color:{{ $isToday ? '#1d4ed8' : '#334155' }};">
                            {{ $j->hari }}
                        </span>
                        @if($isToday)
                        <span class="badge" style="background:#dbeafe;color:#1d4ed8;">Hari Ini</span>
                        @endif
                    </div>
                    <span style="font-size:11px;color:#64748b;font-weight:600;">
                        {{ $j->jam_mulai }} – {{ $j->jam_selesai }}
                    </span>
                </div>
                @empty
                <div style="display:flex;flex-direction:column;align-items:center;padding:32px;color:#cbd5e1;">
                    <i class="fas fa-calendar-plus" style="font-size:28px;margin-bottom:8px;"></i>
                    <p style="margin:0 0 8px;font-size:12px;">Belum ada jadwal</p>
                    <a href="{{ route('jadwal-periksa.create') }}" style="font-size:12px;font-weight:700;color:#3b82f6;text-decoration:none;">+ Tambah Jadwal</a>
                </div>
                @endforelse
            </div>
        </div>

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
                <a href="{{ route('periksa-pasien.index') }}" class="quick-item">
                    <div class="quick-icon" style="background:#f0fdf4;">
                        <i class="fas fa-stethoscope" style="color:#22c55e;"></i>
                    </div>
                    <div>
                        <div style="font-size:13px;font-weight:700;color:#1e293b;">Periksa Pasien</div>
                        <div style="font-size:11px;color:#94a3b8;">Lihat antrian pasien</div>
                    </div>
                    <i class="fas fa-chevron-right" style="color:#cbd5e1;font-size:11px;margin-left:auto;"></i>
                </a>
                <a href="{{ route('jadwal-periksa.create') }}" class="quick-item">
                    <div class="quick-icon" style="background:#eff6ff;">
                        <i class="fas fa-calendar-plus" style="color:#3b82f6;"></i>
                    </div>
                    <div>
                        <div style="font-size:13px;font-weight:700;color:#1e293b;">Tambah Jadwal</div>
                        <div style="font-size:11px;color:#94a3b8;">Atur jam praktik baru</div>
                    </div>
                    <i class="fas fa-chevron-right" style="color:#cbd5e1;font-size:11px;margin-left:auto;"></i>
                </a>
                <a href="{{ route('riwayat-pasien.index') }}" class="quick-item">
                    <div class="quick-icon" style="background:#faf5ff;">
                        <i class="fas fa-clock-rotate-left" style="color:#a855f7;"></i>
                    </div>
                    <div>
                        <div style="font-size:13px;font-weight:700;color:#1e293b;">Riwayat Pasien</div>
                        <div style="font-size:11px;color:#94a3b8;">Lihat semua pemeriksaan</div>
                    </div>
                    <i class="fas fa-chevron-right" style="color:#cbd5e1;font-size:11px;margin-left:auto;"></i>
                </a>
            </div>
        </div>

    </div>

</div>

</x-layouts.app>