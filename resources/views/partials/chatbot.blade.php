<!-- Chatbot Floating Button -->
<button id="chatbot-btn" class="chatbot-btn w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full shadow-xl flex items-center justify-center hover:shadow-2xl transition-all group">
    <i class="bi bi-robot text-white text-2xl group-hover:scale-110 transition-transform"></i>
</button>

<!-- Chatbot Modal -->
<div id="chatbot-modal" class="fixed inset-0 z-[1001] hidden">
    <div class="modal-backdrop absolute inset-0" onclick="closeChatbot()"></div>
    <div class="absolute bottom-24 right-6 w-96 max-w-[calc(100vw-3rem)] bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all flex flex-col" style="height: 500px;">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="bi bi-robot text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-white">CPNS Assistant</h3>
                </div>
            </div>
            <button onclick="closeChatbot()" class="text-white/80 hover:text-white transition-colors">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>
        
        <!-- Chat Messages -->
        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4">
            <!-- Welcome Message -->
            <div class="flex gap-3">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-robot text-blue-600"></i>
                </div>
                <div class="bg-gray-100 rounded-2xl rounded-tl-none px-4 py-3 max-w-[80%]">
                    <p class="text-gray-700 text-sm">Halo! Saya CPNS Assistant. Ada yang bisa saya bantu seputar CPNS? 😊</p>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="flex flex-wrap gap-2 pl-11">
                <button onclick="sendQuickMessage('Apa itu CPNS?')" class="quick-action-btn px-3 py-1.5 bg-blue-50 text-blue-600 rounded-full text-xs hover:bg-blue-100 transition-colors">
                    Apa itu CPNS?
                </button>
                <button onclick="sendQuickMessage('Tips lolos TWK')" class="quick-action-btn px-3 py-1.5 bg-blue-50 text-blue-600 rounded-full text-xs hover:bg-blue-100 transition-colors">
                    Tips lolos TWK
                </button>
                <button onclick="sendQuickMessage('Materi TIU apa saja?')" class="quick-action-btn px-3 py-1.5 bg-blue-50 text-blue-600 rounded-full text-xs hover:bg-blue-100 transition-colors">
                    Materi TIU
                </button>
                <button onclick="sendQuickMessage('Passing grade CPNS 2025')" class="quick-action-btn px-3 py-1.5 bg-blue-50 text-blue-600 rounded-full text-xs hover:bg-blue-100 transition-colors">
                    Passing Grade
                </button>
            </div>
        </div>
        
        <!-- Input Area -->
        <div class="px-4 py-3 bg-gray-50 border-t flex-shrink-0">
            <form id="chat-form" class="flex gap-2">
                @csrf
                <input 
                    type="text" 
                    id="chat-input" 
                    placeholder="Ketik pertanyaan Anda..." 
                    class="flex-1 px-4 py-2 bg-white border border-gray-200 rounded-full text-sm text-gray-900 placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    autocomplete="off"
                >
                <button 
                    type="submit" 
                    id="send-btn"
                    class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                >
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
let isProcessing = false;

function openChatbot() {
    document.getElementById('chatbot-modal').classList.remove('hidden');
    document.getElementById('chat-input').focus();
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

// Send quick message
function sendQuickMessage(message) {
    document.getElementById('chat-input').value = message;
    document.getElementById('chat-form').dispatchEvent(new Event('submit'));
}

// Add user message to chat
function addUserMessage(message) {
    const chatMessages = document.getElementById('chat-messages');
    const messageDiv = document.createElement('div');
    messageDiv.className = 'flex gap-3 justify-end';
    messageDiv.innerHTML = `
        <div class="bg-blue-600 text-white rounded-2xl rounded-tr-none px-4 py-3 max-w-[80%]">
            <p class="text-sm">${escapeHtml(message)}</p>
        </div>
        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="bi bi-person-fill text-white"></i>
        </div>
    `;
    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Add bot message to chat
function addBotMessage(message) {
    const chatMessages = document.getElementById('chat-messages');
    const messageDiv = document.createElement('div');
    messageDiv.className = 'flex gap-3';
    messageDiv.innerHTML = `
        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="bi bi-robot text-blue-600"></i>
        </div>
        <div class="bg-gray-100 rounded-2xl rounded-tl-none px-4 py-3 max-w-[80%]">
            <p class="text-gray-700 text-sm whitespace-pre-wrap">${escapeHtml(message)}</p>
        </div>
    `;
    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Add typing indicator
function addTypingIndicator() {
    const chatMessages = document.getElementById('chat-messages');
    const typingDiv = document.createElement('div');
    typingDiv.id = 'typing-indicator';
    typingDiv.className = 'flex gap-3';
    typingDiv.innerHTML = `
        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="bi bi-robot text-blue-600"></i>
        </div>
        <div class="bg-gray-100 rounded-2xl rounded-tl-none px-4 py-3">
            <div class="flex gap-1">
                <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms;"></span>
                <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms;"></span>
                <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms;"></span>
            </div>
        </div>
    `;
    chatMessages.appendChild(typingDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Remove typing indicator
function removeTypingIndicator() {
    const typingIndicator = document.getElementById('typing-indicator');
    if (typingIndicator) {
        typingIndicator.remove();
    }
}

// Escape HTML to prevent XSS
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Handle form submission
document.getElementById('chat-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    if (isProcessing) return;
    
    const input = document.getElementById('chat-input');
    const sendBtn = document.getElementById('send-btn');
    const message = input.value.trim();
    
    if (!message) return;
    
    // Hide quick actions after first message
    document.querySelectorAll('.quick-action-btn').forEach(btn => {
        btn.parentElement.style.display = 'none';
    });
    
    // Add user message
    addUserMessage(message);
    input.value = '';
    
    // Disable input while processing
    isProcessing = true;
    input.disabled = true;
    sendBtn.disabled = true;
    
    // Show typing indicator
    addTypingIndicator();
    
    try {
        const response = await fetch('{{ route("chatbot.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message: message })
        });
        
        const data = await response.json();
        
        removeTypingIndicator();
        
        if (data.success) {
            addBotMessage(data.message);
        } else {
            addBotMessage('Maaf, terjadi kesalahan: ' + (data.message || 'Silakan coba lagi.'));
        }
    } catch (error) {
        removeTypingIndicator();
        addBotMessage('Maaf, terjadi kesalahan koneksi. Silakan coba lagi.');
        console.error('Chat error:', error);
    } finally {
        // Re-enable input
        isProcessing = false;
        input.disabled = false;
        sendBtn.disabled = false;
        input.focus();
    }
});
</script>
