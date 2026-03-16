@extends('layouts.app')

@section('title', 'Dokumentasi API - REVA Mail')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Navigation Header -->
    <div class="mb-8">
        <a href="{{ route('temp-email.index') }}" class="inline-flex items-center text-sm font-medium transition-colors" style="color:#ec4899;">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Generator REVA Mail
        </a>
    </div>

    <!-- Header -->
    <div class="text-center mb-12">
        <div class="inline-flex items-center rounded-full px-4 py-1 text-xs font-bold uppercase tracking-widest mb-5 border" style="background:#fce7f3;color:#be185d;border-color:#fbcfe8;">
            <i class="fas fa-code mr-1.5"></i>REST API
        </div>
        <h1 class="text-4xl font-extrabold mb-4 tracking-tight" style="color:#831843;">
            REVA Mail <span style="background:linear-gradient(135deg,#db2777,#ec4899);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">API Docs</span>
        </h1>
        <p class="text-lg text-gray-500 max-w-2xl mx-auto leading-relaxed">
            Referensi API lengkap untuk mengintegrasikan REVA Mail ke aplikasi Anda.
            Semua endpoint mengembalikan JSON dan mendukung method HTTP standar.
        </p>
        <div class="mt-6 flex justify-center flex-wrap gap-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold" style="background:#d1fae5;color:#065f46;">
                <i class="fas fa-check-circle mr-1"></i>REST API
            </span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold" style="background:#fce7f3;color:#be185d;">
                <i class="fas fa-shield-alt mr-1"></i>CSRF Protected
            </span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold" style="background:#fdf4ff;color:#7e22ce;">
                <i class="fas fa-bolt mr-1"></i>Real-time
            </span>
        </div>
    </div>

    <!-- Quick Navigation -->
    <nav class="bg-white rounded-2xl shadow-md p-6 mb-8" style="border:1.5px solid #fce7f3;">
        <h2 class="text-sm font-bold uppercase tracking-widest mb-4" style="color:#be185d;">Navigasi Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
            <a href="#authentication" class="flex items-center p-3 rounded-xl hover:shadow-md transition-all" style="background:#fff7ed;">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background:#fed7aa;"><i class="fas fa-key text-orange-600 text-sm"></i></div>
                <span class="font-semibold text-gray-700 text-sm">Otentikasi</span>
            </a>
            <a href="#email-management" class="flex items-center p-3 rounded-xl hover:shadow-md transition-all" style="background:#fdf2f8;">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background:#fbcfe8;"><i class="fas fa-envelope text-pink-600 text-sm"></i></div>
                <span class="font-semibold text-gray-700 text-sm">Manajemen Email</span>
            </a>
            <a href="#inbox-operations" class="flex items-center p-3 rounded-xl hover:shadow-md transition-all" style="background:#f0fdf4;">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background:#bbf7d0;"><i class="fas fa-inbox text-green-600 text-sm"></i></div>
                <span class="font-semibold text-gray-700 text-sm">Operasi Inbox</span>
            </a>
            <a href="#statistics" class="flex items-center p-3 rounded-xl hover:shadow-md transition-all" style="background:#f0f9ff;">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background:#bae6fd;"><i class="fas fa-chart-bar text-blue-600 text-sm"></i></div>
                <span class="font-semibold text-gray-700 text-sm">Statistik Live</span>
            </a>
            <a href="#testing-simulation" class="flex items-center p-3 rounded-xl hover:shadow-md transition-all" style="background:#fdf4ff;">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background:#e9d5ff;"><i class="fas fa-flask text-purple-600 text-sm"></i></div>
                <span class="font-semibold text-gray-700 text-sm">Pengujian & Simulasi</span>
            </a>
        </div>
    </nav>

    <!-- Base URL -->
    <div class="rounded-2xl p-6 mb-8" style="background:linear-gradient(135deg,#fdf2f8,#fce7f3);border:1.5px solid #fbcfe8;">
        <h2 class="text-sm font-bold uppercase tracking-widest mb-3" style="color:#be185d;">
            <i class="fas fa-globe mr-2"></i>URL Dasar
        </h2>
        <div class="rounded-xl p-3 font-mono text-sm font-bold" style="background:#831843;color:#f9a8d4;">
            https://revacantik.my.id/api/v1
        </div>
        <p class="text-sm mt-2" style="color:#be185d;">
            Semua permintaan API harus dibuat ke endpoint dengan prefiks URL dasar ini.
        </p>
    </div>

    <!-- Additional Resources -->
    <div class="rounded-2xl p-6 mb-8" style="background:#f0fdf4;border:1.5px solid #bbf7d0;">
        <h2 class="text-sm font-bold uppercase tracking-widest mb-4" style="color:#065f46;">
            <i class="fas fa-external-link-alt mr-2"></i>Sumber Daya Tambahan
        </h2>
        <div class="flex flex-wrap gap-3">
            <a href="/API_README.md" target="_blank" class="inline-flex items-center bg-green-100 hover:bg-green-200 text-green-800 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-file-alt mr-2"></i>Panduan README API
            </a>
            <a href="/openapi.yaml" target="_blank" class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors" style="background:#fce7f3;color:#be185d;">
                <i class="fas fa-code-branch mr-2"></i>Spesifikasi OpenAPI 3.0
            </a>
            <a href="https://swagger.io/tools/swagger-ui/" target="_blank" class="inline-flex items-center bg-purple-100 hover:bg-purple-200 text-purple-800 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-tools mr-2"></i>Alat Swagger UI
            </a>
            <a href="https://www.postman.com/" target="_blank" class="inline-flex items-center bg-orange-100 hover:bg-orange-200 text-orange-800 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-paper-plane mr-2"></i>Uji dengan Postman
            </a>
            <a href="/REVA-Mail-API.postman_collection.json" download class="inline-flex items-center bg-indigo-100 hover:bg-indigo-200 text-indigo-800 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-download mr-2"></i>Koleksi Postman
            </a>
        </div>
    </div>

    <!-- Authentication Section -->
    <section id="authentication" class="bg-white rounded-2xl shadow-md p-6 mb-8" style="border:1.5px solid #fce7f3;">
        <h2 class="text-xl font-bold mb-4" style="color:#831843;">
            <i class="fas fa-key mr-2" style="color:#f59e0b;"></i>Otentikasi
        </h2>
        <div class="prose max-w-none">
            <p class="text-gray-600 mb-4">
                API ini menggunakan proteksi CSRF Laravel. Sertakan token CSRF dalam permintaan Anda saat melakukan panggilan dari aplikasi web.
            </p>
            <div class="rounded-xl p-4" style="background:#fdf2f8;border:1.5px solid #fbcfe8;">
                <h3 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Header yang Diperlukan:</h3>
                <div class="rounded-lg p-3 font-mono text-sm" style="background:#1f2937;color:#a7f3d0;">
