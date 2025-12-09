@extends('layouts.quiz')

@section('title', 'Quiz ' . $session->category)

@section('timer-info', $session->category . ' - ' . $session->domisili_penempatan)

@section('content')
<div class="max-w-6xl mx-auto px-4 pt-20">
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-5">
            <!-- Accessibility Controls -->
            <div class="glass-white rounded-2xl p-5">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-3">
                        <label class="text-white font-medium flex items-center gap-2">
                            <i class="bi bi-type"></i> Ukuran Teks:
                        </label>
                        <button type="button" onclick="decreaseFontSize()" 
                            class="w-10 h-10 rounded-lg bg-white/10 border border-white/30 text-white font-bold hover:bg-white/30 transition-all" title="Perkecil">
                            A-
                        </button>
                        <span class="text-white min-w-[50px] text-center" id="fontSizeIndicator">100%</span>
                        <button type="button" onclick="increaseFontSize()" 
                            class="w-10 h-10 rounded-lg bg-white/10 border border-white/30 text-white font-bold hover:bg-white/30 transition-all" title="Perbesar">
                            A+
                        </button>
                    </div>
                    <button type="button" class="px-5 py-2 rounded-lg bg-white/10 border border-white/30 text-white hover:bg-white/30 transition-all" id="contrastToggle" onclick="toggleContrast()">
                        <i class="bi bi-circle-half mr-2"></i> Kontras Tinggi
                    </button>
                </div>
            </div>
            
            <!-- Progress Info -->
            <div class="glass-white rounded-2xl p-5">
                <div class="flex justify-between text-white mb-3">
                    <span>Progres Pengerjaan</span>
                    <span id="progressText">0 / {{ count($questions) }} Soal Dijawab</span>
                </div>
                <div class="h-3 rounded-full bg-white/20 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-green-500 to-emerald-400 rounded-full transition-all duration-300" id="progressBar" style="width: 0%"></div>
                </div>
            </div>
            
            <!-- Question Card -->
            <form id="quizForm" action="{{ route('quiz.submit', $session->id) }}" method="POST">
                @csrf
                
                @foreach($questions as $index => $question)
                <div class="question-card glass-white rounded-2xl p-6 question-slide {{ $index > 0 ? 'hidden' : '' }}" id="question-{{ $index }}">
                    <span class="inline-block px-5 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-full font-semibold text-sm mb-4">
                        Soal {{ $index + 1 }} dari {{ count($questions) }}
                    </span>
                    
                    <div class="flex justify-between items-start mb-4 gap-4">
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 bg-blue-500/30 text-blue-200 rounded-full text-sm font-medium">{{ $question->category }}</span>
                            @if($question->is_math)
                            <span class="px-3 py-1 bg-purple-500/30 text-purple-200 rounded-full text-sm font-medium">
                                <i class="bi bi-calculator me-1"></i> Matematika
                            </span>
                            @endif
                        </div>
                        <button type="button" class="btn-flag px-4 py-2 rounded-xl bg-yellow-500/30 border border-yellow-500/50 text-white hover:bg-yellow-500/50 transition-all text-sm font-medium" id="flagBtn-{{ $index }}" onclick="toggleFlag({{ $index }})">
                            <i class="bi bi-flag mr-1"></i> Tandai Ragu
                        </button>
                    </div>
                    
                    <!-- Question Image (if exists) -->
                    @if($question->image_path)
                    <div class="mb-4 rounded-xl overflow-hidden bg-white/10 p-2">
                        <img src="{{ asset('storage/' . $question->image_path) }}" 
                             alt="Gambar Soal {{ $index + 1 }}" 
                             class="max-w-full h-auto max-h-64 mx-auto rounded-lg">
                    </div>
                    @endif
                    
                    <div class="question-text text-lg text-white mb-6 leading-relaxed" id="questionText-{{ $index }}">
                        {!! nl2br(e($question->question_text)) !!}
                    </div>
                    
                    <div class="space-y-3">
                        <div class="option-item flex items-center gap-4 p-4 rounded-xl bg-white/10 border-2 border-white/20 cursor-pointer hover:bg-white/20 hover:border-white/40 hover:translate-x-1 transition-all" onclick="selectOption({{ $index }}, 'a')">
                            <div class="option-label w-10 h-10 rounded-full bg-white/20 flex items-center justify-center font-bold text-white flex-shrink-0">A</div>
                            <div class="option-text text-white flex-grow">{!! nl2br(e($question->option_a)) !!}</div>
                            <input type="radio" name="answers[{{ $question->id }}]" value="a" class="hidden answer-input" data-index="{{ $index }}">
                        </div>
                        <div class="option-item flex items-center gap-4 p-4 rounded-xl bg-white/10 border-2 border-white/20 cursor-pointer hover:bg-white/20 hover:border-white/40 hover:translate-x-1 transition-all" onclick="selectOption({{ $index }}, 'b')">
                            <div class="option-label w-10 h-10 rounded-full bg-white/20 flex items-center justify-center font-bold text-white flex-shrink-0">B</div>
                            <div class="option-text text-white flex-grow">{!! nl2br(e($question->option_b)) !!}</div>
                            <input type="radio" name="answers[{{ $question->id }}]" value="b" class="hidden answer-input" data-index="{{ $index }}">
                        </div>
                        <div class="option-item flex items-center gap-4 p-4 rounded-xl bg-white/10 border-2 border-white/20 cursor-pointer hover:bg-white/20 hover:border-white/40 hover:translate-x-1 transition-all" onclick="selectOption({{ $index }}, 'c')">
                            <div class="option-label w-10 h-10 rounded-full bg-white/20 flex items-center justify-center font-bold text-white flex-shrink-0">C</div>
                            <div class="option-text text-white flex-grow">{!! nl2br(e($question->option_c)) !!}</div>
                            <input type="radio" name="answers[{{ $question->id }}]" value="c" class="hidden answer-input" data-index="{{ $index }}">
                        </div>
                        <div class="option-item flex items-center gap-4 p-4 rounded-xl bg-white/10 border-2 border-white/20 cursor-pointer hover:bg-white/20 hover:border-white/40 hover:translate-x-1 transition-all" onclick="selectOption({{ $index }}, 'd')">
                            <div class="option-label w-10 h-10 rounded-full bg-white/20 flex items-center justify-center font-bold text-white flex-shrink-0">D</div>
                            <div class="option-text text-white flex-grow">{!! nl2br(e($question->option_d)) !!}</div>
                            <input type="radio" name="answers[{{ $question->id }}]" value="d" class="hidden answer-input" data-index="{{ $index }}">
                        </div>
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
            <div class="glass-white rounded-2xl p-5">
                <h5 class="text-white font-semibold mb-4 flex items-center gap-2">
                    <i class="bi bi-grid-3x3-gap"></i> Navigasi Soal
                </h5>
                <div class="flex flex-wrap gap-2" id="questionNavButtons">
                    @foreach($questions as $index => $question)
                    <button type="button" class="nav-btn w-11 h-11 rounded-lg border-2 border-white/30 bg-white/10 text-white font-semibold hover:bg-white/30 hover:scale-105 transition-all {{ $index === 0 ? 'active' : '' }}" id="navBtn-{{ $index }}" onclick="goToQuestion({{ $index }})">
                        {{ $index + 1 }}
                    </button>
                    @endforeach
                </div>
                
                <div class="flex flex-wrap gap-4 mt-5 pt-5 border-t border-white/20">
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
                        <span>Ragu-ragu</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-white">
                        <div class="w-5 h-5 rounded bg-white/10 border-2 border-white/30"></div>
                        <span>Belum</span>
                    </div>
                </div>
            </div>
            
            <!-- Info Box -->
            <div class="glass-white rounded-2xl p-5">
                <h5 class="text-white font-semibold mb-4 flex items-center gap-2">
                    <i class="bi bi-info-circle"></i> Informasi
                </h5>
                <ul class="text-white/70 text-sm space-y-2">
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle text-green-400 mt-0.5"></i>
                        Klik pilihan jawaban untuk memilih
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle text-green-400 mt-0.5"></i>
                        Gunakan tombol "Tandai Ragu" jika belum yakin
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle text-green-400 mt-0.5"></i>
                        Anda dapat berpindah soal dengan navigasi
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle text-green-400 mt-0.5"></i>
                        Waktu akan otomatis submit saat habis
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle text-green-400 mt-0.5"></i>
                        Pastikan semua soal terjawab sebelum submit
                    </li>
                </ul>
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
                        <i class="bi bi-exclamation-triangle"></i> Perhatian!
                    </strong>
                    <ul class="text-sm space-y-1 mt-2">
                        <li>Terjawab: <span id="answeredCount" class="font-semibold">0</span> soal</li>
                        <li>Belum dijawab: <span id="unansweredCount" class="font-semibold">{{ count($questions) }}</span> soal</li>
                        <li>Ditandai ragu: <span id="flaggedCount" class="font-semibold">0</span> soal</li>
                    </ul>
                </div>
                <p class="text-sm text-white/60">Setelah submit, Anda tidak dapat mengubah jawaban.</p>
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
            <p class="text-white/80 mb-6">Tersisa kurang dari 5 menit. Segera selesaikan ujian Anda.</p>
            <button type="button" onclick="closeTimeWarning()" class="px-8 py-3 bg-white text-red-600 font-semibold rounded-xl hover:bg-gray-100 transition-all">
                Mengerti
            </button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .timer-box.warning {
        background: rgba(251, 191, 36, 0.3) !important;
        border-color: rgba(251, 191, 36, 0.5) !important;
    }
    
    .timer-box.danger {
        background: rgba(239, 68, 68, 0.3) !important;
        border-color: rgba(239, 68, 68, 0.5) !important;
        animation: timer-pulse 1s infinite;
    }
    
    @keyframes timer-pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }
    
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
@endpush

