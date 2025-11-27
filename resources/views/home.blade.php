@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="py-12">
    <!-- Hero Section -->
    <section class="container mx-auto px-4 lg:px-8 mb-16">
        <div class="glass-section rounded-3xl p-8 lg:p-12" data-aos="fade-up">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="flex-1 text-center lg:text-left">
                    <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium mb-6">
                        <i class="bi bi-stars me-2"></i> Pendaftaran Dibuka 2025
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                        Jadilah Bagian dari 
                        <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Aparatur Sipil Negara</span>
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 max-w-xl">
                        Wujudkan impian Anda menjadi Pegawai Negeri Sipil. Daftarkan diri Anda sekarang dan raih masa depan yang gemilang bersama kami.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        @auth
                        <a href="{{ route('test-cpns.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl font-semibold shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                            <i class="bi bi-pencil-square me-2"></i> Mulai Test
                        </a>
                        @else
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl font-semibold shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                            <i class="bi bi-person-plus me-2"></i> Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 rounded-2xl font-semibold shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all border border-gray-200">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Login
                        </a>
                        @endauth
                    </div>
                </div>
                <div class="flex-1" data-aos="fade-left" data-aos-delay="200">
                    <img src="{{ asset('images/hero-cpns.png') }}" alt="CPNS 2025" class="w-full max-w-lg mx-auto rounded-2xl shadow-2xl">
                </div>
            </div>
        </div>
    </section>

    <!-- About CPNS Section -->
    <section class="container mx-auto px-4 lg:px-8 mb-16">
        <div class="text-center mb-12" data-aos="fade-up">
            <span class="inline-flex items-center px-4 py-2 bg-white/20 text-white rounded-full text-sm font-medium mb-4">
                <i class="bi bi-info-circle me-2"></i> Tentang CPNS
            </span>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Apa itu CPNS?</h2>
            <p class="text-white/80 max-w-2xl mx-auto">Calon Pegawai Negeri Sipil adalah proses seleksi untuk mengisi formasi jabatan di lingkungan pemerintahan.</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="glass-card rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 shadow-xl">
                    <i class="bi bi-book text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">TWK</h3>
                <p class="text-gray-600">Tes Wawasan Kebangsaan mengukur pemahaman tentang Pancasila, UUD 1945, Bhinneka Tunggal Ika, dan NKRI.</p>
            </div>
            
            <div class="glass-card rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mb-6 shadow-xl">
                    <i class="bi bi-lightbulb text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">TIU</h3>
                <p class="text-gray-600">Tes Intelegensia Umum mengukur kemampuan verbal, numerik, dan penalaran logis.</p>
            </div>
            
            <div class="glass-card rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-violet-500 rounded-2xl flex items-center justify-center mb-6 shadow-xl">
                    <i class="bi bi-person-check text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">TKP</h3>
                <p class="text-gray-600">Tes Karakteristik Pribadi mengukur integritas, kerja sama, dan orientasi pelayanan.</p>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="container mx-auto px-4 lg:px-8 mb-16">
        <div class="glass-section rounded-3xl p-8 lg:p-12" data-aos="fade-up">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Mengapa Memilih Portal Kami?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Portal CPNS resmi dengan berbagai fitur unggulan untuk mempersiapkan Anda menghadapi seleksi.</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center p-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-shield-check text-blue-600 text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Aman & Terpercaya</h4>
                    <p class="text-sm text-gray-600">Data Anda terjamin keamanannya</p>
                </div>
                
                <div class="text-center p-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-clock text-green-600 text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">24/7 Akses</h4>
                    <p class="text-sm text-gray-600">Latihan kapan saja dimana saja</p>
                </div>
                
                <div class="text-center p-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-graph-up text-purple-600 text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Analisis Hasil</h4>
                    <p class="text-sm text-gray-600">Evaluasi performa secara detail</p>
                </div>
                
                <div class="text-center p-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-people text-orange-600 text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Komunitas</h4>
                    <p class="text-sm text-gray-600">Bergabung dengan peserta lainnya</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="container mx-auto px-4 lg:px-8">
        <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 rounded-3xl p-8 lg:p-12 text-center" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Siap Menjadi PNS?</h2>
            <p class="text-white/80 max-w-2xl mx-auto mb-8">
                Jangan lewatkan kesempatan emas ini. Daftarkan diri Anda sekarang dan mulai persiapan menuju masa depan cerah.
            </p>
            @guest
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-10 py-4 bg-white text-indigo-600 rounded-2xl font-bold text-lg shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                <i class="bi bi-rocket-takeoff me-2"></i> Mulai Sekarang
            </a>
            @else
            <a href="{{ route('test-cpns.index') }}" class="inline-flex items-center justify-center px-10 py-4 bg-white text-indigo-600 rounded-2xl font-bold text-lg shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                <i class="bi bi-pencil-square me-2"></i> Mulai Test
            </a>
            @endguest
        </div>
    </section>
</div>
@endsection
