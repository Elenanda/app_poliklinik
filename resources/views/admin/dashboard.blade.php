<x-layouts.app title="Dashboard Admin">

<style>
    /* ── Stat Cards ── */
    .stat-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e8ecf0;
        overflow: hidden;
        transition: transform .18s, box-shadow .18s;
        text-decoration: none;
        display: flex;
        flex-direction: column;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,.09);
    }
    .stat-card-body {
        padding: 20px 22px 16px;
        flex: 1;
    }
    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        margin-bottom: 16px;
    }
    .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1;
        margin-bottom: 4px;
    }
    .stat-label {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 600;
        letter-spacing: .04em;
        text-transform: uppercase;
    }
    .stat-footer {
        padding: 8px 22px;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
        border-top: 1px solid #f1f5f9;
    }
    /* ── Alert Bar ── */
    .alert-bar {
        border-radius: 14px;
        padding: 14px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .alert-bar-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }
    /* ── Section Card ── */
    .section-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e8ecf0;
        overflow: hidden;
    }
    .section-header {
        padding: 16px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        font-size: 14px;
        color: #1e293b;
    }
    .section-title-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
    /* ── Quick Action ── */
    .quick-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 14px;
        border-radius: 12px;
        transition: background .15s;
        text-decoration: none;
    }
    .quick-item:hover { background: #f8fafc; }
    .quick-item-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        flex-shrink: 0;
    }
    .quick-item-text p { margin: 0; }
    .quick-item-text .title {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
    }
    .quick-item-text .sub {
        font-size: 11px;
        color: #94a3b8;
    }
    /* ── Table ── */
    .dash-table th {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #94a3b8;
        padding: 10px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
    }
    .dash-table td {
        padding: 13px 20px;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f8fafc;
    }
    .dash-table tr:last-child td { border-bottom: none; }
    .dash-table tbody tr:hover td { background: #f8fafc; }
    /* ── Doctor avatar ── */
    .doc-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
        background: #dcfce7;
        color: #16a34a;
    }
</style>

