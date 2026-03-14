@extends('layouts.app')

@section('title', 'REVA Mail - Generator Email Gratis')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Hero Section -->
    <div class="text-center mb-12 pt-6">
        <!-- Badge -->
        <div class="inline-flex items-center bg-pink-100 text-pink-700 rounded-full px-4 py-1.5 text-sm font-semibold mb-6 border border-pink-200">
            <i class="fas fa-shield-alt mr-2 text-pink-500"></i>100% Gratis &amp; Anonim
        </div>
        <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight" style="color:#831843;">
            Email
            <span style="background:linear-gradient(135deg,#db2777,#ec4899,#f472b6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;"> Generator</span>
        </h1>
        <p class="text-lg text-gray-500 mb-8 max-w-xl mx-auto leading-relaxed">
            Lindungi privasi Anda dengan alamat email sekali pakai yang instan.<br class="hidden sm:block"> Tidak perlu registrasi!
        </p>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center mb-8">
            <button id="generateEmailBtn" class="btn-pink inline-flex items-center justify-center py-4 px-8 rounded-xl text-base shadow-lg">
                <i class="fas fa-magic mr-2" id="generateIcon"></i>
                <span id="generateText">Buat Email</span>
            </button>
            <a href="{{ route('api.docs') }}" class="gradient-btn-dark inline-flex items-center justify-center text-white font-semibold py-4 px-8 rounded-xl text-base shadow-lg hover:shadow-xl transition-all">
                <i class="fas fa-code mr-2"></i>Dokumentasi API
            </a>
        </div>

        <!-- Trust badges -->
        <div class="flex flex-wrap justify-center gap-4 text-sm text-gray-400">
            <span class="flex items-center"><i class="fas fa-bolt mr-1.5 text-pink-400"></i>Instan</span>
            <span class="flex items-center"><i class="fas fa-lock mr-1.5 text-pink-400"></i>Privat</span>
            <span class="flex items-center"><i class="fas fa-ban mr-1.5 text-pink-400"></i>Tanpa Spam</span>
            <span class="flex items-center"><i class="fas fa-check-circle mr-1.5 text-pink-400"></i>Tanpa Registrasi</span>
        </div>
    </div>

    <!-- ═══ REAL-TIME STATISTICS DASHBOARD ═══ -->
    <section class="mb-10">
        <!-- Header row -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                <span class="text-xs font-bold uppercase tracking-widest" style="color:#be185d;">📊 Statistik Live</span>
            </div>
            <div class="flex items-center gap-1.5 text-xs text-gray-400" id="statsLastUpdated">
                <i class="fas fa-sync-alt text-pink-300" id="statsRefreshIcon"></i>
                <span id="statsTimestamp">Nyambung dulu...</span>
            </div>
        </div>

        <!-- Stat Cards Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">

            <!-- Active Emails -->
            <div class="stat-card bg-white rounded-2xl p-5 shadow-md text-center" style="border:1.5px solid #fbcfe8;">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mx-auto mb-3" style="background:linear-gradient(135deg,#fce7f3,#fbcfe8);">
                    <i class="fas fa-envelope" style="color:#ec4899;"></i>
                </div>
                <div class="text-3xl font-extrabold mb-1 tabular-nums" style="color:#be185d;" id="stat-active-emails">
                    <i class="fas fa-spinner loading text-pink-300 text-xl"></i>
                </div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Lagi Aktif 🔥</div>
            </div>

            <!-- Generated Today -->
            <div class="stat-card bg-white rounded-2xl p-5 shadow-md text-center" style="border:1.5px solid #fbcfe8;">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mx-auto mb-3" style="background:linear-gradient(135deg,#fce7f3,#fbcfe8);">
                    <i class="fas fa-magic" style="color:#db2777;"></i>
                </div>
                <div class="text-3xl font-extrabold mb-1 tabular-nums" style="color:#be185d;" id="stat-generated-today">
                    <i class="fas fa-spinner loading text-pink-300 text-xl"></i>
                </div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Dibuat Hari Ini ✨</div>
            </div>

            <!-- Emails Received Today -->
            <div class="stat-card bg-white rounded-2xl p-5 shadow-md text-center" style="border:1.5px solid #fbcfe8;">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mx-auto mb-3" style="background:linear-gradient(135deg,#fce7f3,#fbcfe8);">
                    <i class="fas fa-inbox" style="color:#ec4899;"></i>
                </div>
                <div class="text-3xl font-extrabold mb-1 tabular-nums" style="color:#be185d;" id="stat-received-today">
                    <i class="fas fa-spinner loading text-pink-300 text-xl"></i>
                </div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Masuk Hari Ini 📬</div>
            </div>

            <!-- Total All-Time -->
            <div class="stat-card bg-white rounded-2xl p-5 shadow-md text-center" style="border:1.5px solid #fbcfe8;">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mx-auto mb-3" style="background:linear-gradient(135deg,#fce7f3,#fbcfe8);">
                    <i class="fas fa-database" style="color:#9d174d;"></i>
                </div>
                <div class="text-3xl font-extrabold mb-1 tabular-nums" style="color:#be185d;" id="stat-total-generated">
                    <i class="fas fa-spinner loading text-pink-300 text-xl"></i>
                </div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Sepanjang Masa 🏆</div>
            </div>
        </div>

        <!-- Notification / Warning Banners -->
        <div class="space-y-2" id="statsBanners">
            <!-- Expiring Soon Warning -->
            <div id="bannerExpiringSoon" class="hidden items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium" style="background:linear-gradient(135deg,#fff7ed,#ffedd5);border:1.5px solid #fed7aa;color:#92400e;">
                <i class="fas fa-exclamation-triangle text-amber-500 flex-shrink-0"></i>
                <span>Ups! Ada <strong id="bannerExpiringSoonCount">0</strong> email yang mau kedaluwarsa dalam 24 jam ke depan. Buruan diperpanjang! ⏰</span>
            </div>
        </div>
    </section>
    <!-- ═══════════════════════════════════════ -->

    <!-- Email Display Section -->
    <div id="emailSection" class="hidden fade-in">
        <div class="bg-white rounded-2xl shadow-xl border border-pink-100 p-6 mb-6">
            <!-- Email header -->
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-5 gap-4">
                <div>
                    <h2 class="text-xl font-bold mb-1" style="color:#9d174d;">
                        <i class="fas fa-envelope mr-2" style="color:#ec4899;"></i>Email REVA Anda
                    </h2>
                    <p class="text-xs text-gray-400">Alamat ini aktif dan siap menerima email</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button id="copyEmailBtn" class="inline-flex items-center bg-emerald-500 hover:bg-emerald-600 text-white px-3.5 py-2 rounded-lg text-sm font-medium transition-all shadow-sm hover:shadow-md">
                        <i class="fas fa-copy mr-1.5"></i>Salin
                    </button>
                    <button id="shareUrlBtn" class="inline-flex items-center btn-pink px-3.5 py-2 rounded-lg text-sm">
                        <i class="fas fa-share-alt mr-1.5"></i>Bagikan
                    </button>
                    <button id="refreshInboxBtn" class="inline-flex items-center bg-sky-500 hover:bg-sky-600 text-white px-3.5 py-2 rounded-lg text-sm font-medium transition-all shadow-sm">
                        <i class="fas fa-sync-alt mr-1.5"></i>Perbarui
                    </button>
                    <button id="deleteEmailBtn" class="inline-flex items-center bg-rose-500 hover:bg-rose-600 text-white px-3.5 py-2 rounded-lg text-sm font-medium transition-all shadow-sm">
                        <i class="fas fa-trash mr-1.5"></i>Hapus
                    </button>
                </div>
            </div>
            
            <!-- Email address display -->
            <div class="copy-field rounded-xl p-4 mb-5">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <span id="emailAddress" class="text-lg font-mono font-semibold break-all" style="color:#831843;"></span>
                    <span id="emailStatus" class="px-3 py-1 badge-active text-xs font-semibold rounded-full">
                        <i class="fas fa-circle text-xs mr-1"></i>Aktif
                    </span>
                </div>
                <div class="text-xs text-pink-500 mt-2 flex items-center">
                    <i class="fas fa-clock mr-1.5"></i>Kedaluwarsa: <span id="expirationTime" class="font-medium ml-1"></span>
                    &nbsp;·&nbsp;<span id="timeRemaining" class="font-medium"></span> tersisa
                </div>
            </div>
            
            <!-- Email Stats -->
            <div class="grid grid-cols-3 gap-3 mb-5">
                <div class="stat-card rounded-xl p-4 text-center" style="background:linear-gradient(135deg,#fdf2f8,#fce7f3);border:1px solid #fbcfe8;">
                    <div class="text-2xl font-extrabold" style="color:#be185d;" id="totalEmails">0</div>
                    <div class="text-xs text-gray-500 font-medium mt-1">Total Email</div>
                </div>
                <div class="stat-card rounded-xl p-4 text-center" style="background:linear-gradient(135deg,#fdf2f8,#fce7f3);border:1px solid #fbcfe8;">
                    <div class="text-2xl font-extrabold" style="color:#ec4899;" id="unreadEmails">0</div>
                    <div class="text-xs text-gray-500 font-medium mt-1">Belum Dibaca</div>
                </div>
                <div class="stat-card rounded-xl p-4 text-center" style="background:linear-gradient(135deg,#fdf2f8,#fce7f3);border:1px solid #fbcfe8;">
                    <div class="text-2xl font-extrabold" style="color:#9d174d;" id="readEmails">0</div>
                    <div class="text-xs text-gray-500 font-medium mt-1">Sudah Dibaca</div>
                </div>
            </div>

            <!-- Extend Time -->
            <div class="flex items-center gap-2 pt-4 border-t border-pink-100">
                <select id="extendMonths" class="border border-pink-200 rounded-lg px-3 py-2 text-sm text-gray-700 bg-white focus:ring-2 focus:ring-pink-300 outline-none">
                    <option value="1">1 Bulan</option>
                    <option value="6">6 Bulan</option>
                    <option value="12">1 Tahun</option>
                </select>
                <button id="extendTimeBtn" class="inline-flex items-center bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all shadow-sm">
                    <i class="fas fa-clock mr-1.5"></i>Perpanjang Waktu
                </button>
            </div>
        </div>

        <!-- Inbox Section -->
        <div class="bg-white rounded-2xl shadow-xl border border-pink-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold" style="color:#9d174d;">
                    <i class="fas fa-inbox mr-2" style="color:#ec4899;"></i>Inbox
                </h3>
                <button id="simulateEmailBtn" class="inline-flex items-center btn-outline-pink px-4 py-2 rounded-lg text-sm">
                    <i class="fas fa-flask mr-1.5"></i>Simulasi Email (Test)
                </button>
            </div>
            
            <!-- Loading State -->
            <div id="inboxLoading" class="text-center py-12 hidden">
                <i class="fas fa-spinner loading text-3xl mb-3" style="color:#ec4899;"></i>
                <p class="text-gray-400">Memuat email...</p>
            </div>
            
            <!-- Empty State -->
            <div id="emptyInbox" class="text-center py-16">
                <div class="w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-5" style="background:linear-gradient(135deg,#fce7f3,#fdf2f8);">
                    <i class="fas fa-inbox text-4xl" style="color:#f9a8d4;"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-500 mb-2">Belum ada email</h3>
                <p class="text-gray-400 text-sm">Email yang dikirim ke alamat Anda akan muncul di sini secara otomatis.</p>
            </div>
            
            <!-- Email List -->
            <div id="emailList" class="space-y-4"></div>
            
            <!-- Pagination -->
            <div id="paginationContainer" class="mt-6 hidden">
                <nav class="flex justify-center">
                    <ul class="flex space-x-1" id="pagination"></ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section id="features" class="mt-20">
        <div class="text-center mb-12">
            <div class="inline-flex items-center bg-pink-100 text-pink-600 rounded-full px-4 py-1 text-xs font-bold uppercase tracking-widest mb-4 border border-pink-200">
                <i class="fas fa-star mr-1.5"></i>Fitur
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold mb-3" style="color:#831843;">
                Mengapa Pilih REVA Mail?
            </h2>
            <p class="text-gray-500 max-w-lg mx-auto">
                Fitur canggih untuk melindungi privasi Anda dan menjaga inbox tetap bersih
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-6">
            <div class="feature-card bg-white rounded-2xl p-7 text-center shadow-md border border-pink-50">
                <div class="feature-icon-wrap w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <i class="fas fa-bolt text-2xl" style="color:#db2777;"></i>
                </div>
                <h3 class="text-lg font-bold mb-2" style="color:#9d174d;">Pembuatan Instan</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Dapatkan alamat email Anda dalam hitungan detik. Tidak ada tunggu, tidak perlu verifikasi.</p>
            </div>
            
            <div class="feature-card bg-white rounded-2xl p-7 text-center shadow-md border border-pink-50">
                <div class="feature-icon-wrap w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <i class="fas fa-shield-alt text-2xl" style="color:#db2777;"></i>
                </div>
                <h3 class="text-lg font-bold mb-2" style="color:#9d174d;">Privasi Lengkap</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Tidak perlu informasi pribadi. Data Anda otomatis dihapus setelah kedaluwarsa.</p>
            </div>
            
            <div class="feature-card bg-white rounded-2xl p-7 text-center shadow-md border border-pink-50">
                <div class="feature-icon-wrap w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <i class="fas fa-sync-alt text-2xl" style="color:#db2777;"></i>
                </div>
                <h3 class="text-lg font-bold mb-2" style="color:#9d174d;">Update Real-time</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Email yang diterima langsung muncul di inbox dengan refresh otomatis.</p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="mt-16">
        <div class="rounded-2xl p-10 text-center" style="background:linear-gradient(135deg,#fdf2f8 0%,#fce7f3 100%);border:1.5px solid #fbcfe8;">
            <div class="inline-flex items-center bg-pink-200 text-pink-700 rounded-full px-4 py-1 text-xs font-bold uppercase tracking-widest mb-5 border border-pink-300">
                <i class="fas fa-info-circle mr-1.5"></i>Tentang
            </div>
            <h2 class="text-3xl font-extrabold mb-5" style="color:#831843;">Tentang REVA Mail</h2>
            <p class="text-gray-600 mb-4 max-w-2xl mx-auto leading-relaxed">
                REVA Mail adalah layanan gratis yang menyediakan alamat email aman dan anonim untuk Anda.
                Gunakan untuk melindungi privasi saat mendaftar layanan online, mengunduh file, atau situasi lain
                di mana Anda butuh alamat email tapi tidak ingin menggunakan email pribadi Anda.
            </p>
            <p class="text-gray-500 text-sm max-w-xl mx-auto">
                Semua email otomatis dihapus setelah kedaluwarsa, memastikan privasi Anda selalu terlindungi.
                Tidak perlu registrasi, tidak perlu informasi pribadi.
            </p>
        </div>
    </section>

    <!-- Developer Section -->
    <section class="mt-16 mb-4">
        <div class="rounded-2xl p-10" style="background:linear-gradient(135deg,#831843 0%,#be185d 50%,#ec4899 100%);">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-flex items-center bg-white bg-opacity-20 text-white rounded-full px-4 py-1 text-xs font-bold uppercase tracking-widest mb-5 border border-white border-opacity-30">
                    <i class="fas fa-code mr-1.5"></i>Untuk Developer
                </div>
                <h2 class="text-3xl font-extrabold text-white mb-4">
                    REST API Yang Canggih
                </h2>
                <p class="text-pink-100 mb-8 max-w-xl mx-auto">
                    Integrasikan REVA Mail ke aplikasi Anda dengan REST API komprehensif kami.
                    Sempurna untuk testing, otomasi, dan melindungi privasi pengguna.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-white bg-opacity-10 backdrop-blur rounded-xl p-5 border border-white border-opacity-20 text-left">
                        <div class="text-2xl mb-3 text-pink-200"><i class="fas fa-rocket"></i></div>
                        <h3 class="font-bold text-white mb-1">Integrasi Mudah</h3>
                        <p class="text-pink-200 text-sm">REST API sederhana dengan dokumentasi lengkap dan contoh kode</p>
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur rounded-xl p-5 border border-white border-opacity-20 text-left">
                        <div class="text-2xl mb-3 text-pink-200"><i class="fas fa-shield-alt"></i></div>
                        <h3 class="font-bold text-white mb-1">Handal & Aman</h3>
                        <p class="text-pink-200 text-sm">Rate limiting, proteksi CSRF, dan pembersihan data otomatis</p>
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur rounded-xl p-5 border border-white border-opacity-20 text-left">
                        <div class="text-2xl mb-3 text-pink-200"><i class="fas fa-flask"></i></div>
                        <h3 class="font-bold text-white mb-1">Fitur Testing</h3>
                        <p class="text-pink-200 text-sm">Endpoint simulasi email yang sempurna untuk development dan testing</p>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('api.docs') }}" class="inline-flex items-center justify-center bg-white text-pink-700 font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5 text-sm">
                        <i class="fas fa-book mr-2"></i>Lihat Dokumentasi API
                    </a>
                    <a href="/openapi.yaml" target="_blank" class="inline-flex items-center justify-center bg-white bg-opacity-15 text-white font-semibold py-3 px-6 rounded-xl hover:bg-opacity-25 transition-all border border-white border-opacity-30 text-sm">
                        <i class="fas fa-code-branch mr-2"></i>Spesifikasi OpenAPI
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Generation Options Modal -->
<div id="generationModal" class="fixed inset-0 modal-backdrop hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-hidden slide-up" style="border:1.5px solid #fbcfe8;">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-5" style="background:linear-gradient(135deg,#fdf2f8,#fce7f3);border-bottom:1.5px solid #fbcfe8;">
                <div>
                    <h3 class="text-lg font-bold" style="color:#831843;">
                        <i class="fas fa-magic mr-2" style="color:#ec4899;"></i>Buat Email
                    </h3>
                    <p class="text-xs text-pink-400 mt-0.5">Pilih otomatis atau alamat custom</p>
                </div>
                <button id="closeGenerationModal" class="w-8 h-8 rounded-lg bg-pink-100 hover:bg-pink-200 flex items-center justify-center transition-colors" style="color:#be185d;">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
            <div class="p-6">
                <!-- Generation Type Selection -->
                <div class="mb-5">
                    <label class="block text-xs font-bold uppercase tracking-widest mb-3" style="color:#be185d;">Tipe Pembuatan</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="generationType" value="auto" checked class="hidden peer">
                            <div class="peer-checked:ring-2 peer-checked:ring-pink-500 peer-checked:bg-pink-50 rounded-xl p-4 border-2 border-gray-200 peer-checked:border-pink-400 hover:border-pink-300 transition-all text-center">
                                <i class="fas fa-random text-xl mb-2 block" style="color:#ec4899;"></i>
                                <span class="text-sm font-semibold text-gray-700">Otomatis (Acak)</span>
                                <p class="text-xs text-gray-400 mt-1">Biarkan kami pilihkan</p>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="generationType" value="custom" class="hidden peer">
                            <div class="peer-checked:ring-2 peer-checked:ring-pink-500 peer-checked:bg-pink-50 rounded-xl p-4 border-2 border-gray-200 peer-checked:border-pink-400 hover:border-pink-300 transition-all text-center">
                                <i class="fas fa-edit text-xl mb-2 block" style="color:#ec4899;"></i>
                                <span class="text-sm font-semibold text-gray-700">Custom</span>
                                <p class="text-xs text-gray-400 mt-1">Pilih nama Anda</p>
                            </div>
                        </label>
                    </div>
                </div>
                
                <!-- Custom Email Input -->
                <div id="customEmailSection" class="hidden mb-5">
                    <label class="block text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Username Custom</label>
                    <div class="flex items-center rounded-xl overflow-hidden" style="border:1.5px solid #f9a8d4;">
                        <input 
                            type="text" 
                            id="customEmailInput" 
                            class="flex-1 px-4 py-2.5 bg-white text-gray-800 text-sm outline-none" 
                            placeholder="namakamu"
                            pattern="[a-zA-Z0-9._-]+"
                            maxlength="30"
                        >
                        <span class="px-3 py-2.5 text-xs font-mono font-medium whitespace-nowrap" style="background:#fdf2f8;color:#be185d;border-left:1.5px solid #f9a8d4;">@revacantik.my.id</span>
                    </div>
                    <div class="mt-2">
                        <p class="text-xs text-gray-400">
                            <i class="fas fa-info-circle mr-1"></i>
                            Huruf, angka, titik, tanda hubung, garis bawah (3-30 karakter)
                        </p>
                        <div id="customEmailFeedback" class="text-sm mt-1 hidden"></div>
                    </div>
                </div>
                
                <!-- Preview -->
                <div id="emailPreview" class="mb-5 p-3 rounded-xl hidden" style="background:#fdf2f8;border:1.5px solid #f9a8d4;">
                    <p class="text-xs font-semibold mb-1" style="color:#be185d;">
                        <i class="fas fa-eye mr-1"></i>Preview
                    </p>
                    <p class="font-mono text-sm font-bold" style="color:#831843;" id="previewText"></p>
                </div>
                
                <!-- Expiration Settings -->
                <div class="mb-6">
                    <label class="block text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Durasi Email</label>
                    <select id="expirationSelect" class="w-full px-4 py-2.5 rounded-xl text-sm text-gray-700 bg-white outline-none" style="border:1.5px solid #f9a8d4;">
                        <option value="1_month">⏱ 1 Bulan</option>
                        <option value="6_months">⏱ 6 Bulan</option>
                        <option value="1_year">⏱ 1 Tahun</option>
                    </select>
                </div>
                
                <!-- Modal Action Buttons -->
                <div class="flex gap-3">
                    <button id="confirmGenerateBtn" class="flex-1 btn-pink py-3 px-6 rounded-xl flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed" style="disabled:transform:none;">
                        <i class="fas fa-magic mr-2" id="confirmGenerateIcon"></i>
                        <span id="confirmGenerateText">Buat Email</span>
                    </button>
                    <button id="cancelGenerateBtn" class="px-5 py-3 rounded-xl font-medium text-sm transition-all" style="border:1.5px solid #f9a8d4;color:#be185d;background:#fdf2f8;">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Email Detail Modal -->
<div id="emailModal" class="fixed inset-0 modal-backdrop hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden slide-up" style="border:1.5px solid #fbcfe8;">
            <div class="flex items-center justify-between px-6 py-5" style="background:linear-gradient(135deg,#fdf2f8,#fce7f3);border-bottom:1.5px solid #fbcfe8;">
                <div>
                    <h3 class="text-lg font-bold" style="color:#831843;"><i class="fas fa-envelope-open mr-2" style="color:#ec4899;"></i>Detail Email</h3>
                </div>
                <button id="closeEmailModal" class="w-8 h-8 rounded-lg bg-pink-100 hover:bg-pink-200 flex items-center justify-center transition-colors" style="color:#be185d;">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
            <div id="emailContent" class="p-6 overflow-y-auto" style="max-height: calc(90vh - 100px);">
                <!-- Email content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentEmail = null;
let pollingInterval = null;
let countdownInterval = null;

// DOM elements
const generateEmailBtn = document.getElementById('generateEmailBtn');
const generateIcon = document.getElementById('generateIcon');
const generateText = document.getElementById('generateText');
const emailSection = document.getElementById('emailSection');
const emailAddress = document.getElementById('emailAddress');
const expirationTime = document.getElementById('expirationTime');
const timeRemaining = document.getElementById('timeRemaining');
const copyEmailBtn = document.getElementById('copyEmailBtn');
const shareUrlBtn = document.getElementById('shareUrlBtn');
const refreshInboxBtn = document.getElementById('refreshInboxBtn');
const deleteEmailBtn = document.getElementById('deleteEmailBtn');
const extendTimeBtn = document.getElementById('extendTimeBtn');
const simulateEmailBtn = document.getElementById('simulateEmailBtn');
const emailList = document.getElementById('emailList');
const emptyInbox = document.getElementById('emptyInbox');
const inboxLoading = document.getElementById('inboxLoading');

// Custom email elements
const generationTypeRadios = document.querySelectorAll('input[name="generationType"]');
const customEmailSection = document.getElementById('customEmailSection');
const customEmailInput = document.getElementById('customEmailInput');
const emailPreview = document.getElementById('emailPreview');
const previewText = document.getElementById('previewText');
const customEmailFeedback = document.getElementById('customEmailFeedback');

// Current generation mode
let generationMode = 'auto';
let customEmail = '';
let availabilityTimeout = null;
let isCheckingAvailability = false;

// Check if we have preloaded email data
const preloadedEmail = @json($preloadEmail ?? null);
const isDirectAccess = @json($directAccess ?? false);

// Event listeners
generateEmailBtn.addEventListener('click', openGenerationModal);
copyEmailBtn.addEventListener('click', copyEmail);
shareUrlBtn.addEventListener('click', shareUrl);
refreshInboxBtn.addEventListener('click', refreshInbox);
deleteEmailBtn.addEventListener('click', deleteEmail);
extendTimeBtn.addEventListener('click', extendTime);
simulateEmailBtn.addEventListener('click', simulateEmail);

// Modal event listeners
document.getElementById('confirmGenerateBtn').addEventListener('click', generateEmail);
document.getElementById('closeGenerationModal').addEventListener('click', closeGenerationModal);
document.getElementById('cancelGenerateBtn').addEventListener('click', closeGenerationModal);

// Close modal when clicking backdrop
document.getElementById('generationModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeGenerationModal();
    }
});

// Handle Escape key to close modal
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const generationModal = document.getElementById('generationModal');
        if (!generationModal.classList.contains('hidden')) {
            closeGenerationModal();
        }
    }
});

