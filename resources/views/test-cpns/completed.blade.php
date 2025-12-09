@extends('layouts.app')

@section('title', 'Ujian Selesai')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12" data-aos="fade-up">
            <span class="inline-flex items-center px-4 py-2 bg-white/20 text-white rounded-full text-sm font-medium mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> Test Selesai
            </span>
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Anda Sudah Mengikuti Ujian</h1>
            <p class="text-white/80 max-w-2xl mx-auto">Terima kasih telah mengikuti seleksi CPNS</p>
        </div>
        
        <!-- Main Card -->
        <div class="max-w-3xl mx-auto">
            <div class="glass-section rounded-3xl p-8 text-center" data-aos="fade-up">
                <!-- Icon -->
                <div class="w-32 h-32 mx-auto bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center mb-6">
                    <i class="bi bi-clipboard-check text-6xl text-white"></i>
                </div>
                
                <!-- Message -->
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Ujian Telah Diselesaikan</h2>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Anda telah menyelesaikan ujian CPNS. Setiap peserta hanya dapat mengikuti ujian <strong>satu kali</strong>. 
                    Silakan tunggu pengumuman hasil di halaman Berita.
                </p>
                
                <!-- Test Info -->
                <div class="bg-gray-50 rounded-2xl p-6 mb-8 text-left">
                    <h5 class="text-gray-900 font-semibold mb-4 flex items-center gap-2">
                        <i class="bi bi-info-circle text-blue-600"></i> Informasi Ujian Anda
                    </h5>
                    <div class="grid md:grid-cols-2 gap-4 text-sm">
                        <div class="flex justify-between p-3 bg-white rounded-lg">
                            <span class="text-gray-500">Kategori:</span>
                            <span class="text-gray-900 font-semibold">{{ $completedSession->category }}</span>
                        </div>
                        <div class="flex justify-between p-3 bg-white rounded-lg">
                            <span class="text-gray-500">Domisili Penempatan:</span>
                            <span class="text-gray-900 font-semibold">{{ $completedSession->domisili_penempatan }}</span>
                        </div>
                        <div class="flex justify-between p-3 bg-white rounded-lg">
                            <span class="text-gray-500">Tanggal Ujian:</span>
                            <span class="text-gray-900 font-semibold">{{ $completedSession->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex justify-between p-3 bg-white rounded-lg">
                            <span class="text-gray-500">Nilai:</span>
                            <span class="font-bold text-lg {{ $completedSession->score >= 70 ? 'text-green-600' : ($completedSession->score >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ number_format($completedSession->score, 1) }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Status Badge -->
                <div class="mb-8">
                    @if($completedSession->score >= 70)
                    <span class="inline-flex items-center px-6 py-3 bg-green-100 text-green-800 rounded-full text-lg font-semibold">
                        <i class="bi bi-check-circle-fill me-2"></i> LULUS
                    </span>
                    @elseif($completedSession->score >= 50)
                    <span class="inline-flex items-center px-6 py-3 bg-yellow-100 text-yellow-800 rounded-full text-lg font-semibold">
                        <i class="bi bi-exclamation-circle-fill me-2"></i> CUKUP
                    </span>
                    @else
                    <span class="inline-flex items-center px-6 py-3 bg-red-100 text-red-800 rounded-full text-lg font-semibold">
                        <i class="bi bi-x-circle-fill me-2"></i> TIDAK LULUS
                    </span>
                    @endif
                </div>
                
                <!-- Actions -->
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('quiz.result', $completedSession) }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:-translate-y-0.5 hover:shadow-lg transition-all">
                        <i class="bi bi-journal-check me-2"></i> Lihat Pembahasan
                    </a>
                    <a href="{{ route('berita.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300 transition-all">
                        <i class="bi bi-newspaper me-2"></i> Lihat Pengumuman
                    </a>
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-8 py-4 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all">
                        <i class="bi bi-house me-2"></i> Beranda
                    </a>
                </div>
            </div>
            
            <!-- Warning Card -->
            <div class="glass-white rounded-2xl p-6 mt-6 text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center justify-center gap-3 text-yellow-400">
                    <i class="bi bi-shield-lock text-3xl"></i>
                    <div class="text-left">
                        <h5 class="font-semibold text-white">Sistem Keamanan</h5>
                        <p class="text-white/70 text-sm">
                            Setiap peserta hanya dapat mengikuti ujian satu kali untuk menjaga integritas dan keadilan seleksi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