Content-Type: application/json<br>
X-CSRF-TOKEN: {{ csrf_token() }}<br>
Accept: application/json
                </div>
            </div>
        </div>
    </section>

    <!-- Email Management Section -->
    <section id="email-management" class="bg-white rounded-2xl shadow-md p-6 mb-8" style="border:1.5px solid #fce7f3;">
        <h2 class="text-xl font-bold mb-6" style="color:#831843;">
            <i class="fas fa-envelope mr-2" style="color:#ec4899;"></i>Manajemen Email
        </h2>

        <!-- Generate Email -->
        <div class="pb-6 mb-6" style="border-bottom:1.5px solid #fce7f3;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold" style="color:#9d174d;">Buat Email</h3>
                <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded">POST</span>
            </div>
            <div class="rounded-xl p-4 mb-4" style="background:#fdf2f8;border:1.5px solid #fbcfe8;">
                <code class="text-gray-800 font-mono">/temp-emails/generate</code>
            </div>
            <p class="text-gray-700 mb-4">Membuat alamat email baru dengan opsi yang dapat disesuaikan termasuk pembuatan otomatis atau username khusus, dan periode kedaluwarsa yang fleksibel.</p>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Request Body:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "generation_type": "auto|custom", // optional, default: "auto"
  "custom_username": "myemail123",  // required if generation_type is "custom"
  "expires_in": "1_month|6_months|1_year" // optional, default: "1_month"
}
                    </div>
                    <div class="mt-3 space-y-2 text-sm text-gray-600">
                        <p><strong>generation_type:</strong> Choose "auto" for random email or "custom" for your own username</p>
                        <p><strong>custom_username:</strong> 3-20 characters, letters, numbers, dots, hyphens, underscores only</p>
                        <p><strong>expires_in:</strong> Duration until email expires and becomes inactive</p>
                    </div>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Response:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "success": true,
  "data": {
    "id": 1,
    "email_address": "myemail123@revacantik.my.id",
    "domain": "revacantik.my.id",
    "expires_at": "2026-04-14T08:30:45Z",
    "expires_in_days": 31,
    "created_at": "2026-03-14T08:30:45Z",
    "is_active": true,
    "generation_type": "custom"
  }
}
                    </div>
                    <div class="mt-3 text-sm text-gray-600">
                        <p><strong>Error Response (Username taken):</strong></p>
                        <div class="bg-red-50 border border-red-200 rounded p-2 mt-1">
                            <code class="text-red-700 text-xs">{
  "success": false,
  "message": "Username already taken",
  "errors": {
    "custom_username": ["This username is already taken"]
  }
}</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Check Username Availability -->
        <div class="pb-6 mb-6" style="border-bottom:1.5px solid #fce7f3;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold" style="color:#9d174d;">Periksa Ketersediaan Username</h3>
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded">POST</span>
            </div>
            <div class="rounded-xl p-4 mb-4" style="background:#fdf2f8;border:1.5px solid #fbcfe8;">
                <code class="text-gray-800 font-mono">/temp-emails/check-availability</code>
            </div>
            <p class="text-gray-700 mb-4">Periksa apakah username khusus tersedia sebelum membuat email. Berguna untuk validasi real-time.</p>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Request Body:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "username": "myemail123"  // 3-20 chars, letters, numbers, dots, hyphens, underscores
}
                    </div>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Response:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "success": true,
  "available": true,
  "username": "myemail123",
  "email_address": "myemail123@revacantik.my.id"
}
                    </div>
                    <div class="mt-3 text-sm text-gray-600">
                        <p><strong>If username is taken:</strong> <code>"available": false</code></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Email -->
        <div class="pb-6 mb-6" style="border-bottom:1.5px solid #fce7f3;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold" style="color:#9d174d;">Hapus Email</h3>
                <span class="bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded">DELETE</span>
            </div>
            <div class="rounded-xl p-4 mb-4" style="background:#fdf2f8;border:1.5px solid #fbcfe8;">
                <code class="text-gray-800 font-mono">/temp-emails/{emailId}</code>
            </div>
            <p class="text-gray-700 mb-4">Menghapus secara permanen sebuah email dan semua pesan yang diterima.</p>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">URL Parameters:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