// Custom email event listeners
generationTypeRadios.forEach(radio => {
    radio.addEventListener('change', handleGenerationTypeChange);
});

customEmailInput.addEventListener('input', handleCustomEmailInput);
customEmailInput.addEventListener('keydown', handleCustomEmailKeydown);

// Handle generation type change (Auto/Custom)
function handleGenerationTypeChange(event) {
    generationMode = event.target.value;
    updateGenerationUI();
}

// Update UI based on generation mode
function updateGenerationUI() {
    if (generationMode === 'custom') {
        customEmailSection.classList.remove('hidden');
        generateIcon.className = 'fas fa-edit mr-2';
        updateGenerateButton();
        validateCustomEmail();
    } else {
        customEmailSection.classList.add('hidden');
        emailPreview.classList.add('hidden');
        generateIcon.className = 'fas fa-magic mr-2';
        generateText.textContent = 'Generate Temporary Email';
        generateEmailBtn.disabled = false;
        customEmailFeedback.classList.add('hidden');
    }
}

// Handle custom email input
function handleCustomEmailInput(event) {
    customEmail = event.target.value;
    validateCustomEmail();
    updateEmailPreview();
    updateGenerateButton();
    
    // Debounced availability check
    if (availabilityTimeout) {
        clearTimeout(availabilityTimeout);
    }
    
    if (customEmail.length >= 3 && /^[a-zA-Z0-9._-]+$/.test(customEmail)) {
        availabilityTimeout = setTimeout(() => {
            checkAvailability(customEmail);
        }, 800); // Wait 800ms after user stops typing
    }
}