@push('scripts')
<script>
    // Quiz State
    const totalQuestions = {{ count($questions) }};
    let currentQuestion = 0;
    let answers = {};
    let flagged = new Set();
    let fontSize = 100;
    let timeWarningShown = false;
    
    // Timer - 90 minutes
    let timeLeft = 90 * 60;
    
    // Timer Function
    function updateTimer() {
        const hours = Math.floor(timeLeft / 3600);
        const minutes = Math.floor((timeLeft % 3600) / 60);
        const seconds = timeLeft % 60;
        
        const display = document.getElementById('timerDisplay');
        const fixedTimer = document.getElementById('fixedTimer');
        
        display.textContent = 
            String(hours).padStart(2, '0') + ':' + 
            String(minutes).padStart(2, '0') + ':' + 
            String(seconds).padStart(2, '0');
        
        // Warning states
        if (timeLeft <= 300 && timeLeft > 60) {
            fixedTimer.classList.add('warning');
            fixedTimer.classList.remove('danger');
            
            if (!timeWarningShown) {
                timeWarningShown = true;
                document.getElementById('timeWarningModal').classList.remove('hidden');
            }
        } else if (timeLeft <= 60) {
            fixedTimer.classList.remove('warning');
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
    
    // Navigation Functions
    function goToQuestion(index) {
        document.querySelectorAll('.question-slide').forEach(q => q.classList.add('hidden'));
        document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
        
        document.getElementById('question-' + index).classList.remove('hidden');
        document.getElementById('navBtn-' + index).classList.add('active');
        
        currentQuestion = index;
        updateButtons();
        
        // Re-render MathJax for the visible question
        if (typeof MathJax !== 'undefined' && MathJax.typesetPromise) {
            MathJax.typesetPromise([document.getElementById('question-' + index)]);
        }
    }
    
    function nextQuestion() {
        if (currentQuestion < totalQuestions - 1) {
            goToQuestion(currentQuestion + 1);
        }
    }
    
    function prevQuestion() {
        if (currentQuestion > 0) {
            goToQuestion(currentQuestion - 1);
        }
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
    
    // Answer Selection
    function selectOption(questionIndex, option) {
        const questionCard = document.getElementById('question-' + questionIndex);
        const options = questionCard.querySelectorAll('.option-item');
        
        options.forEach(opt => opt.classList.remove('selected'));
        
        options.forEach(opt => {
            const radio = opt.querySelector('input[type="radio"]');
            if (radio.value === option) {
                opt.classList.add('selected');
                radio.checked = true;
            }
        });
        
        answers[questionIndex] = option;
        
        const navBtn = document.getElementById('navBtn-' + questionIndex);
        if (!flagged.has(questionIndex)) {
            navBtn.classList.add('answered');
        }
        
        updateProgress();
    }
    
    // Flag Question
    function toggleFlag(index) {
        const flagBtn = document.getElementById('flagBtn-' + index);
        const navBtn = document.getElementById('navBtn-' + index);
        
        if (flagged.has(index)) {
            flagged.delete(index);
            flagBtn.classList.remove('flagged');
            navBtn.classList.remove('flagged');
            if (answers[index]) {
                navBtn.classList.add('answered');
            }
        } else {
            flagged.add(index);
            flagBtn.classList.add('flagged');
            navBtn.classList.remove('answered');
            navBtn.classList.add('flagged');
        }
    }
    
    // Progress Update
    function updateProgress() {
        const answered = Object.keys(answers).length;
        const percentage = (answered / totalQuestions) * 100;
        
        document.getElementById('progressBar').style.width = percentage + '%';
        document.getElementById('progressText').textContent = answered + ' / ' + totalQuestions + ' Soal Dijawab';
    }
    
    // Accessibility Functions
    function increaseFontSize() {
        if (fontSize < 150) {
            fontSize += 10;
            applyFontSize();
        }
    }
    
    function decreaseFontSize() {
        if (fontSize > 70) {
            fontSize -= 10;
            applyFontSize();
        }
    }
    
    function applyFontSize() {
        document.querySelectorAll('.question-text, .option-text').forEach(el => {
            el.style.fontSize = (fontSize / 100) + 'em';
        });
        document.getElementById('fontSizeIndicator').textContent = fontSize + '%';
    }
    
    function toggleContrast() {
        document.body.classList.toggle('high-contrast');
        document.getElementById('contrastToggle').classList.toggle('active');
    }
    
    // Modal Functions
    function confirmSubmit() {
        const answered = Object.keys(answers).length;
        const unanswered = totalQuestions - answered;
        const flaggedCount = flagged.size;
        
        document.getElementById('answeredCount').textContent = answered;
        document.getElementById('unansweredCount').textContent = unanswered;
        document.getElementById('flaggedCount').textContent = flaggedCount;
        
        document.getElementById('submitModal').classList.remove('hidden');
    }
    
    function closeSubmitModal() {
        document.getElementById('submitModal').classList.add('hidden');
    }
    
    function closeTimeWarning() {
        document.getElementById('timeWarningModal').classList.add('hidden');
    }
    
    function submitQuiz() {
        window.removeEventListener('beforeunload', beforeUnloadHandler);
        document.getElementById('quizForm').submit();
    }
    
    // Prevent accidental page leave
    function beforeUnloadHandler(e) {
        e.preventDefault();
        e.returnValue = 'Anda yakin ingin meninggalkan halaman? Jawaban yang belum disimpan akan hilang.';
    }
    
    window.addEventListener('beforeunload', beforeUnloadHandler);
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            prevQuestion();
        } else if (e.key === 'ArrowRight') {
            nextQuestion();
        } else if (e.key >= '1' && e.key <= '4') {
            const options = ['A', 'B', 'C', 'D'];
            selectOption(currentQuestion, options[parseInt(e.key) - 1]);
        } else if (e.key === 'Escape') {
            closeSubmitModal();
            closeTimeWarning();
        }
    });
</script>
@endpush
