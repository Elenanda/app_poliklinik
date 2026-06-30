<x-layouts.app title="Edit Obat">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('obat.index') }}"
            class="flex items-center justify-center w-9 h-9 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Edit Obat</h2>
            <p class="text-slate-500 text-sm">Perbarui data obat: <span class="font-semibold">{{ $obat->nama_obat }}</span></p>
        </div>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 max-w-2xl">
        <div class="p-8">

            <form action="{{ route('obat.update', $obat->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Grid 2 col --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

                    {{-- Nama Obat --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Nama Obat <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}"
                            placeholder="Contoh: Paracetamol..."
                            class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-xl focus:border-blue-400 focus:outline-none transition @error('nama_obat') border-red-400 @enderror"
                            required>
                        @error('nama_obat')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kemasan --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kemasan</label>
                        <input type="text" name="kemasan" value="{{ old('kemasan', $obat->kemasan) }}"
                            placeholder="Contoh: Strip, Botol, Kapsul..."
                            class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-xl focus:border-blue-400 focus:outline-none transition @error('kemasan') border-red-400 @enderror">
                        @error('kemasan')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center border-2 border-slate-200 rounded-xl focus-within:border-blue-400 transition @error('harga') border-red-400 @enderror">
                            <span class="px-3 text-slate-500 text-sm font-semibold border-r border-slate-200">Rp</span>
                            <input type="number" name="harga" value="{{ old('harga', $obat->harga) }}"
                                placeholder="0" min="0" step="1"
                                class="flex-1 px-4 py-2.5 focus:outline-none rounded-r-xl" required>
                        </div>
                        @error('harga')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stok --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stok" value="{{ old('stok', $obat->stok) }}"
                            placeholder="0" min="0"
                            class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-xl focus:border-blue-400 focus:outline-none transition @error('stok') border-red-400 @enderror"
                            required>
                        <p class="text-xs text-slate-400 mt-1">
                            Untuk kelola stok, gunakan tombol <strong>Tambah/Kurangi</strong> di halaman daftar obat.
                        </p>
                        @error('stok')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Buttons --}}
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl transition">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                    <a href="{{ route('obat.index') }}"
                        class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm rounded-xl transition">
                        Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

</x-layouts.app>