// Handle Enter key in custom email input
function handleCustomEmailKeydown(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        const confirmBtn = document.getElementById('confirmGenerateBtn');
        if (confirmBtn && !confirmBtn.disabled) {
            generateEmail();
        }
    }
}

// Validate custom email format
function validateCustomEmail() {
    const emailRegex = /^[a-zA-Z0-9._-]{3,30}$/;
    const isValid = customEmail.length === 0 || emailRegex.test(customEmail);
    const isEmpty = customEmail.length === 0;
    const tooShort = customEmail.length > 0 && customEmail.length < 3;
    const tooLong = customEmail.length > 30;
    const invalidChars = customEmail.length > 0 && !emailRegex.test(customEmail) && customEmail.length >= 3 && customEmail.length <= 30;
    
    customEmailFeedback.classList.remove('hidden');
    
    if (isEmpty) {
        customEmailFeedback.innerHTML = '<i class="fas fa-exclamation-triangle text-yellow-500 mr-1"></i>Please enter a custom email username';
        customEmailFeedback.className = 'text-sm mt-1 text-yellow-600';
        return false;
    } else if (tooShort) {
        customEmailFeedback.innerHTML = '<i class="fas fa-times-circle text-red-500 mr-1"></i>Username too short (minimum 3 characters)';
        customEmailFeedback.className = 'text-sm mt-1 text-red-600';
        return false;
    } else if (tooLong) {
        customEmailFeedback.innerHTML = '<i class="fas fa-times-circle text-red-500 mr-1"></i>Username too long (maximum 30 characters)';
        customEmailFeedback.className = 'text-sm mt-1 text-red-600';
        return false;
    } else if (invalidChars) {
        customEmailFeedback.innerHTML = '<i class="fas fa-times-circle text-red-500 mr-1"></i>Invalid characters. Use letters, numbers, dots, hyphens, and underscores only';
        customEmailFeedback.className = 'text-sm mt-1 text-red-600';
        return false;
    } else {
        customEmailFeedback.innerHTML = '<i class="fas fa-check-circle text-green-500 mr-1"></i>Username format is valid';
        customEmailFeedback.className = 'text-sm mt-1 text-green-600';
        return true;
    }
}

