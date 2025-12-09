@extends('layouts.quiz')

@section('title', 'Ujian CPNS - Paket Lengkap')

@section('timer-info', 'Paket Lengkap - ' . $session->domisili_penempatan)

@php
    $totalQuestions = count($shuffledQuestions);
    $categories = ['TWK', 'TIU', 'TKP'];
@endphp

@section('content')
<div class="max-w-6xl mx-auto px-4 pt-20">
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-5">
            <!-- Category Tabs -->
            <div class="glass-white rounded-2xl p-4">
                <div class="flex flex-wrap gap-2">
                    @foreach($categories as $catIdx => $cat)
                    @php
                        $catQuestions = collect($shuffledQuestions)->where('category', $cat);
                        $catStart = 0;
                        foreach($categories as $i => $c) {
                            if ($c === $cat) break;
                            $catStart += collect($shuffledQuestions)->where('category', $c)->count();
                        }
                    @endphp
                    <button type="button" 
                        onclick="goToCategory('{{ $cat }}')" 
                        id="catTab-{{ $cat }}"
                        class="category-tab px-4 py-2 rounded-xl font-semibold transition-all {{ $catIdx === 0 ? 'bg-blue-600 text-white' : 'bg-white/10 text-white/70 hover:bg-white/20' }}"
                        data-start="{{ $catStart }}">
                        <i class="bi bi-{{ $cat === 'TWK' ? 'book' : ($cat === 'TIU' ? 'lightbulb' : 'person-check') }} mr-1"></i>
                        {{ $cat }}
                        <span class="ml-1 text-xs opacity-70">({{ $catQuestions->count() }})</span>
                    </button>
                    @endforeach
                </div>
            </div>
            
            <!-- Progress Info -->
            <div class="glass-white rounded-2xl p-5">
                <div class="flex justify-between text-white mb-3">
                    <span>Progres Pengerjaan</span>
                    <span id="progressText">0 / {{ $totalQuestions }} Soal Dijawab</span>
                </div>
                <div class="h-3 rounded-full bg-white/20 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-green-500 to-emerald-400 rounded-full transition-all duration-300" id="progressBar" style="width: 0%"></div>
                </div>
            </div>
            
            <!-- Question Card -->
            <form id="quizForm" action="{{ route('quiz.submit', $session->id) }}" method="POST">
                @csrf
                
                @foreach($shuffledQuestions as $index => $question)
                <div class="question-card glass-white rounded-2xl p-6 question-slide {{ $index > 0 ? 'hidden' : '' }}" id="question-{{ $index }}" data-category="{{ $question['category'] }}">
                    <span class="inline-block px-5 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-full font-semibold text-sm mb-4">
                        Soal {{ $index + 1 }} dari {{ $totalQuestions }}
                    </span>
                    
                    <div class="flex justify-between items-start mb-4 gap-4">
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                {{ $question['category'] === 'TWK' ? 'bg-blue-500/30 text-blue-200' : '' }}
                                {{ $question['category'] === 'TIU' ? 'bg-green-500/30 text-green-200' : '' }}
                                {{ $question['category'] === 'TKP' ? 'bg-purple-500/30 text-purple-200' : '' }}">
                                {{ $question['category'] }}
                            </span>
                            @if($question['is_math'] ?? false)
                            <span class="px-3 py-1 bg-purple-500/30 text-purple-200 rounded-full text-sm font-medium">
                                <i class="bi bi-calculator me-1"></i> Matematika
                            </span>
                            @endif
                        </div>
                        <button type="button" class="btn-flag px-4 py-2 rounded-xl bg-yellow-500/30 border border-yellow-500/50 text-white hover:bg-yellow-500/50 transition-all text-sm font-medium" id="flagBtn-{{ $index }}" onclick="toggleFlag({{ $index }})">
                            <i class="bi bi-flag mr-1"></i> Tandai Ragu
                        </button>
                    </div>
                    
                    <!-- Question Image -->
                    @if(!empty($question['image_path']))
                    <div class="mb-4 rounded-xl overflow-hidden bg-white/10 p-2">
                        <img src="{{ asset('storage/' . $question['image_path']) }}" 
                             alt="Gambar Soal {{ $index + 1 }}" 
                             class="max-w-full h-auto max-h-64 mx-auto rounded-lg">
                    </div>
                    @endif
                    
                    <div class="question-text text-lg text-white mb-6 leading-relaxed">
                        {!! nl2br(e($question['question_text'])) !!}
                    </div>
                    
                    @if(($question['is_math'] ?? false) && !empty($question['math_latex']))
                    <div class="mb-4 p-3 bg-white/10 rounded-lg">
                        <span class="math-latex">$${{ $question['math_latex'] }}$$</span>
                    </div>
                    @endif
                    
                    <!-- Shuffled Options -->
                    <div class="space-y-3">
                        @foreach(['a', 'b', 'c', 'd'] as $optKey)
                        <div class="option-item flex items-center gap-4 p-4 rounded-xl bg-white/10 border-2 border-white/20 cursor-pointer hover:bg-white/20 hover:border-white/40 hover:translate-x-1 transition-all" onclick="selectOption({{ $index }}, '{{ $optKey }}')">
                            <div class="option-label w-10 h-10 rounded-full bg-white/20 flex items-center justify-center font-bold text-white flex-shrink-0">{{ strtoupper($optKey) }}</div>
                            <div class="option-text text-white flex-grow">{!! nl2br(e($question['options'][$optKey] ?? '')) !!}</div>
                            <input type="radio" name="answers[{{ $index }}]" value="{{ $optKey }}" class="hidden answer-input" data-index="{{ $index }}" {{ ($answers[$index] ?? '') === $optKey ? 'checked' : '' }}>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-between gap-3 mt-5">
                    <button type="button" class="px-8 py-3 rounded-xl bg-white/20 border border-white/30 text-white font-semibold hover:-translate-y-0.5 hover:shadow-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed" id="prevBtn" onclick="prevQuestion()" disabled>
                        <i class="bi bi-arrow-left mr-2"></i> Sebelumnya
                    </button>
                    <button type="button" class="px-8 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold hover:-translate-y-0.5 hover:shadow-lg transition-all" id="nextBtn" onclick="nextQuestion()">
                        Selanjutnya <i class="bi bi-arrow-right ml-2"></i>
                    </button>
                    <button type="button" class="px-8 py-3 rounded-xl bg-gradient-to-r from-green-600 to-emerald-500 text-white font-semibold hover:-translate-y-0.5 hover:shadow-lg transition-all hidden" id="submitBtn" onclick="confirmSubmit()">
                        <i class="bi bi-send mr-2"></i> Selesai & Kumpulkan
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Sidebar - Navigation -->
        <div class="space-y-5">
            <!-- Navigation per Category -->
            @foreach($categories as $cat)
            <div class="glass-white rounded-2xl p-5 category-nav" id="catNav-{{ $cat }}">
                <h5 class="text-white font-semibold mb-4 flex items-center gap-2">
                    <i class="bi bi-{{ $cat === 'TWK' ? 'book' : ($cat === 'TIU' ? 'lightbulb' : 'person-check') }}"></i> 
                    {{ $cat }}
                </h5>
                <div class="flex flex-wrap gap-2">
                    @php $catNumber = 1; @endphp
                    @foreach($shuffledQuestions as $index => $q)
                        @if($q['category'] === $cat)
                        <button type="button" 
                            class="nav-btn w-10 h-10 rounded-lg border-2 border-white/30 bg-white/10 text-white font-semibold hover:bg-white/30 hover:scale-105 transition-all text-sm {{ $index === 0 ? 'active' : '' }}" 
                            id="navBtn-{{ $index }}" 
                            onclick="goToQuestion({{ $index }})"
                            title="Soal {{ $index + 1 }}">
                            {{ $catNumber++ }}
                        </button>
                        @endif
                    @endforeach
                </div>
            </div>
            @endforeach
            
            <!-- Legend -->
            <div class="glass-white rounded-2xl p-5">
                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center gap-2 text-sm text-white">
                        <div class="w-5 h-5 rounded bg-blue-600 border-2 border-blue-600"></div>
                        <span>Aktif</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-white">
                        <div class="w-5 h-5 rounded bg-green-600 border-2 border-green-600"></div>
                        <span>Dijawab</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-white">
                        <div class="w-5 h-5 rounded bg-yellow-500 border-2 border-yellow-500"></div>
                        <span>Ragu</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Submit Confirmation Modal -->
