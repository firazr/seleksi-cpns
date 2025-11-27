@extends('layouts.app')

@section('title', 'Hasil Test - ' . $session->category)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <!-- Result Card -->
    <div class="glass-white rounded-3xl p-8 text-center" data-aos="fade-up">
        <!-- Header -->
        <div class="mb-8">
            @if($score >= 70)
            <div class="w-24 h-24 mx-auto bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center mb-4">
                <i class="bi bi-trophy-fill text-5xl text-white"></i>
            </div>
            <h2 class="text-3xl font-bold text-white mb-2">Selamat! 🎉</h2>
            <p class="text-green-400">Anda telah lulus ujian dengan hasil memuaskan!</p>
            @elseif($score >= 50)
            <div class="w-24 h-24 mx-auto bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mb-4">
                <i class="bi bi-emoji-smile-fill text-5xl text-white"></i>
            </div>
            <h2 class="text-3xl font-bold text-white mb-2">Cukup Baik!</h2>
            <p class="text-yellow-400">Terus tingkatkan kemampuan Anda!</p>
            @else
            <div class="w-24 h-24 mx-auto bg-gradient-to-br from-red-500 to-pink-600 rounded-full flex items-center justify-center mb-4">
                <i class="bi bi-emoji-frown-fill text-5xl text-white"></i>
            </div>
            <h2 class="text-3xl font-bold text-white mb-2">Tetap Semangat!</h2>
            <p class="text-red-400">Perbanyak latihan untuk hasil yang lebih baik.</p>
            @endif
        </div>
        
        <!-- Score Display -->
        <div class="glass-card rounded-2xl p-6 mb-8 inline-block" style="background: rgba(255,255,255,0.1);">
            <div class="text-6xl font-bold mb-2
                @if($score >= 70) text-green-400
                @elseif($score >= 50) text-yellow-400
                @else text-red-400 @endif">
                {{ number_format($score, 1) }}
            </div>
            <div class="text-white/60">Nilai Akhir</div>
        </div>
        
        <!-- Details -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="glass-white rounded-xl p-4">
                <div class="text-2xl font-bold text-white">{{ $session->category }}</div>
                <div class="text-white/60 text-sm">Kategori</div>
            </div>
            <div class="glass-white rounded-xl p-4">
                <div class="text-2xl font-bold text-green-400">{{ $correct }}</div>
                <div class="text-white/60 text-sm">Benar</div>
            </div>
            <div class="glass-white rounded-xl p-4">
                <div class="text-2xl font-bold text-red-400">{{ $wrong }}</div>
                <div class="text-white/60 text-sm">Salah</div>
            </div>
            <div class="glass-white rounded-xl p-4">
                <div class="text-2xl font-bold text-white">{{ $total }}</div>
                <div class="text-white/60 text-sm">Total Soal</div>
            </div>
        </div>
        
        <!-- Session Info -->
        <div class="bg-white/5 rounded-xl p-5 mb-8 text-left">
            <h5 class="text-white font-semibold mb-3 flex items-center gap-2">
                <i class="bi bi-info-circle"></i> Informasi Test
            </h5>
            <div class="grid md:grid-cols-2 gap-4 text-sm">
                <div class="flex justify-between">
                    <span class="text-white/60">Domisili Penempatan:</span>
                    <span class="text-white font-medium">{{ $session->domisili_penempatan }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-white/60">Waktu Mulai:</span>
                    <span class="text-white font-medium">{{ $session->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-white/60">Waktu Selesai:</span>
                    <span class="text-white font-medium">{{ $session->updated_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-white/60">Durasi:</span>
                    <span class="text-white font-medium">{{ $session->created_at->diffInMinutes($session->updated_at) }} menit</span>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('test-cpns.index') }}" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:-translate-y-0.5 hover:shadow-lg transition-all">
                <i class="bi bi-arrow-repeat mr-2"></i> Coba Lagi
            </a>
            <a href="{{ route('home') }}" class="px-8 py-3 border border-white/30 text-white font-semibold rounded-xl hover:bg-white/10 transition-all">
                <i class="bi bi-house mr-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
    
    <!-- Tips Card -->
    <div class="glass-white rounded-2xl p-6 mt-6" data-aos="fade-up" data-aos-delay="200">
        <h5 class="text-white font-semibold mb-4 flex items-center gap-2">
            <i class="bi bi-lightbulb text-yellow-400"></i> Tips untuk Hasil Lebih Baik
        </h5>
        <ul class="space-y-3 text-white/80">
            <li class="flex items-start gap-3">
                <i class="bi bi-check-circle-fill text-green-400 mt-1"></i>
                <span>Pelajari materi TWK, TIU, dan TKP secara sistematis dan terstruktur.</span>
            </li>
            <li class="flex items-start gap-3">
                <i class="bi bi-check-circle-fill text-green-400 mt-1"></i>
                <span>Latihan soal-soal CPNS dari tahun-tahun sebelumnya secara rutin.</span>
            </li>
            <li class="flex items-start gap-3">
                <i class="bi bi-check-circle-fill text-green-400 mt-1"></i>
                <span>Perhatikan manajemen waktu saat mengerjakan soal.</span>
            </li>
            <li class="flex items-start gap-3">
                <i class="bi bi-check-circle-fill text-green-400 mt-1"></i>
                <span>Jaga kesehatan fisik dan mental menjelang ujian.</span>
            </li>
        </ul>
    </div>
</div>
@endsection