emailId: integer (required)
// The ID of the temporary email
                    </div>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Response:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "success": true,
  "message": "Email deleted successfully"
}
                    </div>
                </div>
            </div>
        </div>

        <!-- Extend Expiration -->
        <div class="pb-6 mb-6" style="border-bottom:1.5px solid #fce7f3;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold" style="color:#9d174d;">Perpanjang Kedaluwarsa Email</h3>
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded">PUT</span>
            </div>
            <div class="rounded-xl p-4 mb-4" style="background:#fdf2f8;border:1.5px solid #fbcfe8;">
                <code class="text-gray-800 font-mono">/temp-emails/{emailId}/extend</code>
            </div>
            <p class="text-gray-700 mb-4">Memperpanjang waktu kedaluwarsa email. Opsi yang tersedia: 1 bulan, 6 bulan, 1 tahun.</p>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Request Body:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "extension_period": "1_month"
  // Options: "1_month", "6_months", "1_year"
}
                    </div>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Response:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "success": true,
  "message": "Email expiration extended by 1 month",
  "data": {
    "new_expires_at": "2026-05-14T08:30:45.000000Z",
    "extended_by": "1 month"
  }
}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Inbox Operations Section -->
    <section id="inbox-operations" class="bg-white rounded-2xl shadow-md p-6 mb-8" style="border:1.5px solid #fce7f3;">
        <h2 class="text-xl font-bold mb-6" style="color:#831843;">
            <i class="fas fa-inbox mr-3" style="color:#10b981;"></i>Operasi Inbox
        </h2>

        <!-- Get Inbox -->
        <div class="pb-6 mb-6" style="border-bottom:1.5px solid #fce7f3;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold" style="color:#9d174d;">Ambil Pesan Inbox</h3>
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded">GET</span>
            </div>
            <div class="rounded-xl p-4 mb-4" style="background:#fdf2f8;border:1.5px solid #fbcfe8;">
                <code class="text-gray-800 font-mono">/temp-emails/{emailId}/inbox</code>
            </div>
            <p class="text-gray-700 mb-4">Mengambil semua email yang diterima untuk alamat email yang ditentukan.</p>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">URL Parameters:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
emailId: integer (required)
// The ID of the temporary email
                    </div>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Response:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "success": true,
  "data": [
    {
      "id": 1,
      "from_email": "noreply@example.com",
      "sender_name": "Example Service",
      "subject": "Welcome!",
      "body": "Thank you for signing up...",
      "verification_code": "123456",
      "link": "https://example.com/verify",
      "received_at": "2026-03-14T08:35:20.000000Z",
      "is_read": false
    }
  ]
}
                    </div>
                </div>
            </div>
        </div>

        <!-- Get Specific Email -->
        <div class="pb-6 mb-6" style="border-bottom:1.5px solid #fce7f3;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold" style="color:#9d174d;">Ambil Email Spesifik</h3>
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded">GET</span>
            </div>
            <div class="rounded-xl p-4 mb-4" style="background:#fdf2f8;border:1.5px solid #fbcfe8;">
                <code class="text-gray-800 font-mono">/temp-emails/{emailId}/email/{messageId}</code>
            </div>
            <p class="text-gray-700 mb-4">Mengambil detail dari pesan email spesifik dan menandainya sebagai sudah dibaca.</p>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">URL Parameters:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