{{-- ═══ GREETING ═══════════════════════════════════ --}}
<div style="margin-bottom:28px;">
    <h1 style="font-size:22px;font-weight:800;color:#1e293b;margin:0 0 4px;">
        Selamat Datang, {{ auth()->user()->nama }} 👋
    </h1>
    <p style="font-size:13px;color:#64748b;margin:0;">
        {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
        &nbsp;·&nbsp; Panel Kendali Sistem Poliklinik
    </p>
</div>

{{-- ═══ ROW 1 — STAT CARDS ════════════════════════ --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:16px;">

    {{-- Poli --}}
    <a href="{{ route('polis.index') }}" class="stat-card">
        <div class="stat-card-body">
            <div class="stat-icon" style="background:#eff6ff;">
                <i class="fas fa-hospital" style="color:#3b82f6;"></i>
            </div>
            <div class="stat-value">{{ $totalPoli }}</div>
            <div class="stat-label">Unit Poliklinik</div>
        </div>
        <div class="stat-footer" style="background:#eff6ff;color:#3b82f6;">
            <i class="fas fa-arrow-right" style="font-size:10px;"></i> Kelola Poli
        </div>
    </a>

    {{-- Dokter --}}
    <a href="{{ route('dokter.index') }}" class="stat-card">
        <div class="stat-card-body">
            <div class="stat-icon" style="background:#f0fdf4;">
                <i class="fas fa-user-doctor" style="color:#22c55e;"></i>
            </div>
            <div class="stat-value">{{ $totalDokter }}</div>
            <div class="stat-label">Tenaga Medis</div>
        </div>
        <div class="stat-footer" style="background:#f0fdf4;color:#22c55e;">
            <i class="fas fa-arrow-right" style="font-size:10px;"></i> Kelola Dokter
        </div>
    </a>

    {{-- Pasien --}}
    <a href="{{ route('pasien.index') }}" class="stat-card">
        <div class="stat-card-body">
            <div class="stat-icon" style="background:#faf5ff;">
                <i class="fas fa-bed-pulse" style="color:#a855f7;"></i>
            </div>
            <div class="stat-value">{{ $totalPasien }}</div>
            <div class="stat-label">Pasien Terdaftar</div>
        </div>
        <div class="stat-footer" style="background:#faf5ff;color:#a855f7;">
            <i class="fas fa-arrow-right" style="font-size:10px;"></i> Kelola Pasien
        </div>
    </a>

    {{-- Obat --}}
    <a href="{{ route('obat.index') }}" class="stat-card">
        <div class="stat-card-body">
            <div class="stat-icon" style="background:#fffbeb;">
                <i class="fas fa-pills" style="color:#f59e0b;"></i>
            </div>
            <div class="stat-value">{{ $totalObat }}</div>
            <div class="stat-label">Jenis Obat</div>
        </div>
        <div class="stat-footer" style="background:#fffbeb;color:#f59e0b;">
            <i class="fas fa-arrow-right" style="font-size:10px;"></i> Kelola Obat
        </div>
    </a>

</div>

{{-- ═══ ROW 2 — STATUS ALERTS ═════════════════════ --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px;">

    {{-- Stok Habis --}}
    <div class="alert-bar" style="background:{{ $stokHabis > 0 ? '#fef2f2' : '#f8fafc' }};border:1px solid {{ $stokHabis > 0 ? '#fecaca' : '#e8ecf0' }};">
        <div class="alert-bar-icon" style="background:{{ $stokHabis > 0 ? '#fee2e2' : '#f1f5f9' }};">
            <i class="fas fa-circle-xmark" style="color:{{ $stokHabis > 0 ? '#ef4444' : '#cbd5e1' }};"></i>
        </div>
        <div>
            <div style="font-size:22px;font-weight:800;color:{{ $stokHabis > 0 ? '#dc2626' : '#94a3b8' }};">{{ $stokHabis }}</div>
            <div style="font-size:11px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.04em;">Stok Habis</div>
        </div>
        @if($stokHabis > 0)
        <span style="margin-left:auto;font-size:10px;font-weight:700;background:#fecaca;color:#dc2626;padding:3px 8px;border-radius:20px;">KRITIS</span>
        @endif
    </div>

    {{-- Stok Menipis --}}
    <div class="alert-bar" style="background:{{ $stokMenipis > 0 ? '#fffbeb' : '#f8fafc' }};border:1px solid {{ $stokMenipis > 0 ? '#fcd34d' : '#e8ecf0' }};">
        <div class="alert-bar-icon" style="background:{{ $stokMenipis > 0 ? '#fef3c7' : '#f1f5f9' }};">
            <i class="fas fa-triangle-exclamation" style="color:{{ $stokMenipis > 0 ? '#f59e0b' : '#cbd5e1' }};"></i>
        </div>
        <div>
            <div style="font-size:22px;font-weight:800;color:{{ $stokMenipis > 0 ? '#d97706' : '#94a3b8' }};">{{ $stokMenipis }}</div>
            <div style="font-size:11px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.04em;">Stok Menipis</div>
        </div>
        @if($stokMenipis > 0)
        <span style="margin-left:auto;font-size:10px;font-weight:700;background:#fde68a;color:#b45309;padding:3px 8px;border-radius:20px;">PERHATIAN</span>
        @endif
    </div>

    {{-- Pendaftaran Hari Ini --}}
    <div class="alert-bar" style="background:#f0f9ff;border:1px solid #bae6fd;">
        <div class="alert-bar-icon" style="background:#e0f2fe;">
            <i class="fas fa-calendar-check" style="color:#0284c7;"></i>
        </div>
        <div>
            <div style="font-size:22px;font-weight:800;color:#0369a1;">{{ $pendaftaranHariIni }}</div>
            <div style="font-size:11px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.04em;">Daftar Hari Ini</div>
        </div>
        <span style="margin-left:auto;font-size:10px;font-weight:700;background:#bae6fd;color:#0284c7;padding:3px 8px;border-radius:20px;">HARI INI</span>
    </div>

</div>

{{-- ═══ ROW 3 — MAIN CONTENT (2 col) ════════════ --}}
<div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start;">

    {{-- KOLOM KIRI --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Tabel Unit Poliklinik --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-title-icon" style="background:#eff6ff;">
                        <i class="fas fa-hospital" style="color:#3b82f6;"></i>
                    </div>
                    Unit Poliklinik
                    <span style="background:#eff6ff;color:#3b82f6;font-size:11px;font-weight:700;padding:2px 10px;border-radius:20px;">{{ $totalPoli }}</span>
                </div>
                <a href="{{ route('polis.create') }}"
                    style="font-size:12px;font-weight:700;background:#3b82f6;color:#fff;padding:6px 14px;border-radius:8px;text-decoration:none;display:flex;align-items:center;gap:6px;transition:background .15s;"
                    onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                    <i class="fas fa-plus" style="font-size:10px;"></i> Tambah Poli
                </a>
            </div>

            @if($polis->count())
            <table class="dash-table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="text-align:left;">Nama Unit</th>
                        <th style="text-align:left;">Keterangan</th>
                        <th style="text-align:center;">Dokter</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($polis as $poli)
                    <tr>
                        <td>
                            <div style="font-weight:700;color:#1e293b;">{{ $poli->nama_poli }}</div>
                        </td>
                        <td style="color:#94a3b8;font-size:12px;">
                            {{ Str::limit($poli->keterangan ?? '-', 45, '…') }}
                        </td>
                        <td style="text-align:center;">
                            <span style="display:inline-flex;align-items:center;gap:5px;background:#f0fdf4;color:#16a34a;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
                                <i class="fas fa-user-doctor" style="font-size:9px;"></i>
                                {{ $poli->dokters_count }} dokter
                            </span>
                        </td>
                        <td style="text-align:right;">
                            <a href="{{ route('polis.edit', $poli->id) }}"
                                style="display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:700;background:#fef3c7;color:#b45309;padding:5px 12px;border-radius:8px;text-decoration:none;transition:background .15s;"
                                onmouseover="this.style.background='#fde68a'" onmouseout="this.style.background='#fef3c7'">
                                <i class="fas fa-pen" style="font-size:9px;"></i> Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px;color:#cbd5e1;">
                <i class="fas fa-hospital" style="font-size:36px;margin-bottom:10px;"></i>
                <p style="margin:0;font-size:13px;">Belum ada poli terdaftar.</p>
                <a href="{{ route('polis.create') }}" style="margin-top:12px;font-size:12px;font-weight:700;color:#3b82f6;text-decoration:none;">+ Tambah sekarang</a>
            </div>
            @endif
        </div>

        {{-- Panel Peringatan Stok Kritis --}}
        @if($obatKritis->count())
        <div class="section-card" style="border-color:#fecaca;">
            <div class="section-header" style="background:#fef2f2;">
                <div class="section-title">
                    <div class="section-title-icon" style="background:#fee2e2;">
                        <i class="fas fa-triangle-exclamation" style="color:#ef4444;"></i>
                    </div>
                    <span style="color:#dc2626;">Peringatan Stok Kritis</span>
                    <span style="background:#fee2e2;color:#dc2626;font-size:11px;font-weight:700;padding:2px 10px;border-radius:20px;">{{ $obatKritis->count() }} obat</span>
                </div>
                <a href="{{ route('obat.index') }}" style="font-size:12px;font-weight:700;color:#ef4444;text-decoration:none;">Kelola Stok →</a>
            </div>
            <div style="padding:16px;display:flex;flex-direction:column;gap:8px;">
                @foreach($obatKritis as $obat)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-radius:12px;
                    background:{{ $obat->stok <= 0 ? '#fef2f2' : '#fffbeb' }};border:1px solid {{ $obat->stok <= 0 ? '#fecaca' : '#fde68a' }};">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="width:34px;height:34px;border-radius:10px;background:{{ $obat->stok <= 0 ? '#fee2e2' : '#fef3c7' }};display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-pills" style="font-size:13px;color:{{ $obat->stok <= 0 ? '#ef4444' : '#f59e0b' }};"></i>
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:700;color:#1e293b;">{{ $obat->nama_obat }}</div>
                            <div style="font-size:11px;color:#94a3b8;">{{ $obat->kemasan ?? 'Tanpa kemasan' }}</div>
                        </div>
                    </div>
                    @if($obat->stok <= 0)
                        <span style="font-size:11px;font-weight:700;background:#fee2e2;color:#dc2626;padding:4px 12px;border-radius:20px;">HABIS</span>
                    @else
                        <span style="font-size:11px;font-weight:700;background:#fef3c7;color:#b45309;padding:4px 12px;border-radius:20px;">{{ $obat->stok }} unit</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    {{-- KOLOM KANAN --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Akses Cepat --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-title-icon" style="background:#f1f5f9;">
                        <i class="fas fa-bolt" style="color:#64748b;"></i>
                    </div>
                    Akses Cepat
                </div>
            </div>
            <div style="padding:12px;">

                <a href="{{ route('polis.create') }}" class="quick-item">
                    <div class="quick-item-icon" style="background:#eff6ff;">
                        <i class="fas fa-plus" style="color:#3b82f6;"></i>
                    </div>
                    <div class="quick-item-text">
                        <p class="title">Tambah Poli</p>
                        <p class="sub">Daftarkan unit layanan baru</p>
                    </div>
                    <i class="fas fa-chevron-right" style="color:#cbd5e1;font-size:11px;margin-left:auto;"></i>
                </a>

                <a href="{{ route('dokter.create') }}" class="quick-item">
                    <div class="quick-item-icon" style="background:#f0fdf4;">
                        <i class="fas fa-user-plus" style="color:#22c55e;"></i>
                    </div>
                    <div class="quick-item-text">
                        <p class="title">Tambah Dokter</p>
                        <p class="sub">Rekrut tenaga medis baru</p>
                    </div>
                    <i class="fas fa-chevron-right" style="color:#cbd5e1;font-size:11px;margin-left:auto;"></i>
                </a>

                <a href="{{ route('pasien.create') }}" class="quick-item">
                    <div class="quick-item-icon" style="background:#faf5ff;">
                        <i class="fas fa-user-plus" style="color:#a855f7;"></i>
                    </div>
                    <div class="quick-item-text">
                        <p class="title">Tambah Pasien</p>
                        <p class="sub">Daftarkan pasien baru</p>
                    </div>
                    <i class="fas fa-chevron-right" style="color:#cbd5e1;font-size:11px;margin-left:auto;"></i>
                </a>

                <a href="{{ route('obat.create') }}" class="quick-item">
                    <div class="quick-item-icon" style="background:#fffbeb;">
                        <i class="fas fa-capsules" style="color:#f59e0b;"></i>
                    </div>
                    <div class="quick-item-text">
                        <p class="title">Tambah Obat</p>
                        <p class="sub">Daftarkan obat ke farmasi</p>
                    </div>
                    <i class="fas fa-chevron-right" style="color:#cbd5e1;font-size:11px;margin-left:auto;"></i>
                </a>

                <a href="{{ route('obat.index') }}" class="quick-item">
                    <div class="quick-item-icon" style="background:#fef2f2;">
                        <i class="fas fa-boxes-stacked" style="color:#ef4444;"></i>
                    </div>
                    <div class="quick-item-text">
                        <p class="title">Kelola Stok</p>
                        <p class="sub">Tambah / kurangi stok obat</p>
                    </div>
                    <i class="fas fa-chevron-right" style="color:#cbd5e1;font-size:11px;margin-left:auto;"></i>
                </a>

            </div>
        </div>

        {{-- Daftar Dokter --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-title-icon" style="background:#f0fdf4;">
                        <i class="fas fa-user-doctor" style="color:#22c55e;"></i>
                    </div>
                    Dokter Aktif
                </div>
                <a href="{{ route('dokter.index') }}" style="font-size:12px;font-weight:700;color:#22c55e;text-decoration:none;">Semua →</a>
            </div>
            <div style="padding:12px;display:flex;flex-direction:column;gap:4px;">
                @forelse($dokters as $dokter)
                <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:10px;transition:background .15s;"
                    onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <div class="doc-avatar">{{ strtoupper(substr($dokter->nama, 0, 1)) }}</div>
                    <div style="min-width:0;">
                        <div style="font-size:13px;font-weight:700;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $dokter->nama }}
                        </div>
                        <div style="font-size:11px;color:#94a3b8;">
                            {{ $dokter->poli->nama_poli ?? 'Belum ada poli' }}
                        </div>
                    </div>
                </div>
                @empty
                <div style="display:flex;flex-direction:column;align-items:center;padding:32px;color:#cbd5e1;">
                    <i class="fas fa-user-doctor" style="font-size:28px;margin-bottom:8px;"></i>
                    <p style="margin:0;font-size:12px;">Belum ada dokter</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

</x-layouts.app>