// Show validation feedback (for server-side errors and availability)
function showValidationFeedback(message, type, customIcon = null) {
    customEmailFeedback.classList.remove('hidden');
    
    let icon = customIcon;
    if (!icon) {
        if (type === 'error') {
            icon = 'fas fa-times-circle text-red-500';
        } else if (type === 'success') {
            icon = 'fas fa-check-circle text-green-500';
        } else if (type === 'info') {
            icon = 'fas fa-info-circle text-pink-500';
        } else {
            icon = 'fas fa-info-circle text-pink-500';
        }
    }
    
    customEmailFeedback.innerHTML = '<i class="' + icon + ' mr-1"></i>' + message;
    
    if (type === 'error') {
        customEmailFeedback.className = 'text-sm mt-1 text-red-600';
    } else if (type === 'success') {
        customEmailFeedback.className = 'text-sm mt-1 text-green-600';
    } else if (type === 'info') {
        customEmailFeedback.className = 'text-sm mt-1 text-pink-600';
    } else {
        customEmailFeedback.className = 'text-sm mt-1 text-pink-600';
    }
}

// Check username availability with debouncing
async function checkAvailability(username) {
    if (isCheckingAvailability || username.length < 3) return;
    
    try {
        isCheckingAvailability = true;
        
        // Show checking state
        showValidationFeedback('Checking availability...', 'info', 'fas fa-spinner loading');
        
        const response = await fetch('/api/v1/temp-emails/check-availability', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ username: username })
        });
        
        const result = await response.json();
        
        if (result.success) {
            if (result.available) {
                showValidationFeedback('Username available! ✨', 'success');
            } else {
                showValidationFeedback('Username already taken. Please choose another.', 'error');
            }
        } else {
            showValidationFeedback('Error checking availability', 'error');
        }
    } catch (error) {
        console.error('Error checking availability:', error);
        showValidationFeedback('Error checking availability', 'error');
    } finally {
        isCheckingAvailability = false;
    }
}

