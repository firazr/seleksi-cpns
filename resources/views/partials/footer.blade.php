<footer class="glass-dark text-white py-12 mt-auto">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <i class="bi bi-building text-white"></i>
                    </div>
                    <span class="text-xl font-bold">CPNS 2025</span>
                </div>
                <p class="text-gray-400">Portal resmi pendaftaran dan seleksi Calon Pegawai Negeri Sipil tahun 2025.</p>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4">Navigasi</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ route('berita.index') }}" class="hover:text-white transition-colors">Berita</a></li>
                    <li><a href="{{ route('profil.index') }}" class="hover:text-white transition-colors">Profil</a></li>
                    @auth
                    <li><a href="{{ route('test-cpns.index') }}" class="hover:text-white transition-colors">Test CPNS</a></li>
                    @endauth
                </ul>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4">Bantuan</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Hubungi Kami</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Panduan</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4">Kontak</h4>
                <ul class="space-y-2 text-gray-400">
                    <li class="flex items-center gap-2">
                        <i class="bi bi-envelope"></i> info@cpns.go.id
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="bi bi-telephone"></i> (021) 1234-5678
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="bi bi-geo-alt"></i> Jakarta, Indonesia
                    </li>
                </ul>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors"><i class="bi bi-facebook text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors"><i class="bi bi-twitter text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors"><i class="bi bi-instagram text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors"><i class="bi bi-youtube text-xl"></i></a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} Portal CPNS. All rights reserved.</p>
        </div>
    </div>
</footer>
