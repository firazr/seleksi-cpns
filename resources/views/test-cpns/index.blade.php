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
                    
                    <!-- Kategori Test -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-4">
                            <i class="bi bi-list-check me-1"></i> Pilih Kategori Test
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative">
                                <input type="radio" name="category" value="TWK" class="peer sr-only" required>
                                <div class="p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-gray-300">
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                                            <i class="bi bi-book text-blue-600 text-xl"></i>
                                        </div>
                                        <h4 class="font-semibold text-gray-900">TWK</h4>
                                        <p class="text-xs text-gray-500">Wawasan Kebangsaan</p>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="relative">
                                <input type="radio" name="category" value="TIU" class="peer sr-only">
                                <div class="p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition-all peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-gray-300">
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                                            <i class="bi bi-lightbulb text-green-600 text-xl"></i>
                                        </div>
                                        <h4 class="font-semibold text-gray-900">TIU</h4>
                                        <p class="text-xs text-gray-500">Intelegensia Umum</p>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="relative">
                                <input type="radio" name="category" value="TKP" class="peer sr-only">
                                <div class="p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition-all peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:border-gray-300">
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                                            <i class="bi bi-person-check text-purple-600 text-xl"></i>
                                        </div>
                                        <h4 class="font-semibold text-gray-900">TKP</h4>
                                        <p class="text-xs text-gray-500">Karakteristik Pribadi</p>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="relative">
                                <input type="radio" name="category" value="full" class="peer sr-only">
                                <div class="p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition-all peer-checked:border-orange-500 peer-checked:bg-orange-50 hover:border-gray-300">
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                                            <i class="bi bi-collection text-orange-600 text-xl"></i>
                                        </div>
                                        <h4 class="font-semibold text-gray-900">Paket Lengkap</h4>
                                        <p class="text-xs text-gray-500">TWK + TIU + TKP</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
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
                <button type="submit" class="inline-flex items-center justify-center px-12 py-5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl font-bold text-xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                    <i class="bi bi-play-circle me-3 text-2xl"></i> Mulai Test
                </button>
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