emailId: integer (required)
messageId: integer (required)
// IDs of email and message
                    </div>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Response:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "success": true,
  "data": {
    "id": 1,
    "from_email": "noreply@example.com",
    "sender_name": "Example Service",
    "subject": "Welcome!",
    "body": "Thank you for signing up...",
    "verification_code": "123456",
    "link": "https://example.com/verify",
    "received_at": "2026-03-14T08:35:20.000000Z",
    "is_read": true
  }
}
                    </div>
                </div>
            </div>
        </div>

        <!-- Check New Emails -->
        <div class="pb-6 mb-6" style="border-bottom:1.5px solid #fce7f3;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold" style="color:#9d174d;">Periksa Email Baru</h3>
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded">GET</span>
            </div>
            <div class="rounded-xl p-4 mb-4" style="background:#fdf2f8;border:1.5px solid #fbcfe8;">
                <code class="text-gray-800 font-mono">/temp-emails/{emailId}/check-new</code>
            </div>
            <p class="text-gray-700 mb-4">Memeriksa email baru yang belum dibaca. Mengembalikan jumlah dan pesan terbaru.</p>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Response:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "success": true,
  "data": {
    "new_emails_count": 2,
    "total_emails": 5,
    "has_new": true,
    "latest_emails": [
      {
        "id": 5,
        "subject": "New Message",
        "from_email": "test@example.com",
        "received_at": "2026-03-14T09:00:00.000000Z"
      }
    ]
  }
}
                    </div>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Usage Notes:</h4>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-sm">
                        <p class="text-yellow-800">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Perfect for real-time polling to check for new emails without loading the entire inbox.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Get Stats -->
        <div class="pb-6 mb-6" style="border-bottom:1.5px solid #fce7f3;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold" style="color:#9d174d;">Get Email Statistics</h3>
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded">GET</span>
            </div>
            <div class="rounded-xl p-4 mb-4" style="background:#fdf2f8;border:1.5px solid #fbcfe8;">
                <code class="text-gray-800 font-mono">/temp-emails/{emailId}/stats</code>
            </div>
            <p class="text-gray-700 mb-4">Returns statistics and details about the email including remaining time.</p>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Response:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "success": true,
  "data": {
    "total_emails": 3,
    "unread_emails": 1,
    "read_emails": 2,
    "expires_at": "2026-04-14T08:30:45.000000Z",
    "time_remaining": {
      "days": 31,
      "hours": 5,
      "minutes": 45
    },
    "is_active": true
  }
}
                    </div>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Use Cases:</h4>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p><i class="fas fa-check text-green-500 mr-2"></i>Dashboard widgets</p>
                        <p><i class="fas fa-check text-green-500 mr-2"></i>Email counters</p>
                        <p><i class="fas fa-check text-green-500 mr-2"></i>Expiration warnings</p>
                        <p><i class="fas fa-check text-green-500 mr-2"></i>User notifications</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section id="statistics" class="bg-white rounded-2xl shadow-md p-6 mb-8" style="border:1.5px solid #fce7f3;">
        <h2 class="text-xl font-bold mb-6" style="color:#831843;">
            <i class="fas fa-chart-bar mr-3" style="color:#2563eb;"></i>Statistik Live Platform
        </h2>

        <!-- Live Statistics -->
        <div class="pb-6 mb-6" style="border-bottom:1.5px solid #fce7f3;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold" style="color:#9d174d;">Statistik Real-Time</h3>
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded">GET</span>
            </div>
            <div class="rounded-xl p-4 mb-4" style="background:#fdf2f8;border:1.5px solid #fbcfe8;">
                <code class="text-gray-800 font-mono">/stats</code>
            </div>
            <p class="text-gray-700 mb-4">Mengambil statistik platform secara real-time termasuk jumlah email aktif, email dibuat hari ini, email masuk hari ini, dan total email sepanjang masa. Perfect untuk dashboard dengan auto-refresh.</p>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Fitur Statistik:</h4>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p><i class="fas fa-fire text-red-500 mr-2"></i><strong>Lagi Aktif:</strong> Email yang sedang aktif dan belum expired</p>
                        <p><i class="fas fa-sparkles text-yellow-500 mr-2"></i><strong>Dibuat Hari Ini:</strong> Email baru yang dibuat hari ini</p>
                        <p><i class="fas fa-envelope text-blue-500 mr-2"></i><strong>Masuk Hari Ini:</strong> Email yang diterima hari ini</p>
                        <p><i class="fas fa-trophy text-purple-500 mr-2"></i><strong>Total Sepanjang Masa:</strong> Total email yang pernah dibuat</p>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Header CSRF:</h4>
                        <div class="bg-gray-800 text-yellow-400 p-3 rounded-lg text-xs font-mono">
