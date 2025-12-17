     <!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Quiz CPNS') - Portal CPNS</title>
    
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
    
    <!-- MathJax for Math Formulas -->
    <script>
        MathJax = {
            tex: {
                inlineMath: [['$', '$'], ['\\(', '\\)']],
                displayMath: [['$$', '$$'], ['\\[', '\\]']]
            },
            svg: {
                fontCache: 'global'
            }
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js" async></script>
    
    <!-- Custom CSS -->
    <style>
        * { font-family: 'Poppins', sans-serif; }
        html { scroll-behavior: smooth; }
        
        /* Fixed Background */
        body {
            background-image: url('{{ asset("images/background.jpg") }}');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 58, 138, 0.85) 50%, rgba(88, 28, 135, 0.8) 100%);
            z-index: -1;
            pointer-events: none;
        }
        
        /* Glass Morphism */
        .glass-white {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Fixed Timer */
        #fixedTimer {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 16px 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
        }
        
        #fixedTimer.warning {
            background: rgba(251, 191, 36, 0.3) !important;
            border-color: rgba(251, 191, 36, 0.6) !important;
        }
        
        #fixedTimer.danger {
            background: rgba(239, 68, 68, 0.4) !important;
            border-color: rgba(239, 68, 68, 0.7) !important;
            animation: timer-pulse 1s infinite;
        }
        
        @keyframes timer-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.03); }
        }
        
        /* High Contrast Mode */
        .high-contrast {
            background: #000 !important;
            color: #fff !important;
        }
        .high-contrast .glass-white {
            background: #1a1a1a !important;
            color: #fff !important;
        }
        
        /* Nav Button States */
        .nav-btn.active {
            background: rgba(37, 99, 235, 0.8) !important;
            border-color: rgb(37, 99, 235) !important;
        }
        
        .nav-btn.answered {
            background: rgba(22, 163, 74, 0.8) !important;
            border-color: rgb(22, 163, 74) !important;
        }
        
        .nav-btn.flagged {
            background: rgba(234, 179, 8, 0.8) !important;
            border-color: rgb(234, 179, 8) !important;
            color: #1f2937 !important;
        }
        
        .option-item.selected {
            background: rgba(59, 130, 246, 0.3) !important;
            border-color: rgb(59, 130, 246) !important;
        }
        
        .option-item.selected .option-label {
            background: rgb(37, 99, 235) !important;
        }
        
        .btn-flag.flagged {
            background: rgba(234, 179, 8, 0.8) !important;
            color: #1f2937 !important;
        }
        
        #contrastToggle.active {
            background: rgb(234, 179, 8) !important;
            color: #1f2937 !important;
        }
    </style>
    
    @stack('styles')
</head>
<body class="font-poppins antialiased text-gray-100">
    <!-- Fixed Timer - Always Visible -->
    <div id="fixedTimer">
        <div class="text-white/60 text-xs text-center mb-1">Sisa Waktu</div>
        <div class="text-3xl md:text-4xl font-bold text-white font-mono text-center" id="timerDisplay">01:30:00</div>
        <div class="text-white/60 text-xs text-center mt-1">@yield('timer-info', 'CPNS Test')</div>
    </div>
    
    <!-- Main Content - No Navbar, Footer, Chatbot -->
    <main class="min-h-screen py-6">
        @yield('content')
    </main>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        // CSRF Token for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
