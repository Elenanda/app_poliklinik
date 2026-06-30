<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POLIKLINIK - Layanan Kesehatan Terpadu</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; scroll-behavior: smooth; }
        
        .hero-bg {
            background: linear-gradient(135deg, #1e2d6b 0%, #2d4499 60%, #1a2d7a 100%);
            position: relative;
            overflow: hidden;
        }
        
        .hero-pattern {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.6;
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-[#2d4499] selection:text-white">

    {{-- NAVBAR --}}
    <nav class="fixed w-full z-50 glass-nav border-b border-slate-200/50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                {{-- Brand --}}
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 rounded-xl bg-white shadow-sm object-cover border border-slate-100">
                    <span class="font-extrabold text-2xl tracking-tight text-[#1e2d6b]">POLIKLINIK</span>
                </div>
                
                {{-- Auth Buttons --}}
                <div class="flex items-center gap-2 sm:gap-4">
                    <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-full bg-gradient-to-r from-[#1e2d6b] to-[#2d4499] text-white font-bold text-sm hover:shadow-lg hover:shadow-indigo-500/30 transition-all hover:-translate-y-0.5">
                        Halaman Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <section class="hero-bg pt-32 pb-24 lg:pt-48 lg:pb-32 text-white text-center rounded-b-[40px] shadow-sm">
        <div class="hero-pattern"></div>
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="inline-block px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-xs sm:text-sm font-bold tracking-wide mb-8 animate-bounce-slow">
                ✨ Layanan Kesehatan Terbaik Untuk Anda
            </div>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight mb-6 leading-tight">
                Kesehatan Anda Adalah <br class="hidden md:block"> Prioritas Utama Kami
            </h1>
            
            <p class="text-lg md:text-xl text-indigo-100 mb-10 max-w-2xl mx-auto leading-relaxed">
                Sistem Informasi Manajemen Poliklinik Terpadu. Dapatkan layanan konsultasi dengan dokter spesialis, jadwal yang fleksibel, dan pendaftaran rawat jalan tanpa ribet.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('login') }}" class="px-8 py-4 rounded-full bg-white text-[#1e2d6b] font-bold text-lg hover:bg-slate-50 transition-all shadow-xl hover:-translate-y-1 hover:shadow-indigo-900/50 flex items-center justify-center gap-2">
                    Lanjut ke Halaman Login <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
        </div>
    </section>

    {{-- FEATURES SECTION --}}
    <section class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-[#1e2d6b] mb-4">Mengapa Memilih Kami?</h2>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg">Kami mengintegrasikan teknologi dalam pelayanan kesehatan untuk memastikan pengalaman medis yang transparan dan cepat.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                
                {{-- Feature 1 --}}
                <div class="bg-white p-8 rounded-[24px] shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-user-doctor"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Dokter Spesialis</h3>
                    <p class="text-slate-500 leading-relaxed">Poli kami didukung oleh tenaga medis profesional dan berpengalaman untuk menangani keluhan spesifik Anda.</p>
                </div>

                {{-- Feature 2 --}}
                <div class="bg-white p-8 rounded-[24px] shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Pendaftaran Online</h3>
                    <p class="text-slate-500 leading-relaxed">Pilih jadwal periksa yang Anda inginkan dari rumah tanpa perlu mengambil nomor antrian secara manual di klinik.</p>
                </div>

                {{-- Feature 3 --}}
                <div class="bg-white p-8 rounded-[24px] shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-16 h-16 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:bg-purple-500 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-notes-medical"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Rekam Medis Digital</h3>
                    <p class="text-slate-500 leading-relaxed">Seluruh riwayat pemeriksaan, keluhan, dan resep obat tersimpan rapi dan dapat diakses kapan saja.</p>
                </div>

            </div>
        </div>
    </section>

    {{-- STATS SECTION --}}
    <section class="py-16 bg-white border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-10 text-center divide-x-0 md:divide-x divide-slate-100">
                <div class="p-4">
                    <div class="text-4xl md:text-5xl font-extrabold text-[#1e2d6b] mb-2 tracking-tight">12+</div>
                    <div class="text-xs md:text-sm font-bold text-slate-400 uppercase tracking-widest">Unit Poli</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl md:text-5xl font-extrabold text-[#1e2d6b] mb-2 tracking-tight">45+</div>
                    <div class="text-xs md:text-sm font-bold text-slate-400 uppercase tracking-widest">Tenaga Medis</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl md:text-5xl font-extrabold text-[#1e2d6b] mb-2 tracking-tight">15k</div>
                    <div class="text-xs md:text-sm font-bold text-slate-400 uppercase tracking-widest">Pasien</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl md:text-5xl font-extrabold text-[#1e2d6b] mb-2 tracking-tight">24/7</div>
                    <div class="text-xs md:text-sm font-bold text-slate-400 uppercase tracking-widest">Sistem Aktif</div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA SECTION --}}
    <section class="py-24 bg-slate-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-[#1e2d6b] to-[#2d4499] rounded-[32px] p-10 md:p-16 text-center text-white relative overflow-hidden shadow-2xl">
                
                {{-- Decorative circles --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4"></div>
                
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-5xl font-extrabold mb-6 tracking-tight">Siap untuk Konsultasi?</h2>
                    <p class="text-indigo-200 mb-10 max-w-xl mx-auto text-lg leading-relaxed">
                        Bergabunglah dengan ribuan pasien lainnya dan nikmati pendaftaran layanan kesehatan yang cepat dan terpercaya tanpa perlu antri lama.
                    </p>
                    <a href="{{ route('login') }}" class="inline-block px-10 py-4 rounded-full bg-white text-[#1e2d6b] font-bold text-lg hover:bg-slate-50 transition-all shadow-xl hover:-translate-y-1 hover:shadow-indigo-900/50">
                        Lanjut ke Halaman Login
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-white border-t border-slate-200 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 md:gap-8 mb-12">
                
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="{{ asset('images/logo.png') }}" class="w-10 h-10 rounded-lg object-cover grayscale opacity-80 border border-slate-200">
                        <span class="font-extrabold text-2xl tracking-tight text-slate-800">POLIKLINIK</span>
                    </div>
                    <p class="text-slate-500 leading-relaxed max-w-sm mb-6">
                        Platform layanan kesehatan terpadu yang menjembatani pasien dengan dokter-dokter spesialis terbaik melalui ekosistem digital.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:text-white hover:bg-[#1e2d6b] transition-all"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:text-white hover:bg-[#1e2d6b] transition-all"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:text-white hover:bg-[#1e2d6b] transition-all"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold text-slate-800 text-lg mb-6">Tautan Akses</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('login') }}" class="text-slate-500 hover:text-[#1e2d6b] transition font-medium">Masuk Sistem</a></li>
                        <li><a href="{{ route('register') }}" class="text-slate-500 hover:text-[#1e2d6b] transition font-medium">Pendaftaran Pasien</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-slate-800 text-lg mb-6">Kontak Kami</h4>
                    <ul class="space-y-4 text-slate-500 font-medium">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt mt-1 text-slate-400"></i> Jl. Kesehatan No. 123, Semarang
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone text-slate-400"></i> (024) 123-4567
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-slate-400"></i> info@poliklinik.com
                        </li>
                    </ul>
                </div>

            </div>

            <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-400 text-sm font-medium">
                    &copy; {{ date('Y') }} Bengkel Koding - Poliklinik. Seluruh hak cipta dilindungi.
                </p>
                <div class="flex gap-6 text-sm font-medium text-slate-400">
                    <a href="#" class="hover:text-slate-600 transition">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-slate-600 transition">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>