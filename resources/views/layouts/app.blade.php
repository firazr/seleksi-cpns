<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CPNS 2025') - Portal Pendaftaran CPNS</title>
    
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        * { font-family: 'Poppins', sans-serif; }
        html { scroll-behavior: smooth; }
        
        /* Fixed Background Pattern */
        body {
            background-color: #f1f5f9;
            background-image: url('{{ asset("images/cpns-pattern.png") }}');
            background-attachment: fixed;
            background-size: 350px auto;
            background-position: top left;
            background-repeat: repeat;
            min-height: 100vh;
        }
        
        /* Glass Morphism */
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .glass-section {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        
        .glass-dark {
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        
        /* Glass White for Admin pages */
        .glass-white {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .glass-white h2,
        .glass-white h3,
        .glass-white h4,
        .glass-white h5,
        .glass-white .text-white {
            color: #1f2937 !important;
        }
        
        .glass-white .text-white\/60,
        .glass-white p {
            color: #6b7280 !important;
        }
        
        .glass-white table th {
            background: #f3f4f6 !important;
            color: #374151 !important;
        }
        
        .glass-white table td {
            color: #374151 !important;
        }
        
        .glass-white input,
        .glass-white select {
            background: #f9fafb !important;
            color: #1f2937 !important;
            border-color: #d1d5db !important;
        }
        
        .glass-white input::placeholder {
            color: #9ca3af !important;
        }
        
        .glass-white .border-white\/30 {
            border-color: #d1d5db !important;
        }
        
        .glass-white .border-white\/20 {
            border-color: #e5e7eb !important;
        }
        
        .glass-white .bg-white\/10 {
            background: #f3f4f6 !important;
        }
        
        /* Card Hover */
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        /* Navbar */
        .navbar-scrolled {
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .navbar-scrolled .nav-link { color: #374151 !important; }
        .navbar-scrolled .nav-link:hover { color: #4f46e5 !important; }
        .navbar-scrolled .logo-text { color: #1f2937 !important; }
        
        /* High Contrast Mode */
        .high-contrast {
            background: #000 !important;
            color: #fff !important;
        }
        .high-contrast .glass-card,
        .high-contrast .glass-section {
            background: #1a1a1a !important;
            color: #fff !important;
        }
        
        /* Chatbot Button */
        .chatbot-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 1000;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        /* Modal */
        .modal-backdrop {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }
    </style>
    
    @stack('styles')
</head>
<body class="font-poppins antialiased text-gray-800">
    <!-- Navbar -->
    @include('partials.navbar')
    
    <!-- Flash Messages -->
    @if(session('success'))
    <div id="flash-success" class="fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg animate-fade-in">
        <div class="flex items-center gap-2">
            <i class="bi bi-check-circle"></i>
            {{ session('success') }}
        </div>
    </div>
    @endif
    
    @if(session('error'))
    <div id="flash-error" class="fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg animate-fade-in">
        <div class="flex items-center gap-2">
            <i class="bi bi-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    </div>
    @endif
    
    <!-- Main Content -->
    <main class="min-h-screen pt-16">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('partials.footer')
    
    <!-- Chatbot Button -->
    @include('partials.chatbot')
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50
        });
        
        // CSRF Token for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Navbar scroll effect
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $('#navbar').addClass('navbar-scrolled');
            } else {
                $('#navbar').removeClass('navbar-scrolled');
            }
        });
        
        // Auto hide flash messages
        setTimeout(() => {
            $('#flash-success, #flash-error').fadeOut();
        }, 5000);
        
        // Mobile menu toggle
        $('#mobile-menu-btn').click(function() {
            $('#mobile-menu').slideToggle(300);
            $('#menu-icon, #close-icon').toggleClass('hidden');
        });
    </script>
    
    @stack('scripts')
</body>
</html>
