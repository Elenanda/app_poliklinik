<x-layouts.app title="Manajemen Obat">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Manajemen Obat</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola data dan stok obat-obatan poliklinik</p>
        </div>
        <div class="flex gap-2 flex-wrap">
            <a href="{{ route('obat.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                <i class="fas fa-plus text-xs"></i> Tambah Obat
            </a>
        </div>
    </div>

    {{-- Stok Summary Cards --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        {{-- Total Obat --}}
        <div class="bg-white rounded-xl border border-slate-200 p-4 flex items-center gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                <i class="fas fa-pills text-blue-600"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500">Total Jenis Obat</p>
                <p class="text-xl font-bold text-slate-800">{{ $obats->count() }}</p>
            </div>
        </div>
        {{-- Stok Menipis --}}
        <div class="bg-white rounded-xl border border-amber-200 p-4 flex items-center gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
                <i class="fas fa-triangle-exclamation text-amber-500"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500">Stok Menipis</p>
                <p class="text-xl font-bold text-amber-600">{{ $obats->where('stok', '>', 0)->where('stok', '<', 10)->count() }}</p>
            </div>
        </div>
        {{-- Stok Habis --}}
        <div class="bg-white rounded-xl border border-red-200 p-4 flex items-center gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                <i class="fas fa-circle-xmark text-red-500"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500">Stok Habis</p>
                <p class="text-xl font-bold text-red-600">{{ $obats->where('stok', '<=', 0)->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table w-full">

                {{-- Table Head --}}
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Nama Obat</th>
                        <th class="px-6 py-4">Kemasan</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4 text-center">Stok</th>
                        <th class="px-6 py-4 text-center">Kelola Stok</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                {{-- Table Body --}}
                <tbody class="text-sm text-slate-700">
                    @forelse($obats as $obat)
                    <tr class="border-t border-slate-100 hover:bg-slate-50 transition
                        {{ $obat->stok <= 0 ? 'bg-red-50' : ($obat->stok < 10 ? 'bg-amber-50' : '') }}">

                        {{-- Nama Obat --}}
                        <td class="px-6 py-4 font-semibold text-slate-800">
                            {{ $obat->nama_obat }}
                            @if($obat->stok <= 0)
                                <span class="ml-2 text-[10px] font-bold uppercase tracking-wider bg-red-100 text-red-600 px-2 py-0.5 rounded-full">
                                    Habis
                                </span>
                            @elseif($obat->stok < 10)
                                <span class="ml-2 text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-600 px-2 py-0.5 rounded-full">
                                    Menipis
                                </span>
                            @endif
                        </td>

                        {{-- Kemasan --}}
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600">
                                {{ $obat->kemasan ?? '-' }}
                            </span>
                        </td>

                        {{-- Harga --}}
                        <td class="px-6 py-4 font-semibold text-slate-800">
                            Rp {{ number_format($obat->harga, 0, ',', '.') }}
                        </td>

                        {{-- Stok Badge --}}
                        <td class="px-6 py-4 text-center">
                            @if($obat->stok <= 0)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                    <i class="fas fa-xmark"></i> Habis (0)
                                </span>
                            @elseif($obat->stok < 10)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                    <i class="fas fa-triangle-exclamation"></i> {{ $obat->stok }} unit
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                    <i class="fas fa-check"></i> {{ $obat->stok }} unit
                                </span>
                            @endif
                        </td>

                        {{-- Kelola Stok --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">

                                {{-- Tombol Tambah Stok --}}
                                <button type="button"
                                    onclick="openModal('modal-tambah-{{ $obat->id }}', '{{ $obat->nama_obat }}', {{ $obat->stok }})"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold rounded-lg transition">
                                    <i class="fas fa-plus text-xs"></i> Tambah
                                </button>

                                {{-- Tombol Kurangi Stok --}}
                                <button type="button"
                                    onclick="openModal('modal-kurang-{{ $obat->id }}', '{{ $obat->nama_obat }}', {{ $obat->stok }})"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold rounded-lg transition
                                    {{ $obat->stok <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $obat->stok <= 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-minus text-xs"></i> Kurangi
                                </button>

                            </div>
                        </td>

                        {{-- Aksi CRUD --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">

                                <a href="{{ route('obat.edit', $obat->id) }}"
                                    class="inline-flex items-center gap-1 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-lg transition">
                                    <i class="fas fa-pen text-xs"></i> Edit
                                </a>

                                <form action="{{ route('obat.destroy', $obat->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Yakin ingin menghapus obat {{ $obat->nama_obat }}?')"
                                        class="inline-flex items-center gap-1 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition">
                                        <i class="fas fa-trash text-xs"></i> Hapus
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>

                    {{-- Modal Tambah Stok --}}
                    <div id="modal-tambah-{{ $obat->id }}"
                        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center">
                        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-plus text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800">Tambah Stok</h3>
                                    <p class="text-sm text-slate-500">{{ $obat->nama_obat }}</p>
                                </div>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-3 mb-5 flex items-center justify-between">
                                <span class="text-sm text-slate-500">Stok saat ini:</span>
                                <span class="text-lg font-bold text-slate-800">{{ $obat->stok }} unit</span>
                            </div>
                            <form action="{{ route('obat.tambah-stok', $obat->id) }}" method="POST">
                                @csrf
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Jumlah Penambahan <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="jumlah" min="1" placeholder="Masukkan jumlah..."
                                    class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-green-400 focus:outline-none text-slate-800 font-semibold mb-5" required>
                                <div class="flex gap-3">
                                    <button type="submit"
                                        class="flex-1 py-2.5 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-xl transition">
                                        <i class="fas fa-check mr-1"></i> Tambah Stok
                                    </button>
                                    <button type="button" onclick="closeModal('modal-tambah-{{ $obat->id }}')"
                                        class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl transition">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Modal Kurangi Stok --}}
                    <div id="modal-kurang-{{ $obat->id }}"
                        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center">
                        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center">
                                    <i class="fas fa-minus text-orange-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800">Kurangi Stok</h3>
                                    <p class="text-sm text-slate-500">{{ $obat->nama_obat }}</p>
                                </div>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-3 mb-5 flex items-center justify-between">
                                <span class="text-sm text-slate-500">Stok saat ini:</span>
                                <span class="text-lg font-bold text-slate-800">{{ $obat->stok }} unit</span>
                            </div>
                            <form action="{{ route('obat.kurang-stok', $obat->id) }}" method="POST">
                                @csrf
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Jumlah Pengurangan <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="jumlah" min="1" max="{{ $obat->stok }}"
                                    placeholder="Masukkan jumlah..."
                                    class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-orange-400 focus:outline-none text-slate-800 font-semibold mb-2" required>
                                <p class="text-xs text-slate-400 mb-5">Maksimal pengurangan: {{ $obat->stok }} unit</p>
                                <div class="flex gap-3">
                                    <button type="submit"
                                        class="flex-1 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl transition">
                                        <i class="fas fa-minus mr-1"></i> Kurangi Stok
                                    </button>
                                    <button type="button" onclick="closeModal('modal-kurang-{{ $obat->id }}')"
                                        class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl transition">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-16 text-slate-400">
                            <i class="fas fa-box-open text-4xl mb-3 block"></i>
                            Belum ada data obat
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modal on backdrop click
        document.querySelectorAll('[id^="modal-"]').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) closeModal(this.id);
            });
        });
    </script>
    @endpush

</x-layouts.app>