X-CSRF-TOKEN: {{ csrf_token() }}
                        </div>
                    </div>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Response Success:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "success": true,
  "data": {
    "stats": [
      {
        "label": "Lagi Aktif",
        "emoji": "🔥",
        "value": 29,
        "description": "Email yang sedang aktif dan belum expired"
      },
      {
        "label": "Dibuat Hari Ini",
        "emoji": "✨",
        "value": 7,
        "description": "Email baru yang dibuat hari ini"
      },
      {
        "label": "Masuk Hari Ini",
        "emoji": "📬",
        "value": 2,
        "description": "Email yang diterima hari ini"
      },
      {
        "label": "Total Sepanjang Masa",
        "emoji": "🏆",
        "value": 29,
        "description": "Total email yang pernah dibuat"
      }
    ],
    "updated_at": {
      "time": "14.07.43",
      "formatted": "Diperbarui jam 14.07.43",
      "full_datetime": "2026-03-16 14:07:43",
      "iso": "2026-03-16T14:07:43.000Z"
    },
    "server_info": {
      "timezone": "UTC",
      "date": "16 Mar 2026",
      "day_name": "Sunday"
    }
  }
}
                    </div>
                </div>
            </div>

            <div class="mt-6 p-4 rounded-xl" style="background:#f0f9ff;border:1.5px solid #bae6fd;">
                <h4 class="text-sm font-bold mb-3" style="color:#1e40af;">
                    <i class="fas fa-lightbulb mr-2"></i>Kegunaan Statistik Live:
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                    <div class="space-y-1">
                        <p><i class="fas fa-check text-blue-500 mr-2"></i>Dashboard real-time</p>
                        <p><i class="fas fa-check text-blue-500 mr-2"></i>Monitoring platform</p>
                        <p><i class="fas fa-check text-blue-500 mr-2"></i>Analytics integration</p>
                    </div>
                    <div class="space-y-1">
                        <p><i class="fas fa-check text-blue-500 mr-2"></i>Auto-refresh support</p>
                        <p><i class="fas fa-check text-blue-500 mr-2"></i>Mobile-friendly response</p>
                        <p><i class="fas fa-check text-blue-500 mr-2"></i>Timezone aware</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testing & Simulation Section -->
    <section id="testing-simulation" class="bg-white rounded-2xl shadow-md p-6 mb-8" style="border:1.5px solid #fce7f3;">
        <h2 class="text-xl font-bold mb-6" style="color:#831843;">
            <i class="fas fa-flask mr-3" style="color:#8b5cf6;"></i>Pengujian & Simulasi
        </h2>

        <!-- Simulate Email -->
        <div class="pb-6 mb-6" style="border-bottom:1.5px solid #fce7f3;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold" style="color:#9d174d;">Simulasi Email Masuk</h3>
                <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded">POST</span>
            </div>
            <div class="rounded-xl p-4 mb-4" style="background:#fdf2f8;border:1.5px solid #fbcfe8;">
                <code class="text-gray-800 font-mono">/simulate/email</code>
            </div>
            <p class="text-gray-700 mb-4">Mensimulasikan penerimaan email untuk tujuan pengujian. Sempurna untuk skenario pengembangan dan demo.</p>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Request Body:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "temp_email_id": 1,
  "from_email": "test@example.com",
  "sender_name": "Test Sender",
  "subject": "Test Email",
  "body": "This is a test message",
  "verification_code": "123456",
  "link": "https://example.com/verify"
}
                    </div>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Response:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "success": true,
  "message": "Email simulated successfully",
  "data": {
    "id": 1,
    "from_email": "test@example.com",
    "subject": "Test Email",
    "received_at": "2026-03-14T08:35:20.000000Z"
  }
}
                    </div>
                </div>
            </div>
        </div>

        <!-- Receive Email (Server Integration) -->
        <div class="pb-6 mb-6" style="border-bottom:1.5px solid #fce7f3;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold" style="color:#9d174d;">Receive Email (Server Integration)</h3>
                <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded">POST</span>
            </div>
            <div class="rounded-xl p-4 mb-4" style="background:#fdf2f8;border:1.5px solid #fbcfe8;">
                <code class="text-gray-800 font-mono">/receive/email</code>
            </div>
            <p class="text-gray-700 mb-4">Endpoint for email server integration. Used by mail servers to deliver emails to temporary addresses.</p>
            
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-4">
                <div class="flex">
                    <i class="fas fa-exclamation-triangle text-amber-500 mt-1 mr-2"></i>
                    <div class="text-amber-800 text-sm">
                        <p class="font-semibold">Server Integration Only</p>
                        <p>This endpoint is designed for mail server integration and requires proper email server configuration.</p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Request Body:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "to_email": "abc123@revacantik.my.id",
  "from_email": "sender@example.com",
  "sender_name": "Sender Name",
  "subject": "Email Subject",
  "body": "Email body content",
  "verification_code": "123456",
  "link": "https://example.com/link"
}
                    </div>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Response:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "success": true,
  "message": "Email received successfully",
  "data": {
    "message_id": 1,
    "temp_email_id": 1,
    "received_at": "2026-03-14T08:35:20.000000Z"
  }
}
                    </div>
                </div>
            </div>
        </div>

        <!-- Bulk Receive Emails -->
        <div class="pb-6 mb-6" style="border-bottom:1.5px solid #fce7f3;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold" style="color:#9d174d;">Bulk Receive Emails</h3>
                <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded">POST</span>
            </div>
            <div class="rounded-xl p-4 mb-4" style="background:#fdf2f8;border:1.5px solid #fbcfe8;">
                <code class="text-gray-800 font-mono">/receive/bulk-emails</code>
            </div>
            <p class="text-gray-700 mb-4">Process multiple emails in a single request. Useful for bulk email processing.</p>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Request Body:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "emails": [
    {
      "to_email": "abc123@revacantik.my.id",
      "from_email": "sender1@example.com",
      "subject": "Email 1",
      "body": "Content 1"
    },
    {
      "to_email": "xyz789@revacantik.my.id",
      "from_email": "sender2@example.com",
      "subject": "Email 2", 
      "body": "Content 2"
    }
  ]
}
                    </div>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Response:</h4>
                    <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
{
  "success": true,
  "message": "Processed 2 emails",
  "data": {
    "processed": 2,
    "successful": 2,
    "failed": 0,
    "results": [
      {"index": 0, "success": true, "message_id": 1},
      {"index": 1, "success": true, "message_id": 2}
    ]
  }
}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Error Handling -->
    <section class="bg-white rounded-2xl shadow-md p-6 mb-8" style="border:1.5px solid #fce7f3;">
        <h2 class="text-xl font-bold mb-6" style="color:#831843;">
            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>Penanganan Error
        </h2>

        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Format Respons Error</h3>
                <p class="text-gray-700 mb-3">Semua error API mengembalikan struktur JSON yang konsisten:</p>
                <div class="bg-gray-800 text-red-400 p-4 rounded-lg text-sm font-mono">
{
  "success": false,
  "message": "Error description",
  "errors": {
    "field_name": ["Validation error message"]
  }
}
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Kode Status HTTP Umum</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm font-mono mr-3">200</span>
                            <span class="text-gray-700">Success</span>
                        </div>
                        <div class="flex items-center">
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm font-mono mr-3">400</span>
                            <span class="text-gray-700">Bad Request / Validation Error</span>
                        </div>
                        <div class="flex items-center">
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm font-mono mr-3">404</span>
                            <span class="text-gray-700">Not Found</span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm font-mono mr-3">419</span>
                            <span class="text-gray-700">CSRF Token Mismatch</span>
                        </div>
                        <div class="flex items-center">
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm font-mono mr-3">429</span>
                            <span class="text-gray-700">Rate Limit Exceeded</span>
                        </div>
                        <div class="flex items-center">
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm font-mono mr-3">500</span>
                            <span class="text-gray-700">Server Error</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Code Examples -->
    <section class="bg-white rounded-2xl shadow-md p-6 mb-8" style="border:1.5px solid #fce7f3;">
        <h2 class="text-xl font-bold mb-6" style="color:#831843;">
            <i class="fas fa-code text-indigo-500 mr-3"></i>Contoh Kode
        </h2>

        <div class="space-y-6">
            <!-- JavaScript Example -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-3">JavaScript (Fetch API)</h3>
                <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