<div class="fixed inset-0 z-[1001] hidden" id="submitModal">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeSubmitModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md glass-white rounded-2xl shadow-2xl relative">
            <div class="p-6 border-b border-white/20">
                <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                    <i class="bi bi-check-circle"></i> Konfirmasi Submit
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-white">Apakah Anda yakin ingin mengumpulkan jawaban?</p>
                <div class="bg-yellow-500/30 border border-yellow-500/50 rounded-xl p-4 text-white">
                    <strong class="flex items-center gap-2 mb-2">
                        <i class="bi bi-exclamation-triangle"></i> Ringkasan
                    </strong>
                    <ul class="text-sm space-y-1 mt-2">
                        <li>Terjawab: <span id="answeredCount" class="font-semibold">0</span> soal</li>
                        <li>Belum dijawab: <span id="unansweredCount" class="font-semibold">{{ $totalQuestions }}</span> soal</li>
                        <li>Ditandai ragu: <span id="flaggedCount" class="font-semibold">0</span> soal</li>
                    </ul>
                </div>
            </div>
            <div class="p-6 border-t border-white/20 flex gap-3 justify-end">
                <button type="button" onclick="closeSubmitModal()" class="px-6 py-2.5 rounded-xl border border-white/30 text-white hover:bg-white/10 transition-all">
                    Periksa Kembali
                </button>
                <button type="button" onclick="submitQuiz()" class="px-6 py-2.5 rounded-xl bg-green-600 text-white font-semibold hover:bg-green-700 transition-all">
                    <i class="bi bi-send mr-2"></i> Ya, Kumpulkan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Time Warning Modal -->
