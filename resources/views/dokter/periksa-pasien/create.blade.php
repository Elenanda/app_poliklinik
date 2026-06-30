<x-layouts.app title="Periksa Pasien">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('periksa-pasien.index') }}" class="inline-flex items-center justify-center w-9 h-9
                  rounded-lg bg-slate-100 text-slate-500 hover:bg-slate-200 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">Periksa Pasien</h2>
    </div>

    {{-- Error alert --}}
    @if(session('error'))
    <div class="alert alert-error mb-5 rounded-xl">
        <i class="fas fa-circle-xmark"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    {{-- Card --}}
    <div class="card bg-base-100 shadow-sm rounded-2xl border border-slate-200">
        <div class="card-body p-8">

            <form action="{{ route('periksa-pasien.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_daftar_poli" value="{{ $id }}">

                {{-- Pilih Obat --}}
                <div class="form-control mb-5">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">Pilih Obat</span>
                    </label>

                    {{-- Dropdown obat dengan indikator stok --}}
                    <select id="select-obat" class="select select-bordered w-full rounded-lg border-2 px-4">
                        <option value="">-- Pilih Obat --</option>
                        @foreach ($obats as $obat)
                            <option value="{{ $obat->id }}"
                                data-nama="{{ $obat->nama_obat }}"
                                data-harga="{{ $obat->harga }}"
                                data-stok="{{ $obat->stok }}"
                                {{ $obat->stok <= 0 ? 'disabled' : '' }}
                                style="{{ $obat->stok <= 0 ? 'color:#9ca3af;' : '' }}">
                                {{ $obat->nama_obat }} — Rp{{ number_format($obat->harga) }}
                                @if($obat->stok <= 0)
                                    (HABIS)
                                @elseif($obat->stok < 10)
                                    (Stok: {{ $obat->stok }} — Menipis)
                                @else
                                    (Stok: {{ $obat->stok }})
                                @endif
                            </option>
                        @endforeach
                    </select>

                    {{-- Legenda indikator stok --}}
                    <div class="flex items-center gap-4 mt-2">
                        <span class="text-xs text-slate-400 flex items-center gap-1">
                            <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span> Tersedia
                        </span>
                        <span class="text-xs text-slate-400 flex items-center gap-1">
                            <span class="inline-block w-2 h-2 rounded-full bg-amber-500"></span> Menipis (&lt;10)
                        </span>
                        <span class="text-xs text-slate-400 flex items-center gap-1">
                            <span class="inline-block w-2 h-2 rounded-full bg-red-500"></span> Habis (tidak dapat dipilih)
                        </span>
                    </div>
                </div>

                {{-- Obat Terpilih --}}
                <div class="form-control mb-5">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">Resep Obat</span>
                    </label>

                    <ul id="obat-terpilih" class="flex flex-col gap-2 mb-2 min-h-[48px]">
                        <li id="empty-msg" class="text-sm text-slate-400 italic px-2">Belum ada obat dipilih.</li>
                    </ul>

                    <input type="hidden" name="biaya_periksa" id="biaya_periksa" value="0">
                    <input type="hidden" name="obat_json" id="obat_json">
                </div>

                {{-- Total Harga Obat --}}
                <div class="form-control mb-5">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">Total Biaya Obat</span>
                    </label>
                    <div class="flex items-center border-2 border-slate-200 rounded-xl px-4 py-3 bg-slate-50">
                        <span class="text-slate-500 text-sm font-semibold mr-2">Rp</span>
                        <span class="text-slate-800 font-bold" id="total-harga">0</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Biaya konsultasi Rp 150.000 akan ditambahkan otomatis.</p>
                </div>

                {{-- Catatan --}}
                <div class="form-control mb-8">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">Catatan / Diagnosa
                            <span class="text-slate-400 font-normal">(Opsional)</span>
                        </span>
                    </label>
                    <textarea name="catatan" id="catatan" rows="4"
                        placeholder="Masukkan diagnosa atau catatan pemeriksaan..."
                        class="textarea textarea-bordered w-full border-2 px-4 py-2 rounded-lg resize-none">{{ old('catatan') }}</textarea>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="btn bg-[#2d4499] hover:bg-[#1e2d6b] text-white border-none rounded-lg px-6">
                        <i class="fas fa-save"></i> Simpan Pemeriksaan
                    </button>
                    <a href="{{ route('periksa-pasien.index') }}"
                        class="btn btn-ghost bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-lg px-6">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

    <script>
        const selectObat = document.getElementById('select-obat');
        const listObat   = document.getElementById('obat-terpilih');
        const emptyMsg   = document.getElementById('empty-msg');
        const inputBiaya = document.getElementById('biaya_periksa');
        const inputObatJson = document.getElementById('obat_json');
        const totalHargaEl  = document.getElementById('total-harga');

        let daftarObat = [];

        selectObat.addEventListener('change', () => {
            const opt  = selectObat.options[selectObat.selectedIndex];
            const id   = opt.value;
            const nama = opt.dataset.nama;
            const harga = parseInt(opt.dataset.harga || 0);
            const stok  = parseInt(opt.dataset.stok  || 0);

            if (!id) return;

            // Cek duplikasi
            if (daftarObat.some(o => o.id == id)) {
                alert(`${nama} sudah ada dalam daftar resep.`);
                selectObat.selectedIndex = 0;
                return;
            }

            // Double-check stok (meski sudah disabled di option)
            if (stok <= 0) {
                alert(`Stok ${nama} telah habis dan tidak dapat ditambahkan ke resep.`);
                selectObat.selectedIndex = 0;
                return;
            }

            // Peringatan stok menipis
            if (stok < 10) {
                const lanjut = confirm(`⚠️ Stok ${nama} hanya tersisa ${stok} unit (menipis). Tetap tambahkan ke resep?`);
                if (!lanjut) {
                    selectObat.selectedIndex = 0;
                    return;
                }
            }

            daftarObat.push({ id, nama, harga, stok });
            renderObat();
            selectObat.selectedIndex = 0;
        });

        function renderObat() {
            listObat.innerHTML = '';
            let total = 0;

            if (daftarObat.length === 0) {
                listObat.appendChild(emptyMsg);
                inputBiaya.value = 0;
                totalHargaEl.textContent = '0';
                inputObatJson.value = '';
                return;
            }

            daftarObat.forEach((obat, index) => {
                total += obat.harga;

                const stokBadge = obat.stok < 10
                    ? `<span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-amber-100 text-amber-600 ml-1">Stok: ${obat.stok}</span>`
                    : `<span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-green-100 text-green-600 ml-1">Stok: ${obat.stok}</span>`;

                const item = document.createElement('li');
                item.className = 'flex items-center justify-between px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700';
                item.innerHTML = `
                    <span class="flex items-center flex-wrap gap-1">
                        <i class="fas fa-capsules text-blue-400 mr-1"></i>
                        ${obat.nama} ${stokBadge}
                        <span class="ml-2 font-semibold text-slate-800">Rp ${obat.harga.toLocaleString('id-ID')}</span>
                    </span>
                    <button type="button"
                        onclick="hapusObat(${index})"
                        class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 hover:bg-red-200 text-red-600 text-xs font-semibold rounded-lg transition">
                        <i class="fas fa-xmark text-xs"></i> Hapus
                    </button>
                `;
                listObat.appendChild(item);
            });

            inputBiaya.value = total;
            totalHargaEl.textContent = total.toLocaleString('id-ID');
            inputObatJson.value = JSON.stringify(daftarObat.map(o => o.id));
        }

        function hapusObat(index) {
            daftarObat.splice(index, 1);
            renderObat();
        }
    </script>

</x-layouts.app>