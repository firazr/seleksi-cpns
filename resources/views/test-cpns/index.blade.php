@extends('layouts.app')

@section('title', 'Test CPNS')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12" data-aos="fade-up">
            <span class="inline-flex items-center px-4 py-2 bg-white/20 text-white rounded-full text-sm font-medium mb-4">
                <i class="bi bi-pencil-square me-2"></i> Seleksi Kompetensi
            </span>
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Test CPNS</h1>
            <p class="text-white/80 max-w-2xl mx-auto">Siapkan diri Anda untuk menghadapi seleksi CPNS</p>
        </div>
        
        <!-- User Info Card -->
        <div class="glass-section rounded-3xl p-8 mb-8" data-aos="fade-up">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="w-32 h-32 rounded-2xl overflow-hidden shadow-xl">
                    <img src="{{ $user->photo_path ? asset('storage/' . $user->photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=128&background=4f46e5&color=fff' }}" 
                         alt="{{ $user->name }}" 
                         class="w-full h-full object-cover">
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $user->name }}</h2>
                    <div class="grid md:grid-cols-2 gap-4 text-gray-600">
                        <div class="flex items-center justify-center md:justify-start gap-2">
                            <i class="bi bi-hash text-blue-600"></i>
                            <span><strong>No. Peserta:</strong> {{ $user->participant_number }}</span>
                        </div>
                        <div class="flex items-center justify-center md:justify-start gap-2">
                            <i class="bi bi-envelope text-blue-600"></i>
                            <span>{{ $user->email }}</span>
                        </div>
                        <div class="flex items-center justify-center md:justify-start gap-2">
                            <i class="bi bi-calendar-event text-blue-600"></i>
                            <span><strong>TTL:</strong> {{ $user->ttl ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-center md:justify-start gap-2">
                            <i class="bi bi-geo-alt text-blue-600"></i>
                            <span><strong>Domisili:</strong> {{ $user->domisili ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Test Form -->
        <form action="{{ route('test-cpns.start') }}" method="POST" id="test-form">
            @csrf
            
            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Test Options -->
                <div class="glass-section rounded-3xl p-8" data-aos="fade-right">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-gear text-blue-600"></i> Pengaturan Test
                    </h3>
                    
                    <!-- Domisili Penempatan -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-900 mb-2">
                            <i class="bi bi-geo-alt me-1"></i> Domisili Penempatan Dinas
                        </label>
                        <select name="domisili_penempatan" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white text-gray-900" required>
                            <option value="" class="text-gray-400">Pilih Domisili Penempatan</option>
                            @foreach($domisiliList as $dom)
                            <option value="{{ $dom }}">{{ $dom }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Paket Ujian -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-4">
                            <i class="bi bi-list-check me-1"></i> Paket Ujian
                        </label>
                        
                        @php
                            $hasCompleted = isset($completedSessions) && $completedSessions->count() > 0;
                        @endphp
                        
                        <div class="p-6 border-2 rounded-xl {{ $hasCompleted ? 'border-green-300 bg-green-50' : 'border-blue-300 bg-gradient-to-br from-blue-50 to-indigo-50' }}">
                            <div class="flex items-start gap-4">
                                <div class="w-16 h-16 {{ $hasCompleted ? 'bg-green-200' : 'bg-gradient-to-br from-blue-500 to-indigo-600' }} rounded-xl flex items-center justify-center flex-shrink-0 relative">
                                    <i class="bi bi-collection {{ $hasCompleted ? 'text-green-600' : 'text-white' }} text-2xl"></i>
                                    @if($hasCompleted)
                                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                        <i class="bi bi-check text-white"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-xl font-bold {{ $hasCompleted ? 'text-green-800' : 'text-gray-900' }}">Paket Lengkap CPNS</h4>
                                    <p class="text-gray-600 mt-1">Simulasi ujian CPNS lengkap dengan 3 kategori</p>
                                    
                                    <div class="flex flex-wrap gap-2 mt-3">
                                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                                            <i class="bi bi-book me-1"></i> TWK - Wawasan Kebangsaan
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">
                                            <i class="bi bi-lightbulb me-1"></i> TIU - Intelegensia Umum
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm">
                                            <i class="bi bi-person-check me-1"></i> TKP - Karakteristik Pribadi
                                        </span>
                                    </div>
                                    
                                    @if($hasCompleted)
                                    <div class="mt-4 p-3 bg-green-100 rounded-lg">
                                        <p class="text-green-800 font-medium flex items-center gap-2">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Anda sudah menyelesaikan ujian ini
                                        </p>
                                    </div>
                                    @else
                                    <div class="mt-4 grid grid-cols-3 gap-3 text-center text-sm">
                                        <div class="p-2 bg-white/60 rounded-lg">
                                            <div class="font-bold text-gray-900">100</div>
                                            <div class="text-gray-500 text-xs">Total Soal</div>
                                        </div>
                                        <div class="p-2 bg-white/60 rounded-lg">
                                            <div class="font-bold text-gray-900">90</div>
                                            <div class="text-gray-500 text-xs">Menit</div>
                                        </div>
                                        <div class="p-2 bg-white/60 rounded-lg">
                                            <div class="font-bold text-gray-900">1x</div>
                                            <div class="text-gray-500 text-xs">Kesempatan</div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Completed Tests Summary -->
                    @if(isset($completedSessions) && $completedSessions->count() > 0)
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                        <h5 class="font-semibold text-blue-800 mb-3 flex items-center gap-2">
                            <i class="bi bi-clipboard-check"></i> Riwayat Ujian Anda
                        </h5>
                        <div class="space-y-2">
                            @foreach($completedSessions as $cs)
                            <div class="p-3 bg-white rounded-lg border">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-medium text-gray-900">Paket Lengkap CPNS</span>
                                    <span class="text-xs text-gray-500">{{ $cs->finished_at->format('d M Y, H:i') }}</span>
                                </div>
                                
                                <!-- Per Category Scores -->
                                <div class="grid grid-cols-3 gap-2 text-center text-sm mb-3">
                                    <div class="p-2 bg-blue-50 rounded">
                                        <div class="font-bold {{ ($cs->score_twk ?? 0) >= 65 ? 'text-green-600' : 'text-red-600' }}">{{ $cs->score_twk ?? 0 }}</div>
                                        <div class="text-xs text-gray-500">TWK</div>
                                    </div>
                                    <div class="p-2 bg-green-50 rounded">
                                        <div class="font-bold {{ ($cs->score_tiu ?? 0) >= 80 ? 'text-green-600' : 'text-red-600' }}">{{ $cs->score_tiu ?? 0 }}</div>
                                        <div class="text-xs text-gray-500">TIU</div>
                                    </div>
                                    <div class="p-2 bg-purple-50 rounded">
                                        <div class="font-bold {{ ($cs->score_tkp ?? 0) >= 166 ? 'text-green-600' : 'text-red-600' }}">{{ $cs->score_tkp ?? 0 }}</div>
                                        <div class="text-xs text-gray-500">TKP</div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <div class="font-bold text-lg {{ $cs->score >= 311 ? 'text-green-600' : 'text-red-600' }}">
                                        Total: {{ number_format($cs->score, 0) }}
                                    </div>
                                    <a href="{{ route('quiz.result', $cs) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                                        <i class="bi bi-eye"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Instructions -->
                <div class="glass-section rounded-3xl p-8" data-aos="fade-left">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="bi bi-info-circle text-blue-600"></i> Petunjuk Pengerjaan
                    </h3>
                    
                    <div class="space-y-4 text-gray-600">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-blue-600 font-semibold">1</span>
                            </div>
                            <p>Pastikan koneksi internet stabil selama mengerjakan test.</p>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-blue-600 font-semibold">2</span>
                            </div>
                            <p>Waktu pengerjaan adalah <strong>90 menit</strong> untuk semua kategori.</p>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-blue-600 font-semibold">3</span>
                            </div>
                            <p>Jawaban akan tersimpan otomatis setiap kali Anda memilih opsi.</p>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-blue-600 font-semibold">4</span>
                            </div>
                            <p>Anda dapat berpindah antar soal dengan bebas sebelum waktu habis.</p>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-blue-600 font-semibold">5</span>
                            </div>
                            <p>Jika waktu habis, jawaban akan dikumpulkan secara otomatis.</p>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-blue-600 font-semibold">6</span>
                            </div>
                            <p>Gunakan fitur aksesibilitas (font size, high contrast) jika diperlukan.</p>
                        </div>
                    </div>
                    
                    <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                        <p class="text-yellow-800 text-sm flex items-start gap-2">
                            <i class="bi bi-exclamation-triangle text-yellow-600 mt-0.5"></i>
                            <span><strong>Perhatian:</strong> Setelah memulai test, Anda tidak dapat membatalkan sesi. Pastikan Anda siap sebelum melanjutkan.</span>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="mt-8 text-center" data-aos="fade-up">
                @php
                    $hasCompleted = isset($completedSessions) && $completedSessions->count() > 0;
                @endphp
                
                @if($hasCompleted)
                <div class="inline-flex flex-col items-center gap-4">
                    <div class="px-8 py-4 bg-green-100 text-green-800 rounded-2xl font-semibold">
                        <i class="bi bi-check-circle-fill me-2"></i> Anda telah menyelesaikan ujian
                    </div>
                    <a href="{{ route('berita.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                        <i class="bi bi-newspaper me-2"></i> Lihat Pengumuman Hasil
                    </a>
                </div>
                @else
                <button type="submit" class="inline-flex items-center justify-center px-12 py-5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl font-bold text-xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                    <i class="bi bi-play-circle me-3 text-2xl"></i> Mulai Ujian
                </button>
                @endif
            </div>
        </form>
    </div>
</div>

@if(session('error'))
<script>
    alert('{{ session('error') }}');
</script>
@endif
@endsection