// Generate email
const response = await fetch('/api/v1/temp-emails/generate', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
  }
});

const result = await response.json();
console.log('Generated email:', result.data.email_address);

// Check inbox
const inboxResponse = await fetch(`/api/v1/temp-emails/${result.data.id}/inbox`);
const inbox = await inboxResponse.json();
console.log('Inbox emails:', inbox.data);
                </div>
            </div>

            <!-- PHP/cURL Example -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-3">PHP (cURL)</h3>
                <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
&lt;?php
// Check username availability
$checkData = json_encode(['username' => 'myemail123']);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://revacantik.my.id/api/v1/temp-emails/check-availability');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $checkData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-CSRF-TOKEN: ' . $csrfToken
]);
$availabilityResponse = curl_exec($ch);
$availability = json_decode($availabilityResponse, true);

if ($availability['available']) {
    // Generate custom email
    $data = json_encode([
        'generation_type' => 'custom',
        'custom_username' => 'myemail123',
        'expires_in' => '6_months'
    ]);
    
    curl_setopt($ch, CURLOPT_URL, 'https://revacantik.my.id/api/v1/temp-emails/generate');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    
    $response = curl_exec($ch);
    $result = json_decode($response, true);
    echo 'Generated email: ' . $result['data']['email_address'];
} else {
    echo 'Username not available';
}
curl_close($ch);
?&gt;
                </div>
            </div>

            <!-- Python Example -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Python (requests)</h3>
                <div class="bg-gray-800 text-green-400 p-4 rounded-lg text-sm font-mono overflow-x-auto">
import requests

# Generate email
response = requests.post(
    'https://revacantik.my.id/api/v1/temp-emails/generate',
    headers={
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf_token
    }
)

data = response.json()
email_id = data['data']['id']
email_address = data['data']['email_address']
print(f'Generated email: {email_address}')

# Simulate incoming email
simulate_data = {
    'temp_email_id': email_id,
    'from_email': 'test@example.com',
    'sender_name': 'Test Sender',
    'subject': 'Test Email',
    'body': 'This is a test message'
}

simulate_response = requests.post(
    'https://revacantik.my.id/api/v1/simulate/email',
    json=simulate_data,
    headers={'X-CSRF-TOKEN': csrf_token}
)

print('Email simulated:', simulate_response.json()['success'])
                </div>
            </div>
        </div>
    </section>

    <!-- Rate Limiting -->
    <section class="bg-white rounded-2xl shadow-md p-6 mb-8" style="border:1.5px solid #fce7f3;">
        <h2 class="text-xl font-bold mb-4" style="color:#831843;">
            <i class="fas fa-tachometer-alt text-orange-500 mr-3"></i>Pembatasan Rate
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Batas Saat Ini:</h3>
                <div class="space-y-2 text-sm text-gray-600">
                    <p><i class="fas fa-clock text-blue-500 mr-2"></i>60 requests per minute per IP</p>
                    <p><i class="fas fa-envelope text-green-500 mr-2"></i>10 email generations per hour</p>
                    <p><i class="fas fa-flask text-purple-500 mr-2"></i>20 simulations per hour</p>
                </div>
            </div>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#be185d;">Header Pembatasan Rate:</h3>
                <div class="bg-gray-50 rounded-lg p-3 font-mono text-sm">
