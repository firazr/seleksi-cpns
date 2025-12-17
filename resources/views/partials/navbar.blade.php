<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-transparent backdrop-blur-sm">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                    <i class="bi bi-building text-white text-xl"></i>
                </div>
                <span class="logo-text text-xl font-bold text-white hidden sm:block">CPNS 2025</span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-1">
                <a href="{{ route('home') }}" class="nav-link px-4 py-2 rounded-lg text-white/90 hover:text-white hover:bg-white/10 font-medium transition-all {{ request()->routeIs('home') ? 'bg-white/10' : '' }}">
                    <i class="bi bi-house me-1"></i> Home
                </a>
                <a href="{{ route('berita.index') }}" class="nav-link px-4 py-2 rounded-lg text-white/90 hover:text-white hover:bg-white/10 font-medium transition-all {{ request()->routeIs('berita.*') ? 'bg-white/10' : '' }}">
                    <i class="bi bi-newspaper me-1"></i> Berita
                </a>
                <a href="{{ route('profil.index') }}" class="nav-link px-4 py-2 rounded-lg text-white/90 hover:text-white hover:bg-white/10 font-medium transition-all {{ request()->routeIs('profil.*') ? 'bg-white/10' : '' }}">
                    <i class="bi bi-info-circle me-1"></i> Profil
                </a>
                
                @auth
                @if(!auth()->user()->isAdmin())
                <a href="{{ route('test-cpns.index') }}" class="nav-link px-4 py-2 rounded-lg text-white/90 hover:text-white hover:bg-white/10 font-medium transition-all {{ request()->routeIs('test-cpns.*') ? 'bg-white/10' : '' }}">
                    <i class="bi bi-pencil-square me-1"></i> Test CPNS
                </a>
                @else
                <a href="{{ route('admin.dashboard') }}" class="nav-link px-4 py-2 rounded-lg text-white/90 hover:text-white hover:bg-white/10 font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-white/10' : '' }}">
                    <i class="bi bi-graph-up me-1"></i> Dashboard
                </a>
                <a href="{{ route('admin.questions.index') }}" class="nav-link px-4 py-2 rounded-lg text-white/90 hover:text-white hover:bg-white/10 font-medium transition-all {{ request()->routeIs('admin.questions.*') ? 'bg-white/10' : '' }}">
                    <i class="bi bi-pencil me-1"></i> Manage Questions
                </a>
                @endif
                @endauth
                
                @guest
                <a href="{{ route('login') }}" class="nav-link ml-2 px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </a>
                @else
                <div class="relative ml-2">
                    <button onclick="document.getElementById('user-dropdown').classList.toggle('hidden')" class="flex items-center gap-2 px-4 py-2 bg-white/10 rounded-xl text-white hover:bg-white/20 transition-all">
                        <img src="{{ auth()->user()->photo_path ? asset('storage/' . auth()->user()->photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                             alt="{{ auth()->user()->name }}" 
                             class="w-8 h-8 rounded-full object-cover">
                        <span class="font-medium">{{ auth()->user()->name }}</span>
                        <i class="bi bi-chevron-down text-sm"></i>
                    </button>
                    <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2 z-50">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                            <span class="inline-block px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full mt-1">
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
                @endguest
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg text-white hover:bg-white/10 transition-colors">
                <svg id="menu-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="lg:hidden hidden pb-4">
            <div class="space-y-2 border-t border-white/20 pt-4">
                <a href="{{ route('home') }}" class="flex items-center px-4 py-3 rounded-xl text-white/90 hover:text-white hover:bg-white/10 font-medium">
                    <i class="bi bi-house me-3"></i> Home
                </a>
                <a href="{{ route('berita.index') }}" class="flex items-center px-4 py-3 rounded-xl text-white/90 hover:text-white hover:bg-white/10 font-medium">
                    <i class="bi bi-newspaper me-3"></i> Berita
                </a>
                <a href="{{ route('profil.index') }}" class="flex items-center px-4 py-3 rounded-xl text-white/90 hover:text-white hover:bg-white/10 font-medium">
                    <i class="bi bi-info-circle me-3"></i> Profil
                </a>
                
                @auth
                @if(!auth()->user()->isAdmin())
                <a href="{{ route('test-cpns.index') }}" class="flex items-center px-4 py-3 rounded-xl text-white/90 hover:text-white hover:bg-white/10 font-medium">
                    <i class="bi bi-pencil-square me-3"></i> Test CPNS
                </a>
                @else
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl text-white/90 hover:text-white hover:bg-white/10 font-medium">
                    <i class="bi bi-graph-up me-3"></i> Dashboard
                </a>
                <a href="{{ route('admin.questions.index') }}" class="flex items-center px-4 py-3 rounded-xl text-white/90 hover:text-white hover:bg-white/10 font-medium">
                    <i class="bi bi-pencil me-3"></i> Manage Questions
                </a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 rounded-xl bg-red-500/20 text-red-300 hover:bg-red-500/30 font-medium">
                        <i class="bi bi-box-arrow-right me-3"></i> Logout
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="flex items-center justify-center mt-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Login
                </a>
                <a href="{{ route('register') }}" class="flex items-center justify-center mt-2 py-3 bg-white/10 text-white rounded-xl font-semibold">
                    <i class="bi bi-person-plus me-2"></i> Register
                </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