<div class="fixed inset-0 z-[1002] hidden" id="timeWarningModal">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-sm bg-red-600/90 backdrop-blur-xl rounded-2xl shadow-2xl p-8 text-center text-white">
            <i class="bi bi-exclamation-triangle text-6xl mb-4"></i>
            <h4 class="text-2xl font-bold mb-2">Waktu Hampir Habis!</h4>
            <p class="text-white/80 mb-6">Tersisa kurang dari 5 menit.</p>
            <button type="button" onclick="closeTimeWarning()" class="px-8 py-3 bg-white text-red-600 font-semibold rounded-xl hover:bg-gray-100 transition-all">
                Mengerti
            </button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .nav-btn.active { background: rgba(37, 99, 235, 0.8) !important; border-color: rgb(37, 99, 235) !important; }
    .nav-btn.answered { background: rgba(22, 163, 74, 0.8) !important; border-color: rgb(22, 163, 74) !important; }
    .nav-btn.flagged { background: rgba(234, 179, 8, 0.8) !important; border-color: rgb(234, 179, 8) !important; color: #1f2937 !important; }
    .option-item.selected { background: rgba(59, 130, 246, 0.3) !important; border-color: rgb(59, 130, 246) !important; }
    .option-item.selected .option-label { background: rgb(37, 99, 235) !important; }
    .btn-flag.flagged { background: rgba(234, 179, 8, 0.8) !important; color: #1f2937 !important; }
    .category-tab.active { background: rgb(37, 99, 235) !important; color: white !important; }
    .timer-box.warning { background: rgba(251, 191, 36, 0.3) !important; }
    .timer-box.danger { background: rgba(239, 68, 68, 0.3) !important; animation: pulse 1s infinite; }
    @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.02); } }
</style>
@endpush