X-RateLimit-Limit: 60<br>
X-RateLimit-Remaining: 45<br>
X-RateLimit-Reset: 1640995200
                </div>
            </div>
        </div>
    </section>

    <!-- Integration Guide -->
    <section class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-4" style="color:#831843;">
            <i class="fas fa-puzzle-piece text-green-500 mr-3"></i>Panduan Integrasi
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="font-semibold text-blue-800 mb-2">
                    <i class="fas fa-mobile-alt mr-2"></i>Aplikasi Mobile
                </h3>
                <p class="text-blue-700 text-sm">
                    Sempurna untuk aplikasi mobile yang membutuhkan verifikasi email tanpa registrasi pengguna.
                </p>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <h3 class="font-semibold text-green-800 mb-2">
                    <i class="fas fa-globe mr-2"></i>Aplikasi Web
                </h3>
                <p class="text-green-700 text-sm">
                    Integrasikan langsung ke form web dan proses registrasi untuk privasi yang lebih baik.
                </p>
            </div>
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                <h3 class="font-semibold text-purple-800 mb-2">
                    <i class="fas fa-robot mr-2"></i>Pengujian & Otomasi
                </h3>
                <p class="text-purple-700 text-sm">
                    Ideal untuk skenario pengujian otomatis dan pipeline CI/CD yang membutuhkan verifikasi email.
                </p>
            </div>
        </div>
    </section>
</div>

<!-- Back to Top Button -->
<button id="backToTop" class="fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg transition-all duration-300 transform translate-y-16 opacity-0 z-50">
    <i class="fas fa-chevron-up"></i>
</button>
@endsection

@push('scripts')
<script>
// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
        }
    });
});

// Back to top functionality
const backToTopButton = document.getElementById('backToTop');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        backToTopButton.classList.remove('translate-y-16', 'opacity-0');
    } else {
        backToTopButton.classList.add('translate-y-16', 'opacity-0');
    }
});

backToTopButton.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// Copy code blocks functionality
document.querySelectorAll('.bg-gray-800').forEach((codeBlock, index) => {
    // Create wrapper if not already wrapped
    if (codeBlock.parentNode.className !== 'relative') {
        const wrapper = document.createElement('div');
        wrapper.className = 'relative';
        codeBlock.parentNode.insertBefore(wrapper, codeBlock);
        wrapper.appendChild(codeBlock);
    }
    
    // Create copy button
    const copyButton = document.createElement('button');
    copyButton.innerHTML = '<i class="fas fa-copy"></i>';
    copyButton.className = 'absolute top-2 right-2 bg-gray-600 hover:bg-gray-500 text-white px-2 py-1 rounded text-xs transition-colors z-10';
    copyButton.setAttribute('data-tooltip', 'Salin ke clipboard');
    
    copyButton.onclick = async () => {
        try {
            const textContent = codeBlock.innerText || codeBlock.textContent;
            await navigator.clipboard.writeText(textContent);
            
            // Show success feedback
            const originalHtml = copyButton.innerHTML;
            copyButton.innerHTML = '<i class="fas fa-check text-green-400"></i>';
            copyButton.className = copyButton.className.replace('bg-gray-600 hover:bg-gray-500', 'bg-green-600');
            
            setTimeout(() => {
                copyButton.innerHTML = originalHtml;
                copyButton.className = copyButton.className.replace('bg-green-600', 'bg-gray-600 hover:bg-gray-500');
            }, 2000);
        } catch (err) {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = codeBlock.innerText || codeBlock.textContent;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            
            copyButton.innerHTML = '<i class="fas fa-check text-green-400"></i>';
            setTimeout(() => {
                copyButton.innerHTML = '<i class="fas fa-copy"></i>';
            }, 1000);
        }
    };
    
    codeBlock.parentNode.appendChild(copyButton);
});

// Add hover effects
document.querySelectorAll('.bg-gray-800').forEach(element => {
    element.style.transition = 'transform 0.2s ease';
    
    element.addEventListener('mouseenter', () => {
        element.style.transform = 'scale(1.01)';
    });
    
    element.addEventListener('mouseleave', () => {
        element.style.transform = 'scale(1)';
    });
});

// Add scroll spy for navigation
const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('a[href^="#"]');

function updateActiveLink() {
    let current = '';
    
    sections.forEach(section => {
        const sectionTop = section.getBoundingClientRect().top;
        if (sectionTop <= 100) {
            current = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('bg-blue-100', 'text-blue-800');
        link.classList.add('bg-gray-50', 'text-gray-700');
        
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.remove('bg-gray-50', 'text-gray-700');
            link.classList.add('bg-blue-100', 'text-blue-800');
        }
    });
}

window.addEventListener('scroll', updateActiveLink);
updateActiveLink(); // Initial call

