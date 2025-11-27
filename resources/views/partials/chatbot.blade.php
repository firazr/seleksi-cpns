<!-- Chatbot Floating Button -->
<button id="chatbot-btn" class="chatbot-btn w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full shadow-xl flex items-center justify-center hover:shadow-2xl transition-all group">
    <i class="bi bi-robot text-white text-2xl group-hover:scale-110 transition-transform"></i>
</button>

<!-- Chatbot Modal -->
<div id="chatbot-modal" class="fixed inset-0 z-[1001] hidden">
    <div class="modal-backdrop absolute inset-0" onclick="closeChatbot()"></div>
    <div class="absolute bottom-24 right-6 w-96 max-w-[calc(100vw-3rem)] bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="bi bi-robot text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-white">CPNS Assistant</h3>
                    <p class="text-xs text-white/80">Siap membantu Anda</p>
                </div>
            </div>
            <button onclick="closeChatbot()" class="text-white/80 hover:text-white transition-colors">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>
        
        <!-- Chat Content -->
        <div class="p-6 max-h-96 overflow-y-auto">
            <!-- Bot Message -->
            <div class="flex gap-3 mb-4">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-robot text-blue-600"></i>
                </div>
                <div class="bg-gray-100 rounded-2xl rounded-tl-none px-4 py-3 max-w-[80%]">
                    <p class="text-gray-700 text-sm">Halo! Selamat datang di Portal CPNS 2025. Ada yang bisa saya bantu?</p>
                </div>
            </div>
            
            <!-- Info Card -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                <h4 class="font-semibold text-blue-800 mb-2 flex items-center gap-2">
                    <i class="bi bi-info-circle"></i> Tentang CPNS
                </h4>
                <p class="text-sm text-blue-700 mb-3">
                    CPNS (Calon Pegawai Negeri Sipil) adalah proses seleksi untuk menjadi Aparatur Sipil Negara. Seleksi meliputi:
                </p>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle-fill text-green-500 mt-0.5"></i>
                        <span><strong>TWK</strong> - Tes Wawasan Kebangsaan</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle-fill text-green-500 mt-0.5"></i>
                        <span><strong>TIU</strong> - Tes Intelegensia Umum</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle-fill text-green-500 mt-0.5"></i>
                        <span><strong>TKP</strong> - Tes Karakteristik Pribadi</span>
                    </li>
                </ul>
            </div>
            
            <!-- Tips Card -->
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4">
                <h4 class="font-semibold text-green-800 mb-2 flex items-center gap-2">
                    <i class="bi bi-lightbulb"></i> Tips Persiapan
                </h4>
                <ul class="text-sm text-green-700 space-y-1">
                    <li>• Pelajari materi TWK, TIU, dan TKP secara rutin</li>
                    <li>• Latihan soal-soal tahun sebelumnya</li>
                    <li>• Jaga kesehatan fisik dan mental</li>
                    <li>• Persiapkan dokumen dengan lengkap</li>
                </ul>
            </div>
            
            <!-- GPT Suggestion -->
            <div class="bg-purple-50 border border-purple-200 rounded-xl p-4">
                <h4 class="font-semibold text-purple-800 mb-2 flex items-center gap-2">
                    <i class="bi bi-search"></i> Cari Info Lebih Detail
                </h4>
                <p class="text-sm text-purple-700 mb-3">
                    Untuk informasi lebih lengkap tentang CPNS, kamu bisa bertanya kepada AI seperti ChatGPT atau cari di mesin pencari.
                </p>
                <a href="https://chat.openai.com" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-lg text-sm hover:bg-purple-700 transition-colors">
                    <i class="bi bi-box-arrow-up-right"></i> Buka ChatGPT
                </a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-50 border-t">
            <p class="text-xs text-gray-500 text-center">
                Ini adalah asisten virtual dengan informasi statis. Untuk pertanyaan lebih lanjut, hubungi call center resmi.
            </p>
        </div>
    </div>
</div>

<script>
function openChatbot() {
    document.getElementById('chatbot-modal').classList.remove('hidden');
}

function closeChatbot() {
    document.getElementById('chatbot-modal').classList.add('hidden');
}

document.getElementById('chatbot-btn').addEventListener('click', function() {
    openChatbot();
});

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeChatbot();
    }
});
</script>
