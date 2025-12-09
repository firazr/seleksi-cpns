@extends('layouts.app')

@section('title', 'Hasil Ujian CPNS')

@push('styles')
<!-- MathJax untuk rumus matematika -->
<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
@endpush

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <!-- Result Card -->
    <div class="glass-white rounded-3xl p-8 text-center" data-aos="fade-up">
        <!-- Header -->
        <div class="mb-8">
            @php
                // Passing Grade CPNS: TWK >= 65, TIU >= 80, TKP >= 166, Total >= 311
                $twkPass = ($session->score_twk ?? 0) >= 65;
                $tiuPass = ($session->score_tiu ?? 0) >= 80;
                $tkpPass = ($session->score_tkp ?? 0) >= 166;
                $totalScore = $session->score ?? 0;
                $isPassed = $twkPass && $tiuPass && $tkpPass && $totalScore >= 311;
            @endphp
            
            @if($isPassed)
            <div class="w-24 h-24 mx-auto bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center mb-4">
                <i class="bi bi-trophy-fill text-5xl text-white"></i>
            </div>
            <h2 class="text-3xl font-bold text-white mb-2">Selamat! 🎉</h2>
            <p class="text-green-400">Anda telah lulus dengan memenuhi semua passing grade!</p>
            @else
            <div class="w-24 h-24 mx-auto bg-gradient-to-br from-red-500 to-pink-600 rounded-full flex items-center justify-center mb-4">
                <i class="bi bi-emoji-frown-fill text-5xl text-white"></i>
            </div>
            <h2 class="text-3xl font-bold text-white mb-2">Tetap Semangat!</h2>
            <p class="text-red-400">Anda belum memenuhi passing grade. Terus berlatih!</p>
            @endif
        </div>
        
        <!-- Total Score Display -->
        <div class="glass-card rounded-2xl p-6 mb-8 inline-block" style="background: rgba(255,255,255,0.1);">
            <div class="text-6xl font-bold mb-2 {{ $isPassed ? 'text-green-400' : 'text-red-400' }}">
                {{ number_format($totalScore, 0) }}
            </div>
            <div class="text-white/60">Nilai Total</div>
            <div class="text-xs text-white/40 mt-1">Passing Grade: 311</div>
        </div>
        
        <!-- Score Per Category -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <!-- TWK Score -->
            <div class="glass-white rounded-2xl p-5 {{ $twkPass ? 'border-2 border-green-500/50' : 'border-2 border-red-500/50' }}">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-white/60 text-sm">TWK</span>
                    @if($twkPass)
                    <span class="px-2 py-0.5 bg-green-500/20 text-green-400 text-xs rounded-full">LULUS</span>
                    @else
                    <span class="px-2 py-0.5 bg-red-500/20 text-red-400 text-xs rounded-full">TIDAK LULUS</span>
                    @endif
                </div>
                <div class="text-3xl font-bold {{ $twkPass ? 'text-green-400' : 'text-red-400' }}">
                    {{ $session->score_twk ?? 0 }}
                </div>
                <div class="text-white/40 text-xs mt-1">Passing Grade: 65</div>
                <div class="text-white/60 text-xs mt-2">Wawasan Kebangsaan</div>
            </div>
            
            <!-- TIU Score -->
            <div class="glass-white rounded-2xl p-5 {{ $tiuPass ? 'border-2 border-green-500/50' : 'border-2 border-red-500/50' }}">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-white/60 text-sm">TIU</span>
                    @if($tiuPass)
                    <span class="px-2 py-0.5 bg-green-500/20 text-green-400 text-xs rounded-full">LULUS</span>
                    @else
                    <span class="px-2 py-0.5 bg-red-500/20 text-red-400 text-xs rounded-full">TIDAK LULUS</span>
                    @endif
                </div>
                <div class="text-3xl font-bold {{ $tiuPass ? 'text-green-400' : 'text-red-400' }}">
                    {{ $session->score_tiu ?? 0 }}
                </div>
                <div class="text-white/40 text-xs mt-1">Passing Grade: 80</div>
                <div class="text-white/60 text-xs mt-2">Intelegensia Umum</div>
            </div>
            
            <!-- TKP Score -->
            <div class="glass-white rounded-2xl p-5 {{ $tkpPass ? 'border-2 border-green-500/50' : 'border-2 border-red-500/50' }}">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-white/60 text-sm">TKP</span>
                    @if($tkpPass)
                    <span class="px-2 py-0.5 bg-green-500/20 text-green-400 text-xs rounded-full">LULUS</span>
                    @else
                    <span class="px-2 py-0.5 bg-red-500/20 text-red-400 text-xs rounded-full">TIDAK LULUS</span>
                    @endif
                </div>
                <div class="text-3xl font-bold {{ $tkpPass ? 'text-green-400' : 'text-red-400' }}">
                    {{ $session->score_tkp ?? 0 }}
                </div>
                <div class="text-white/40 text-xs mt-1">Passing Grade: 166</div>
                <div class="text-white/60 text-xs mt-2">Karakteristik Pribadi</div>
            </div>
        </div>
        
        <!-- Summary Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="glass-white rounded-xl p-4">
                <div class="text-2xl font-bold text-white">Paket Lengkap</div>
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
            <a href="#pembahasan" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:-translate-y-0.5 hover:shadow-lg transition-all">
                <i class="bi bi-book mr-2"></i> Lihat Pembahasan
            </a>
            <a href="{{ route('home') }}" class="px-8 py-3 border border-white/30 text-white font-semibold rounded-xl hover:bg-white/10 transition-all">
                <i class="bi bi-house mr-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
    
    <!-- Pembahasan Section -->
    <div id="pembahasan" class="glass-white rounded-3xl p-8 mt-6" data-aos="fade-up" data-aos-delay="100">
        <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
            <i class="bi bi-journal-check text-blue-400"></i>
            Pembahasan Jawaban
        </h3>
        
        <!-- Category Tabs for Pembahasan -->
        <div class="flex flex-wrap gap-2 mb-6 border-b border-white/20 pb-4">
            <button type="button" class="pembahasan-tab px-4 py-2 rounded-lg text-sm font-medium bg-blue-500 text-white" data-category="TWK">
                <i class="bi bi-book me-1"></i> TWK
            </button>
            <button type="button" class="pembahasan-tab px-4 py-2 rounded-lg text-sm font-medium bg-white/10 text-white/70 hover:bg-white/20" data-category="TIU">
                <i class="bi bi-lightbulb me-1"></i> TIU
            </button>
            <button type="button" class="pembahasan-tab px-4 py-2 rounded-lg text-sm font-medium bg-white/10 text-white/70 hover:bg-white/20" data-category="TKP">
                <i class="bi bi-person-check me-1"></i> TKP
            </button>
        </div>
        
        @php
            $groupedResults = collect($questionResults)->groupBy('category');
        @endphp
        
        @foreach(['TWK', 'TIU', 'TKP'] as $category)
        <div class="pembahasan-content {{ $category !== 'TWK' ? 'hidden' : '' }}" data-category="{{ $category }}">
            <h4 class="text-lg font-semibold text-white/80 mb-4">{{ $category }} - 
                @if($category === 'TWK') Wawasan Kebangsaan
                @elseif($category === 'TIU') Intelegensia Umum
                @else Karakteristik Pribadi
                @endif
            </h4>
            
            <div class="space-y-6">
                @foreach($groupedResults[$category] ?? [] as $index => $result)
                <div class="rounded-2xl p-5 {{ $result['is_correct'] ? 'bg-green-500/10 border border-green-500/30' : 'bg-red-500/10 border border-red-500/30' }}">
                    <!-- Question Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold {{ $result['is_correct'] ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ $index + 1 }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $result['is_correct'] ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                @if($result['is_correct'])
                                    <i class="bi bi-check-circle-fill mr-1"></i> Benar
                                @else
                                    <i class="bi bi-x-circle-fill mr-1"></i> Salah
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <!-- Question Text -->
                    <div class="mb-4">
                        @if($result['image_path'])
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $result['image_path']) }}" alt="Gambar Soal" class="max-w-full h-auto rounded-lg max-h-48">
                        </div>
                        @endif
                        <p class="text-white/90 {{ $result['is_math'] ? 'math-content' : '' }}">
                            {{ $result['question_text'] }}
                        </p>
                        @if($result['is_math'] && $result['math_latex'])
                        <div class="mt-2 p-3 bg-white/10 rounded-lg">
                            <span class="math-latex">$${{ $result['math_latex'] }}$$</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Options -->
                    <div class="grid gap-2 mb-4">
                        @foreach(['a', 'b', 'c', 'd'] as $opt)
                        @php
                            $optionText = $result['options'][$opt] ?? '';
                            $isUserAnswer = strtolower($result['user_answer'] ?? '') === $opt;
                            $isCorrectAnswer = strtolower($result['correct_answer'] ?? '') === $opt;
                            
                            if ($isCorrectAnswer) {
                                $optionClass = 'bg-green-500/20 border-green-500 text-green-400';
                                $iconClass = 'bi-check-circle-fill text-green-400';
                            } elseif ($isUserAnswer && !$isCorrectAnswer) {
                                $optionClass = 'bg-red-500/20 border-red-500 text-red-400';
                                $iconClass = 'bi-x-circle-fill text-red-400';
                            } else {
                                $optionClass = 'bg-white/5 border-white/20 text-white/70';
                                $iconClass = '';
                            }
                        @endphp
                        <div class="flex items-center gap-3 p-3 rounded-lg border {{ $optionClass }}">
                            <span class="w-8 h-8 rounded-full flex items-center justify-center font-semibold text-sm {{ $isCorrectAnswer ? 'bg-green-500 text-white' : ($isUserAnswer ? 'bg-red-500 text-white' : 'bg-white/10 text-white/60') }}">
                                {{ strtoupper($opt) }}
                            </span>
                            <span class="flex-1">{{ $optionText }}</span>
                            @if($iconClass)
                            <i class="bi {{ $iconClass }}"></i>
                            @endif
                            @if($isUserAnswer)
                            <span class="text-xs px-2 py-0.5 rounded bg-white/10">(Jawaban Anda)</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Answer Summary -->
                    <div class="flex flex-wrap gap-4 text-sm pt-3 border-t border-white/10">
                        <div class="flex items-center gap-2">
                            <span class="text-white/60">Jawaban Anda:</span>
                            @if($result['user_answer'])
                            <span class="font-semibold {{ $result['is_correct'] ? 'text-green-400' : 'text-red-400' }}">
                                {{ strtoupper($result['user_answer']) }}
                            </span>
                            @else
                            <span class="text-yellow-400">Tidak dijawab</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-white/60">Jawaban Benar:</span>
                            <span class="font-semibold text-green-400">{{ strtoupper($result['correct_answer']) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
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

@push('scripts')
<script>
    // Pembahasan tabs
    document.querySelectorAll('.pembahasan-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Update tab styles
            document.querySelectorAll('.pembahasan-tab').forEach(t => {
                t.classList.remove('bg-blue-500', 'text-white');
                t.classList.add('bg-white/10', 'text-white/70');
            });
            this.classList.remove('bg-white/10', 'text-white/70');
            this.classList.add('bg-blue-500', 'text-white');
            
            // Show/hide content
            document.querySelectorAll('.pembahasan-content').forEach(content => {
                if (content.dataset.category === category) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });
            
            // Re-render MathJax
            if (typeof MathJax !== 'undefined') {
                MathJax.typesetPromise();
            }
        });
    });
</script>
@endpush
@endsection
