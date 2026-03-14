<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'REVA Mail - Generator Email Gratis')</title>
    
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        * { font-family: 'Inter', sans-serif; }

        :root {
            --pink-50: #fdf2f8;
            --pink-100: #fce7f3;
            --pink-200: #fbcfe8;
            --pink-300: #f9a8d4;
            --pink-400: #f472b6;
            --pink-500: #ec4899;
            --pink-600: #db2777;
            --pink-700: #be185d;
            --pink-800: #9d174d;
            --pink-900: #831843;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #be185d 0%, #ec4899 50%, #f472b6 100%);
        }

        .gradient-hero {
            background: linear-gradient(135deg, #831843 0%, #be185d 35%, #ec4899 70%, #f9a8d4 100%);
        }

        .gradient-btn {
            background: linear-gradient(135deg, #db2777 0%, #ec4899 100%);
        }
        .gradient-btn:hover {
            background: linear-gradient(135deg, #be185d 0%, #db2777 100%);
        }

        .gradient-btn-dark {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        }
        .gradient-btn-dark:hover {
            background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
        }

        .card-glass {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(236, 72, 153, 0.12);
        }

        .email-card {
            transition: all 0.25s cubic-bezier(.4,0,.2,1);
            border-left: 3px solid transparent;
        }
        .email-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(236,72,153,0.13);
            border-left-color: #ec4899;
        }

        .loading {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .fade-in {
            animation: fadeIn 0.45s ease-out both;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .slide-up {
            animation: slideUp 0.35s ease-out both;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .pulse-animation {
            animation: pulse2 2.2s ease-in-out infinite;
        }
        @keyframes pulse2 {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.55; }
        }

        .nav-link {
            position: relative;
            padding-bottom: 2px;
            transition: color 0.2s;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px; left: 0; right: 0;
            height: 2px;
            background: #f9a8d4;
            transform: scaleX(0);
            transition: transform 0.2s;
            border-radius: 2px;
        }
        .nav-link:hover::after { transform: scaleX(1); }

        .stat-card {
            transition: all 0.25s ease;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(236,72,153,0.15);
        }

        .feature-icon-wrap {
            background: linear-gradient(135deg, #fce7f3, #fbcfe8);
            transition: all 0.25s ease;
        }
        .feature-card:hover .feature-icon-wrap {
            background: linear-gradient(135deg, #ec4899, #be185d);
        }
        .feature-card:hover .feature-icon-wrap i {
            color: white !important;
        }
        .feature-card {
            transition: all 0.25s ease;
        }
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(236,72,153,0.14);
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #fdf2f8; }
        ::-webkit-scrollbar-thumb { background: #f9a8d4; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #ec4899; }

        /* Input focus pink */
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #ec4899 !important;
            box-shadow: 0 0 0 3px rgba(236,72,153,0.15) !important;
        }

        .badge-active {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
        }
        .badge-expired {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
        }

        .modal-backdrop {
            backdrop-filter: blur(4px);
            background: rgba(131, 24, 67, 0.4);
        }

        .footer-bg {
            background: linear-gradient(135deg, #1a0a12 0%, #2d0f1e 50%, #3d1428 100%);
        }

        .btn-pink {
            background: linear-gradient(135deg, #db2777 0%, #ec4899 100%);
            box-shadow: 0 4px 15px rgba(236,72,153,0.35);
            transition: all 0.25s ease;
            color: white;
            font-weight: 600;
        }
        .btn-pink:hover {
            background: linear-gradient(135deg, #be185d 0%, #db2777 100%);
            box-shadow: 0 6px 20px rgba(236,72,153,0.5);
            transform: translateY(-1px);
        }
        .btn-pink:active { transform: translateY(0); }

        .btn-outline-pink {
            border: 2px solid #ec4899;
            color: #ec4899;
            background: transparent;
            font-weight: 600;
            transition: all 0.25s ease;
        }
        .btn-outline-pink:hover {
            background: #ec4899;
            color: white;
            box-shadow: 0 4px 15px rgba(236,72,153,0.3);
        }

        .copy-field {
            background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 100%);
            border: 1.5px solid #f9a8d4;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-pink-50 min-h-screen" style="background: linear-gradient(180deg, #fdf2f8 0%, #fff 60%);">
    <!-- Header -->
    <header class="gradient-bg text-white shadow-xl sticky top-0 z-40">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('temp-email.index') }}" class="flex items-center space-x-3 group">
                    <div class="bg-white bg-opacity-20 rounded-xl p-2.5 group-hover:bg-opacity-30 transition-all">
                        <i class="fas fa-envelope-open-text text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight">REVA Mail</h1>
                        <p class="text-xs opacity-80 font-medium tracking-wide">Generator Email Gratis</p>
                    </div>
                </a>
                
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('temp-email.index') }}" class="nav-link px-4 py-2 rounded-lg text-white text-sm font-medium hover:bg-white hover:bg-opacity-15 transition-all">
                        <i class="fas fa-home mr-1.5"></i>Beranda
                    </a>
                    <a href="{{ route('api.docs') }}" class="ml-2 px-4 py-2 rounded-lg text-sm font-semibold bg-white bg-opacity-20 hover:bg-opacity-30 transition-all border border-white border-opacity-30">
                        <i class="fas fa-code mr-1.5"></i>Dokumentasi API
                    </a>
                </nav>
                
                <!-- Mobile menu button -->
                <button id="mobileMenuBtn" class="md:hidden bg-white bg-opacity-20 rounded-lg p-2 text-white hover:bg-opacity-30 transition-all">
                    <i class="fas fa-bars text-lg" id="mobileMenuIcon"></i>
                </button>
            </div>

            <!-- Mobile Menu Panel -->
            <div id="mobileMenu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-1 pt-3 border-t border-white border-opacity-20">
                    <a href="{{ route('temp-email.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-white text-sm font-medium hover:bg-white hover:bg-opacity-15 transition-all">
                        <i class="fas fa-home mr-2 w-4"></i>Beranda
                    </a>
                    <a href="{{ route('api.docs') }}" class="flex items-center px-4 py-2.5 rounded-lg text-white text-sm font-semibold bg-white bg-opacity-15 hover:bg-opacity-25 transition-all border border-white border-opacity-20">
                        <i class="fas fa-code mr-2 w-4"></i>Dokumentasi API
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-bg text-white py-12 mt-16">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-3 gap-10">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="bg-pink-600 rounded-lg p-2">
                            <i class="fas fa-envelope-open-text text-lg text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white">REVA Mail</h3>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Buat alamat email secara instan. Lindungi privasi Anda dan hindari spam dengan layanan email aman kami.
                    </p>
                    <div class="flex space-x-3 mt-4">
                        <a href="https://whatsapp.com/channel/0029VbAnIZ86mYPDNZZqMl2Q" target="_blank" class="w-8 h-8 bg-green-700 hover:bg-green-500 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-whatsapp text-sm text-white"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-widest text-pink-400 mb-4">Fitur</h4>
                    <ul class="space-y-2.5 text-gray-400 text-sm">
                        <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-pink-500"></i>Pembuatan email instan</li>
                        <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-pink-500"></i>Tidak perlu registrasi</li>
                        <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-pink-500"></i>Penerimaan email real-time</li>
                        <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-pink-500"></i>Alamat email custom</li>
                        <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-pink-500"></i>Perlindungan privasi</li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-widest text-pink-400 mb-4">Privasi & Keamanan</h4>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Semua email otomatis dihapus setelah kedaluwarsa. 
                        Kami tidak menyimpan informasi pribadi dan privasi Anda selalu terlindungi.
                    </p>
                    <div class="mt-4 flex items-center space-x-2">
                        <div class="w-2 h-2 rounded-full bg-green-400 pulse-animation"></div>
                        <span class="text-xs text-gray-400">Layanan sedang online</span>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-pink-900 border-opacity-50 mt-10 pt-6 flex flex-col sm:flex-row items-center justify-between">
                <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} REVA Mail. Semua hak dilindungi.</p>
                <p class="text-gray-600 text-xs mt-2 sm:mt-0">Dibuat dengan <i class="fas fa-heart text-pink-500 mx-1"></i> oleh RAVENDEV</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileMenuIcon = document.getElementById('mobileMenuIcon');

        mobileMenuBtn.addEventListener('click', function () {
            const isOpen = !mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden', isOpen);
            mobileMenuIcon.className = isOpen
                ? 'fas fa-bars text-lg'
                : 'fas fa-times text-lg';
        });

        // Close mobile menu when a link is clicked
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                mobileMenuIcon.className = 'fas fa-bars text-lg';
            });
        });

        // Set up CSRF token for AJAX requests
        window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Utility functions
        window.formatTime = function(dateStr) {
            const date = new Date(dateStr);
            const now = new Date();
            const diff = now - date;
            const minutes = Math.floor(diff / 60000);
            const hours = Math.floor(diff / 3600000);
            const days = Math.floor(diff / 86400000);
            
            if (minutes < 1) return 'Baru saja';
            if (minutes < 60) return `${minutes}m yang lalu`;
            if (hours < 24) return `${hours}j yang lalu`;
            return `${days}h yang lalu`;
        };
        
        window.showNotification = function(message, type = 'info') {
            const notification = document.createElement('div');
            const bgColor = type === 'error' ? 'bg-red-500' : 
                           type === 'success' ? 'bg-green-500' : 'bg-pink-500';
            
            notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-xl shadow-2xl z-50 fade-in`;
            notification.style.cssText = 'min-width:280px;max-width:380px;';
            notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : type === 'success' ? 'check-circle' : 'info-circle'}"></i>
                    <span class="flex-1 text-sm font-medium">${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200 flex-shrink-0">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 5000);
        };
    </script>
    
    @stack('scripts')
</body>
</html>