// Add API testing functionality
function createAPITester() {
    const testButton = document.createElement('button');
    testButton.innerHTML = '<i class="fas fa-play mr-2"></i>Uji API Langsung';
    testButton.className = 'fixed bottom-20 right-6 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-full shadow-lg transition-all duration-300 z-40';
    
    testButton.onclick = () => {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
        modal.innerHTML = `
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg" style="border:1.5px solid #fbcfe8;">
                <!-- Header -->
                <div class="flex items-center justify-between px-5 py-4 rounded-t-2xl" style="background:linear-gradient(135deg,#fdf2f8,#fce7f3);border-bottom:1.5px solid #fbcfe8;">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-flask" style="color:#ec4899;"></i>
                        <span class="font-bold text-base" style="color:#831843;">Uji API Langsung</span>
                    </div>
                    <button id="closeModal" class="w-7 h-7 rounded-lg flex items-center justify-center transition-colors hover:bg-pink-200" style="background:#fce7f3;color:#be185d;">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                <!-- Body -->
                <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest mb-1.5" style="color:#be185d;">Endpoint</label>
                        <select id="endpointSelect" class="w-full rounded-xl px-3 py-2 text-sm text-gray-700 bg-white outline-none" style="border:1.5px solid #f9a8d4;">
                            <option value="generate">POST — Buat Email</option>
                            <option value="check-availability">POST — Periksa Username</option>
                            <option value="stats">GET — Statistik Live</option>
                            <option value="simulate">POST — Simulasi Email</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest mb-1.5" style="color:#be185d;">Body (JSON)</label>
                        <textarea id="requestData" class="w-full rounded-xl px-3 py-2 h-28 font-mono text-xs text-gray-700 bg-white outline-none resize-none" style="border:1.5px solid #f9a8d4;">{}</textarea>
                    </div>
                    <button id="sendRequest" class="w-full py-2.5 rounded-xl text-sm font-semibold text-white transition-all" style="background:linear-gradient(135deg,#db2777,#ec4899);">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Permintaan
                    </button>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest mb-1.5" style="color:#be185d;">Respons</label>
                        <div id="responseContent" class="rounded-xl px-3 py-2.5 h-36 overflow-y-auto font-mono text-xs text-gray-600" style="background:#fdf2f8;border:1.5px solid #f9a8d4;">
                            Klik "Kirim Permintaan" untuk melihat respons...
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Modal functionality
        document.getElementById('closeModal').onclick = () => {
            document.body.removeChild(modal);
        };
        
        modal.onclick = (e) => {
            if (e.target === modal) {
                document.body.removeChild(modal);
            }
        };
        
        // API test functionality
        document.getElementById('sendRequest').onclick = async () => {
            const endpoint = document.getElementById('endpointSelect').value;
            const requestData = document.getElementById('requestData').value;
            const responseContent = document.getElementById('responseContent');
            
            responseContent.textContent = 'Mengirim permintaan...';
            
            try {
                let url, method, body;
                
                if (endpoint === 'generate') {
                    url = '/api/v1/temp-emails/generate';
                    method = 'POST';
                    body = requestData || JSON.stringify({
                        generation_type: 'auto',
                        expires_in: '1_month'
                    });
                } else if (endpoint === 'check-availability') {
                    url = '/api/v1/temp-emails/check-availability';
                    method = 'POST';
                    body = requestData || JSON.stringify({
                        username: 'myemail123'
                    });
                } else if (endpoint === 'stats') {
                    url = '/api/v1/stats';
                    method = 'GET';
                    body = null;
                } else if (endpoint === 'simulate') {
                    url = '/api/v1/simulate/email';
                    method = 'POST';
                    body = requestData;
                }
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
                
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: body
                });
                
                const result = await response.json();
                responseContent.textContent = JSON.stringify(result, null, 2);
                
                // Store generated email ID for simulation
                if (endpoint === 'generate' && result.success) {
                    document.getElementById('requestData').value = JSON.stringify({
                        temp_email_id: result.data.id,
                        from_email: "test@example.com",
                        sender_name: "API Tester",
                        subject: "Tes Email dari Dokumentasi API",
                        body: "Ini adalah email tes yang dikirim dari halaman dokumentasi API!"
                    }, null, 2);
                }
                
            } catch (error) {
                responseContent.textContent = 'Error: ' + error.message;
            }
        };
        
        // Update request body based on endpoint
        document.getElementById('endpointSelect').onchange = (e) => {
            const textarea = document.getElementById('requestData');
            if (e.target.value === 'generate') {
                textarea.value = JSON.stringify({
                    generation_type: 'auto',
                    expires_in: '1_month'
                }, null, 2);
            } else if (e.target.value === 'check-availability') {
                textarea.value = JSON.stringify({
                    username: 'myemail123'
                }, null, 2);
            } else if (e.target.value === 'stats') {
                textarea.value = '// GET request - no body required\n// This endpoint returns live platform statistics';
            } else if (e.target.value === 'simulate') {
                textarea.value = JSON.stringify({
                    temp_email_id: 1,
                    from_email: "test@example.com",
                    sender_name: "Penguji API",
                    subject: "Email Tes",
                    body: "Ini adalah pesan tes"
                }, null, 2);
            }
        };
        
        // Initialize with default generate request
        document.getElementById('requestData').value = JSON.stringify({
            generation_type: 'auto',
            expires_in: '1_month'
        }, null, 2);
    };
    
    document.body.appendChild(testButton);
}

// Add API tester if we have CSRF token
if (document.querySelector('meta[name="csrf-token"]')) {
    createAPITester();
}
</script>
@endpush

@push('styles')
<style>
.loading {
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

pre {
    transition: transform 0.2s ease;
}

section {
    scroll-margin-top: 2rem;
}
</style>
@endpush