@push('scripts')
<script>
    const totalQuestions = {{ $totalQuestions }};
    let currentQuestion = 0;
    let answers = @json($answers);
    let flagged = new Set();
    let timeWarningShown = false;
    let timeLeft = {{ $session->remaining_time }};
    
    // Initialize answered questions
    document.addEventListener('DOMContentLoaded', function() {
        Object.keys(answers).forEach(idx => {
            const i = parseInt(idx);
            const navBtn = document.getElementById('navBtn-' + i);
            if (navBtn) navBtn.classList.add('answered');
            
            const option = answers[idx];
            const questionCard = document.getElementById('question-' + i);
            if (questionCard) {
                const optItem = questionCard.querySelector(`input[value="${option}"]`);
                if (optItem) optItem.closest('.option-item').classList.add('selected');
            }
        });
        updateProgress();
    });
    
    function updateTimer() {
        const hours = Math.floor(timeLeft / 3600);
        const minutes = Math.floor((timeLeft % 3600) / 60);
        const seconds = timeLeft % 60;
        
        document.getElementById('timerDisplay').textContent = 
            String(hours).padStart(2, '0') + ':' + 
            String(minutes).padStart(2, '0') + ':' + 
            String(seconds).padStart(2, '0');
        
        const fixedTimer = document.getElementById('fixedTimer');
        if (timeLeft <= 300 && timeLeft > 60) {
            fixedTimer.classList.add('warning');
            if (!timeWarningShown) {
                timeWarningShown = true;
                document.getElementById('timeWarningModal').classList.remove('hidden');
            }
        } else if (timeLeft <= 60) {
            fixedTimer.classList.add('danger');
        }
        
        if (timeLeft <= 0) {
            alert('Waktu habis! Jawaban akan dikumpulkan otomatis.');
            submitQuiz();
            return;
        }
        
        timeLeft--;
        setTimeout(updateTimer, 1000);
    }
    updateTimer();
    
    function goToQuestion(index) {
        document.querySelectorAll('.question-slide').forEach(q => q.classList.add('hidden'));
        document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
        
        document.getElementById('question-' + index).classList.remove('hidden');
        document.getElementById('navBtn-' + index).classList.add('active');
        
        // Update category tab
        const cat = document.getElementById('question-' + index).dataset.category;
        document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active', 'bg-blue-600', 'text-white'));
        document.querySelectorAll('.category-tab').forEach(t => t.classList.add('bg-white/10', 'text-white/70'));
        const catTab = document.getElementById('catTab-' + cat);
        if (catTab) {
            catTab.classList.add('active', 'bg-blue-600', 'text-white');
            catTab.classList.remove('bg-white/10', 'text-white/70');
        }
        
        currentQuestion = index;
        updateButtons();
        
        if (typeof MathJax !== 'undefined' && MathJax.typesetPromise) {
            MathJax.typesetPromise([document.getElementById('question-' + index)]);
        }
    }
    
    function goToCategory(cat) {
        const catTab = document.getElementById('catTab-' + cat);
        const startIdx = parseInt(catTab.dataset.start);
        goToQuestion(startIdx);
    }
    
    function nextQuestion() {
        if (currentQuestion < totalQuestions - 1) goToQuestion(currentQuestion + 1);
    }
    
    function prevQuestion() {
        if (currentQuestion > 0) goToQuestion(currentQuestion - 1);
    }
    
    function updateButtons() {
        document.getElementById('prevBtn').disabled = currentQuestion === 0;
        if (currentQuestion === totalQuestions - 1) {
            document.getElementById('nextBtn').classList.add('hidden');
            document.getElementById('submitBtn').classList.remove('hidden');
        } else {
            document.getElementById('nextBtn').classList.remove('hidden');
            document.getElementById('submitBtn').classList.add('hidden');
        }
    }
    
    function selectOption(questionIndex, option) {
        const questionCard = document.getElementById('question-' + questionIndex);
        questionCard.querySelectorAll('.option-item').forEach(opt => opt.classList.remove('selected'));
        
        questionCard.querySelectorAll('.option-item').forEach(opt => {
            const radio = opt.querySelector('input[type="radio"]');
            if (radio.value === option) {
                opt.classList.add('selected');
                radio.checked = true;
            }
        });
        
        answers[questionIndex] = option;
        
        const navBtn = document.getElementById('navBtn-' + questionIndex);
        if (!flagged.has(questionIndex)) navBtn.classList.add('answered');
        
        updateProgress();
        saveAnswer(questionIndex, option);
    }
    
    function saveAnswer(index, answer) {
        fetch('{{ route("quiz.answer", $session->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ question_index: index, answer: answer })
        });
    }
    
    function toggleFlag(index) {
        const flagBtn = document.getElementById('flagBtn-' + index);
        const navBtn = document.getElementById('navBtn-' + index);
        
        if (flagged.has(index)) {
            flagged.delete(index);
            flagBtn.classList.remove('flagged');
            navBtn.classList.remove('flagged');
            if (answers[index]) navBtn.classList.add('answered');
        } else {
            flagged.add(index);
            flagBtn.classList.add('flagged');
            navBtn.classList.remove('answered');
            navBtn.classList.add('flagged');
        }
    }
    
    function updateProgress() {
        const answered = Object.keys(answers).length;
        document.getElementById('progressBar').style.width = (answered / totalQuestions * 100) + '%';
        document.getElementById('progressText').textContent = answered + ' / ' + totalQuestions + ' Soal Dijawab';
    }
    
    function confirmSubmit() {
        const answered = Object.keys(answers).length;
        document.getElementById('answeredCount').textContent = answered;
        document.getElementById('unansweredCount').textContent = totalQuestions - answered;
        document.getElementById('flaggedCount').textContent = flagged.size;
        document.getElementById('submitModal').classList.remove('hidden');
    }
    
    function closeSubmitModal() { document.getElementById('submitModal').classList.add('hidden'); }
    function closeTimeWarning() { document.getElementById('timeWarningModal').classList.add('hidden'); }
    
    function submitQuiz() {
        window.removeEventListener('beforeunload', beforeUnloadHandler);
        document.getElementById('quizForm').submit();
    }
    
    function beforeUnloadHandler(e) {
        e.preventDefault();
        e.returnValue = 'Anda yakin ingin meninggalkan halaman?';
    }
    window.addEventListener('beforeunload', beforeUnloadHandler);
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') prevQuestion();
        else if (e.key === 'ArrowRight') nextQuestion();
    });
</script>
@endpush