// Update email preview
function updateEmailPreview() {
    if (generationMode === 'custom' && customEmail.length > 0) {
        previewText.textContent = customEmail + '@revacantik.my.id';
        emailPreview.classList.remove('hidden');
    } else {
        emailPreview.classList.add('hidden');
    }
}

// Update generate button state and text
function updateGenerateButton() {
    const confirmBtn = document.getElementById('confirmGenerateBtn');
    const confirmText = document.getElementById('confirmGenerateText');
    
    if (!confirmBtn || !confirmText) return;
    
    if (generationMode === 'custom') {
        const isValidCustom = validateCustomEmail();
        confirmBtn.disabled = !isValidCustom || customEmail.length === 0;
        
        if (customEmail.length === 0) {
            confirmText.textContent = 'Enter Custom Email';
        } else if (!isValidCustom) {
            confirmText.textContent = 'Fix Email Format';
        } else {
            confirmText.textContent = 'Generate Custom Email';
        }
    } else {
        confirmBtn.disabled = false;
        confirmText.textContent = 'Generate Email';
    }
}

// Open generation modal
function openGenerationModal() {
    document.getElementById('generationModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Focus on custom input if custom mode is selected
    if (generationMode === 'custom') {
        setTimeout(() => {
            const customInput = document.getElementById('customEmailInput');
            if (customInput) customInput.focus();
        }, 100);
    }
}

// Close generation modal
function closeGenerationModal() {
    document.getElementById('generationModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Generate new temporary email
async function generateEmail() {
    const confirmBtn = document.getElementById('confirmGenerateBtn');
    const confirmIcon = document.getElementById('confirmGenerateIcon');
    const confirmText = document.getElementById('confirmGenerateText');
    
    confirmBtn.disabled = true;
    const originalIcon = confirmIcon.className;
    const originalText = confirmText.textContent;
    
    confirmIcon.className = 'fas fa-spinner loading mr-2';
    confirmText.textContent = 'Generating...';
    
    try {
        // Get expiration selection
        const expirationSelect = document.getElementById('expirationSelect');
        const expiresIn = expirationSelect.value;
        
        // Base request body
        let requestBody = {
            expires_in: expiresIn,
            generation_type: generationMode
        };
        
        // Add custom email if selected
        if (generationMode === 'custom' && customEmail) {
            requestBody.custom_username = customEmail;
        }
        
        const response = await fetch('/api/v1/temp-emails/generate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(requestBody)
        });
        
        const result = await response.json();
        
        if (result.success) {
            currentEmail = result.data;
            displayEmail(currentEmail);
            startPolling();
            showNotification('Temporary email generated successfully!', 'success');
            closeGenerationModal(); // Close modal after successful generation
        } else {
            // Handle validation errors
            if (result.errors && result.errors.custom_username) {
                showValidationFeedback(result.errors.custom_username[0], 'error');
            } else {
                throw new Error(result.message || 'Failed to generate email');
            }
        }
    } catch (error) {
        console.error('Error generating email:', error);
        showNotification('Failed to generate email. Please try again.', 'error');
    } finally {
        confirmIcon.className = originalIcon;
        confirmText.textContent = originalText;
        confirmBtn.disabled = false;
    }
}

// Open generation modal
function openGenerationModal() {
    document.getElementById('generationModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Focus on custom input if custom mode is selected
    if (generationMode === 'custom') {
        setTimeout(() => {
            const customInput = document.getElementById('customEmailInput');
            if (customInput) customInput.focus();
        }, 100);
    }
}

// Close generation modal
function closeGenerationModal() {
    document.getElementById('generationModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Initialize UI on page load
function initializeUI() {
    updateGenerationUI();
    
    // Check for preloaded email (direct access)
    if (preloadedEmail && isDirectAccess) {
        currentEmail = preloadedEmail;
        displayEmail(currentEmail);
        startPolling();
        
        // Show notification for direct access
        setTimeout(() => {
            showNotification(`Accessed email: ${currentEmail.email_address}`, 'info');
        }, 500);
    }
    
    // Focus on custom input when custom mode is selected
    if (generationMode === 'custom') {
        setTimeout(() => customEmailInput.focus(), 100);
    }
}

// Call initialization when DOM is loaded
document.addEventListener('DOMContentLoaded', initializeUI);

// Display email information
function displayEmail(emailData) {
    emailAddress.textContent = emailData.email_address;
    expirationTime.textContent = new Date(emailData.expires_at).toLocaleString();
    
    emailSection.classList.remove('hidden');
    emailSection.scrollIntoView({ behavior: 'smooth' });
    
    updateCountdown();
    loadInbox();
    loadStats();
}

// Update countdown timer
function updateCountdown() {
    if (countdownInterval) clearInterval(countdownInterval);
    
    countdownInterval = setInterval(() => {
        if (!currentEmail) return;
        
        const now = new Date();
        const expiry = new Date(currentEmail.expires_at);
        const diff = expiry - now;
        
        if (diff <= 0) {
            timeRemaining.textContent = 'Expired';
            timeRemaining.className = 'text-red-500 font-semibold';
            clearInterval(countdownInterval);
            stopPolling();
            return;
        }
        
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        
        if (days > 0) {
            timeRemaining.textContent = `${days} hari ${hours} jam`;
        } else {
            timeRemaining.textContent = `${hours} jam ${minutes} menit`;
        }
        
        timeRemaining.className = diff < 86400000 ? 'text-red-500 font-semibold pulse-animation' : 'text-green-600'; // 1 day warning
    }, 60000); // Update every minute
}

// Copy email to clipboard
async function copyEmail() {
    try {
        await navigator.clipboard.writeText(currentEmail.email_address);
        showNotification('Email address copied to clipboard!', 'success');
        
        copyEmailBtn.innerHTML = '<i class="fas fa-check mr-1"></i>Copied!';
        setTimeout(() => {
            copyEmailBtn.innerHTML = '<i class="fas fa-copy mr-1"></i>Copy';
        }, 2000);
        
        // Also show shareable URL notification
        const shareableUrl = window.location.origin + '/' + encodeURIComponent(currentEmail.email_address);
        setTimeout(() => {
            showNotification(`Shareable URL: ${shareableUrl}`, 'info');
        }, 1500);
    } catch (error) {
        console.error('Failed to copy:', error);
        showNotification('Failed to copy email address', 'error');
    }
}

// Share URL function
async function shareUrl() {
    if (!currentEmail) return;
    
    const shareableUrl = window.location.origin + '/' + encodeURIComponent(currentEmail.email_address);
    
    try {
        // Try to use Web Share API first (mobile friendly)
        if (navigator.share) {
            await navigator.share({
                title: 'Temporary Email Access',
                text: `Access this temporary email: ${currentEmail.email_address}`,
                url: shareableUrl
            });
            showNotification('Shared successfully!', 'success');
        } else {
            // Fallback: Copy URL to clipboard
            await navigator.clipboard.writeText(shareableUrl);
            showNotification('Shareable URL copied to clipboard!', 'success');
            
            shareUrlBtn.innerHTML = '<i class="fas fa-check mr-1"></i>Copied!';
            setTimeout(() => {
                shareUrlBtn.innerHTML = '<i class="fas fa-share-alt mr-1"></i>Share URL';
            }, 2000);
        }
    } catch (error) {
        console.error('Failed to share:', error);
        showNotification('Failed to share URL', 'error');
    }
}

// Share URL function
async function shareUrl() {
    if (!currentEmail) return;
    
    const shareableUrl = window.location.origin + '/' + encodeURIComponent(currentEmail.email_address);
    
    try {
        // Try to use Web Share API first (mobile friendly)
        if (navigator.share) {
            await navigator.share({
                title: 'Temporary Email Access',
                text: `Access this temporary email: ${currentEmail.email_address}`,
                url: shareableUrl
            });
            showNotification('Shared successfully!', 'success');
        } else {
            // Fallback: Copy URL to clipboard
            await navigator.clipboard.writeText(shareableUrl);
            showNotification('Shareable URL copied to clipboard!', 'success');
            
            shareUrlBtn.innerHTML = '<i class="fas fa-check mr-1"></i>Copied!';
            setTimeout(() => {
                shareUrlBtn.innerHTML = '<i class="fas fa-share-alt mr-1"></i>Share URL';
            }, 2000);
        }
    } catch (error) {
        console.error('Failed to share:', error);
        showNotification('Failed to share URL', 'error');
    }
}

// Load inbox
async function loadInbox() {
    if (!currentEmail) return;
    
    inboxLoading.classList.remove('hidden');
    emptyInbox.classList.add('hidden');
    
    try {
        const response = await fetch(`/api/v1/temp-emails/${currentEmail.id}/inbox`);
        const result = await response.json();
        
        if (result.success) {
            displayEmails(result.data.emails);
            loadStats(); // Refresh stats after loading inbox
        } else {
            throw new Error(result.message || 'Failed to load inbox');
        }
    } catch (error) {
        console.error('Error loading inbox:', error);
        showNotification('Failed to load inbox', 'error');
    } finally {
        inboxLoading.classList.add('hidden');
    }
}

// Display emails in inbox
function displayEmails(emails) {
    emailList.innerHTML = '';
    
    if (emails.length === 0) {
        emptyInbox.classList.remove('hidden');
        return;
    }
    
    emptyInbox.classList.add('hidden');
    
    emails.forEach(email => {
        const emailElement = createEmailElement(email);
        emailList.appendChild(emailElement);
    });
}

// Create email list item element
function createEmailElement(email) {
    const div = document.createElement('div');
    div.className = `email-card border rounded-xl p-4 cursor-pointer transition-all ${email.is_read ? 'bg-gray-50 border-gray-100' : 'bg-white border-pink-200'}`;
    div.onclick = () => openEmailModal(email.id);
    
    div.innerHTML = `
        <div class="flex items-start justify-between gap-3">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-1.5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0" style="background:linear-gradient(135deg,#db2777,#ec4899);">
                        ${(email.sender_name || email.sender_email || '?').charAt(0).toUpperCase()}
                    </div>
                    <span class="font-semibold text-gray-800 text-sm truncate">${email.sender_name || email.sender_email}</span>
                    ${!email.is_read ? '<span class="w-2 h-2 rounded-full flex-shrink-0" style="background:#ec4899;"></span>' : ''}
                </div>
                <h4 class="text-sm font-bold mb-1 truncate" style="color:#1f2937;">${email.subject || '(No Subject)'}</h4>
                <p class="text-gray-500 text-xs mb-2 line-clamp-1">${email.preview_text || 'No preview available'}</p>
                <div class="text-xs text-gray-400 flex items-center gap-2">
                    <span><i class="fas fa-clock mr-1"></i>${formatTime(email.received_at)}</span>
                    <span class="text-gray-300">•</span>
                    <span class="truncate">${email.sender_email}</span>
                </div>
            </div>
            <div class="flex flex-col items-end gap-2 flex-shrink-0">
                ${!email.is_read ? '<span class="px-2 py-0.5 text-xs font-semibold rounded-full" style="background:#fce7f3;color:#be185d;">New</span>' : ''}
                <button class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-300 hover:text-rose-500 hover:bg-rose-50 transition-all" onclick="event.stopPropagation(); deleteEmailMessage(${email.id})">
                    <i class="fas fa-trash text-xs"></i>
                </button>
            </div>
        </div>
    `;
    
    return div;
}

// Open email modal
async function openEmailModal(emailId) {
    if (!currentEmail) return;
    
    try {
        const response = await fetch(`/api/v1/temp-emails/${currentEmail.id}/email/${emailId}`);
        const result = await response.json();
        
        if (result.success) {
            displayEmailModal(result.data);
        } else {
            throw new Error(result.message || 'Failed to load email');
        }
    } catch (error) {
        console.error('Error loading email:', error);
        showNotification('Failed to load email', 'error');
    }
}

// Display email in modal
function displayEmailModal(email) {
    const emailContent = document.getElementById('emailContent');
    
    emailContent.innerHTML = `
        <div class="pb-4 mb-5" style="border-bottom:1.5px solid #fbcfe8;">
            <h2 class="text-xl font-bold mb-3" style="color:#831843;">${email.subject || '(No Subject)'}</h2>
            <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm">
                <div class="flex items-center gap-1.5"><i class="fas fa-user text-pink-400 text-xs"></i><span class="text-gray-500">From:</span> <span class="font-medium text-gray-700">${email.sender_name || email.sender_email} &lt;${email.sender_email}&gt;</span></div>
                <div class="flex items-center gap-1.5"><i class="fas fa-envelope text-pink-400 text-xs"></i><span class="text-gray-500">To:</span> <span class="font-medium text-gray-700">${currentEmail.email_address}</span></div>
                <div class="flex items-center gap-1.5"><i class="fas fa-clock text-pink-400 text-xs"></i><span class="text-gray-500">Received:</span> <span class="font-medium text-gray-700">${email.received_at}</span></div>
            </div>
        </div>
        
        <div class="space-y-4">
            ${email.body_html ? `
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;"><i class="fas fa-code mr-1"></i>HTML Content</h4>
                    <div class="rounded-xl overflow-hidden" style="border:1.5px solid #fbcfe8;">
                        <iframe srcdoc="${email.body_html.replace(/"/g, '&quot;')}" class="w-full h-96 border-0"></iframe>
                    </div>
                </div>
            ` : ''}
            
            ${email.body_text ? `
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;"><i class="fas fa-align-left mr-1"></i>Text Content</h4>
                    <div class="rounded-xl p-4" style="background:#fdf2f8;border:1.5px solid #fbcfe8;">
                        <pre class="whitespace-pre-wrap text-sm text-gray-700 font-mono">${email.body_text}</pre>
                    </div>
                </div>
            ` : ''}
            
            ${!email.body_html && !email.body_text ? `
                <div class="text-center py-12 text-gray-400">
                    <i class="fas fa-file-alt text-4xl mb-3 block" style="color:#f9a8d4;"></i>
                    <p>Konten tidak tersedia</p>
                </div>
            ` : ''}
        </div>
    `;
    
    document.getElementById('emailModal').classList.remove('hidden');
}

// Close email modal
document.getElementById('closeEmailModal').addEventListener('click', () => {
    document.getElementById('emailModal').classList.add('hidden');
});

// Close modal when clicking outside
document.getElementById('emailModal').addEventListener('click', (e) => {
    if (e.target.id === 'emailModal') {
        document.getElementById('emailModal').classList.add('hidden');
    }
});

// Refresh inbox
function refreshInbox() {
    refreshInboxBtn.innerHTML = '<i class="fas fa-spinner loading mr-1"></i>Refreshing...';
    refreshInboxBtn.disabled = true;
    
    loadInbox().finally(() => {
        refreshInboxBtn.innerHTML = '<i class="fas fa-sync-alt mr-1"></i>Refresh';
        refreshInboxBtn.disabled = false;
    });
}

// Delete email
async function deleteEmail() {
    if (!currentEmail) return;
    
    if (!confirm('Are you sure you want to delete this temporary email? All received emails will be permanently deleted.')) {
        return;
    }
    
    deleteEmailBtn.disabled = true;
    deleteEmailBtn.innerHTML = '<i class="fas fa-spinner loading mr-1"></i>Deleting...';
    
    try {
        const response = await fetch(`/api/v1/temp-emails/${currentEmail.id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            stopPolling();
            clearInterval(countdownInterval);
            currentEmail = null;
            emailSection.classList.add('hidden');
            showNotification('Temporary email deleted successfully', 'success');
        } else {
            throw new Error(result.message || 'Failed to delete email');
        }
    } catch (error) {
        console.error('Error deleting email:', error);
        showNotification('Failed to delete email', 'error');
    } finally {
        deleteEmailBtn.disabled = false;
        deleteEmailBtn.innerHTML = '<i class="fas fa-trash mr-1"></i>Delete';
    }
}

// Extend expiration time
async function extendTime() {
    if (!currentEmail) return;
    
    const months = document.getElementById('extendMonths').value;
    
    extendTimeBtn.disabled = true;
    extendTimeBtn.innerHTML = '<i class="fas fa-spinner loading mr-1"></i>Extending...';
    
    try {
        const response = await fetch(`/api/v1/temp-emails/${currentEmail.id}/extend`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ months: parseInt(months) })
        });
        
        const result = await response.json();
        
        if (result.success) {
            currentEmail.expires_at = result.data.expires_at;
            expirationTime.textContent = new Date(currentEmail.expires_at).toLocaleString();
            updateCountdown();
            const monthText = months == 1 ? 'bulan' : months == 6 ? 'bulan' : 'tahun';
            const monthValue = months == 12 ? '1' : months;
            showNotification(`Waktu expired diperpanjang ${monthValue} ${monthText}`, 'success');
        } else {
            throw new Error(result.message || 'Failed to extend time');
        }
    } catch (error) {
        console.error('Error extending time:', error);
        showNotification('Failed to extend expiration time', 'error');
    } finally {
        extendTimeBtn.disabled = false;
        extendTimeBtn.innerHTML = '<i class="fas fa-clock mr-1"></i>Extend Time';
    }
}

// Simulate email (for testing)
async function simulateEmail() {
    if (!currentEmail) return;
    
    simulateEmailBtn.disabled = true;
    simulateEmailBtn.innerHTML = '<i class="fas fa-spinner loading mr-1"></i>Simulating...';
    
    const messageTypes = ['welcome', 'verification', 'promotional', 'newsletter', 'support'];
    const randomType = messageTypes[Math.floor(Math.random() * messageTypes.length)];
    
    try {
        const response = await fetch('/api/v1/simulate/email', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                temp_email_id: currentEmail.id,
                message_type: randomType
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            loadInbox();
            showNotification('Test email simulated successfully!', 'success');
        } else {
            throw new Error(result.message || 'Failed to simulate email');
        }
    } catch (error) {
        console.error('Error simulating email:', error);
        showNotification('Failed to simulate email', 'error');
    } finally {
        simulateEmailBtn.disabled = false;
        simulateEmailBtn.innerHTML = '<i class="fas fa-flask mr-1"></i>Simulate Email (Test)';
    }
}

// Load email statistics
async function loadStats() {
    if (!currentEmail) return;
    
    try {
        const response = await fetch(`/api/v1/temp-emails/${currentEmail.id}/stats`);
        const result = await response.json();
        
        if (result.success) {
            document.getElementById('totalEmails').textContent = result.data.total_emails;
            document.getElementById('unreadEmails').textContent = result.data.unread_emails;
            document.getElementById('readEmails').textContent = result.data.read_emails;
        }
    } catch (error) {
        console.error('Error loading stats:', error);
    }
}

// Start polling for new emails
function startPolling() {
    stopPolling(); // Clear any existing interval
    
    pollingInterval = setInterval(() => {
        if (currentEmail) {
            checkNewEmails();
        }
    }, 10000); // Poll every 10 seconds
}

// Stop polling
function stopPolling() {
    if (pollingInterval) {
        clearInterval(pollingInterval);
        pollingInterval = null;
    }
}

// Check for new emails
async function checkNewEmails() {
    if (!currentEmail) return;
    
    try {
        const response = await fetch(`/api/v1/temp-emails/${currentEmail.id}/check-new`);
        const result = await response.json();
        
        if (result.success && result.data.new_emails_count > 0) {
            loadInbox();
            showNotification(`${result.data.new_emails_count} new email(s) received!`, 'success');
        }
    } catch (error) {
        console.error('Error checking new emails:', error);
    }
}

// Clean up when page is unloaded
window.addEventListener('beforeunload', () => {
    stopPolling();
    if (countdownInterval) clearInterval(countdownInterval);
    if (statsInterval) clearInterval(statsInterval);
});

// ═══════════════════════════════════════════════════
// REAL-TIME GLOBAL STATISTICS
// ═══════════════════════════════════════════════════

let statsInterval = null;

function animateCount(el, targetValue) {
    const start = parseInt(el.textContent.replace(/\D/g, '')) || 0;
    const end = targetValue;
    if (start === end) return;
    const duration = 600;
    const steps = 30;
    const increment = (end - start) / steps;
    let current = start;
    let step = 0;
    const timer = setInterval(() => {
        step++;
        current += increment;
        el.textContent = Math.round(step < steps ? current : end).toLocaleString();
        if (step >= steps) clearInterval(timer);
    }, duration / steps);
}

async function fetchGlobalStats() {
    const refreshIcon = document.getElementById('statsRefreshIcon');
    const timestampEl = document.getElementById('statsTimestamp');

    if (refreshIcon) refreshIcon.classList.add('fa-spin');

    try {
        const res = await fetch('/api/v1/stats', {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken }
        });
        if (!res.ok) throw new Error('Network error');
        const json = await res.json();
        if (!json.success) throw new Error('API error');

        const d = json.data;

        // Update counters with animation
        const statMap = {
            'stat-active-emails':    d.active_emails,
            'stat-generated-today':  d.generated_today,
            'stat-received-today':   d.emails_received_today,
            'stat-total-generated':  d.total_generated,
        };

        for (const [id, val] of Object.entries(statMap)) {
            const el = document.getElementById(id);
            if (!el) continue;
            // Remove spinner on first load
            if (el.querySelector('.fa-spinner')) el.textContent = '0';
            animateCount(el, val);
        }

        // Expiring soon banner
        const bannerExpiring = document.getElementById('bannerExpiringSoon');
        const bannerExpiringCount = document.getElementById('bannerExpiringSoonCount');
        if (bannerExpiring && bannerExpiringCount) {
            bannerExpiringCount.textContent = d.expiring_soon.toLocaleString();
            if (d.expiring_soon > 0) {
                bannerExpiring.classList.remove('hidden');
                bannerExpiring.classList.add('flex');
            } else {
                bannerExpiring.classList.add('hidden');
                bannerExpiring.classList.remove('flex');
            }
        }

        // Unread banner — dihapus

        // Timestamp
        if (timestampEl) {
            const t = new Date(d.timestamp);
            timestampEl.textContent = 'Diperbarui jam ' + t.toLocaleTimeString('id-ID');
        }

    } catch (err) {
        if (timestampEl) timestampEl.textContent = 'Waduh, gagal update 😅';
        console.warn('Stats fetch error:', err);
    } finally {
        if (refreshIcon) refreshIcon.classList.remove('fa-spin');
    }
}

// Initial fetch + poll every 15 seconds
fetchGlobalStats();
statsInterval = setInterval(fetchGlobalStats, 15000);
</script>
@endpush