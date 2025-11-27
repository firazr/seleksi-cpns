@extends('layouts.app')

@section('title', 'Kelola Soal - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <!-- Header -->
    <div class="glass-white rounded-2xl p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                    <i class="bi bi-gear-fill"></i> Kelola Soal CPNS
                </h2>
                <p class="text-white/60 mt-1">Tambah, edit, dan hapus soal ujian</p>
            </div>
            <button onclick="openAddModal()" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:-translate-y-0.5 hover:shadow-lg transition-all">
                <i class="bi bi-plus-lg mr-2"></i> Tambah Soal Baru
            </button>
        </div>
    </div>
    
    <!-- Statistics -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="glass-white rounded-xl p-5 text-center border-l-4 border-yellow-500 hover:-translate-y-1 transition-all">
            <div class="text-3xl font-bold text-white">{{ $questions->total() }}</div>
            <div class="text-white/60 text-sm">Total Soal</div>
        </div>
        <div class="glass-white rounded-xl p-5 text-center border-l-4 border-blue-500 hover:-translate-y-1 transition-all">
            <div class="text-3xl font-bold text-white">{{ $twkCount ?? 0 }}</div>
            <div class="text-white/60 text-sm">Soal TWK</div>
        </div>
        <div class="glass-white rounded-xl p-5 text-center border-l-4 border-green-500 hover:-translate-y-1 transition-all">
            <div class="text-3xl font-bold text-white">{{ $tiuCount ?? 0 }}</div>
            <div class="text-white/60 text-sm">Soal TIU</div>
        </div>
        <div class="glass-white rounded-xl p-5 text-center border-l-4 border-purple-500 hover:-translate-y-1 transition-all">
            <div class="text-3xl font-bold text-white">{{ $tkpCount ?? 0 }}</div>
            <div class="text-white/60 text-sm">Soal TKP</div>
        </div>
    </div>
    
    <!-- Alert Messages -->
    @if(session('success'))
    <div class="bg-green-500/30 border border-green-500/50 text-white px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
        <i class="bi bi-check-circle-fill text-xl"></i>
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="ml-auto text-white/60 hover:text-white">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    @endif
    
    @if(session('error'))
    <div class="bg-red-500/30 border border-red-500/50 text-white px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
        <i class="bi bi-exclamation-circle-fill text-xl"></i>
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="ml-auto text-white/60 hover:text-white">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    @endif
    
    <!-- Question List -->
    <div class="glass-white rounded-2xl p-6">
        <h5 class="text-white font-semibold mb-5 flex items-center gap-2">
            <i class="bi bi-list-ul"></i> Daftar Soal
        </h5>
        
        <!-- Filter Bar -->
        <form action="{{ route('admin.questions.index') }}" method="GET" class="flex flex-wrap gap-3 mb-6">
            <input type="text" name="search" 
                class="flex-1 min-w-[200px] px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all" 
                placeholder="Cari soal..." value="{{ request('search') }}">
            <select name="category" class="px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                <option value="" class="bg-gray-800">Semua Kategori</option>
                <option value="TWK" {{ request('category') == 'TWK' ? 'selected' : '' }} class="bg-gray-800">TWK</option>
                <option value="TIU" {{ request('category') == 'TIU' ? 'selected' : '' }} class="bg-gray-800">TIU</option>
                <option value="TKP" {{ request('category') == 'TKP' ? 'selected' : '' }} class="bg-gray-800">TKP</option>
            </select>
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all">
                <i class="bi bi-search mr-2"></i> Filter
            </button>
            <a href="{{ route('admin.questions.index') }}" class="px-6 py-3 border border-white/30 text-white font-semibold rounded-xl hover:bg-white/10 transition-all">
                <i class="bi bi-arrow-clockwise mr-2"></i> Reset
            </a>
        </form>
        
        <!-- Table -->
        <div class="overflow-x-auto">
            @if($questions->count() > 0)
            <table class="w-full">
                <thead>
                    <tr class="bg-white/10 text-white text-left">
                        <th class="px-4 py-4 rounded-l-xl font-semibold">#</th>
                        <th class="px-4 py-4 font-semibold">Kategori</th>
                        <th class="px-4 py-4 font-semibold">Pertanyaan</th>
                        <th class="px-4 py-4 font-semibold">Jawaban Benar</th>
                        <th class="px-4 py-4 rounded-r-xl font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @foreach($questions as $index => $question)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-4 py-4 text-white">{{ $questions->firstItem() + $index }}</td>
                        <td class="px-4 py-4">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($question->category == 'TWK') bg-blue-500/30 text-blue-200
                                @elseif($question->category == 'TIU') bg-green-500/30 text-green-200
                                @else bg-purple-500/30 text-purple-200 @endif">
                                {{ $question->category }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-white">
                            <div class="max-w-xs truncate" title="{{ $question->question_text }}">
                                {{ $question->question_text }}
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-3 py-1 bg-green-600 text-white rounded-lg font-semibold uppercase">
                                {{ $question->correct_option }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex gap-2">
                                <button onclick="viewQuestion({{ $question->id }})" class="p-2 rounded-lg bg-blue-500/30 text-blue-200 hover:bg-blue-500/50 transition-all" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button onclick="editQuestion({{ $question->id }})" class="p-2 rounded-lg bg-yellow-500/30 text-yellow-200 hover:bg-yellow-500/50 transition-all" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button onclick="confirmDelete({{ $question->id }})" class="p-2 rounded-lg bg-red-500/30 text-red-200 hover:bg-red-500/50 transition-all" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $questions->appends(request()->query())->links() }}
            </div>
            @else
            <div class="text-center py-16 text-white/60">
                <i class="bi bi-folder-x text-6xl mb-4 opacity-50"></i>
                <h5 class="text-white text-xl font-semibold mb-2">Belum Ada Soal</h5>
                <p>Klik tombol "Tambah Soal Baru" untuk menambahkan soal pertama.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Question Modal -->
<div class="fixed inset-0 z-[1001] hidden" id="addModal">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeAddModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4 overflow-y-auto">
        <div class="w-full max-w-2xl my-8 glass-white rounded-2xl shadow-2xl relative" style="background: rgba(30, 30, 50, 0.95);">
            <div class="p-6 border-b border-white/20">
                <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                    <i class="bi bi-plus-circle"></i> Tambah Soal Baru
                </h3>
            </div>
            <form action="{{ route('admin.questions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-5 max-h-[70vh] overflow-y-auto">
                    <div>
                        <label class="block text-white font-medium mb-2">Kategori Soal</label>
                        <select name="category" required class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                            <option value="" class="bg-gray-800">Pilih Kategori</option>
                            <option value="TWK" class="bg-gray-800">TWK - Tes Wawasan Kebangsaan</option>
                            <option value="TIU" class="bg-gray-800">TIU - Tes Intelegensi Umum</option>
                            <option value="TKP" class="bg-gray-800">TKP - Tes Karakteristik Pribadi</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-white font-medium mb-2">Pertanyaan</label>
                        <textarea name="question_text" rows="4" required 
                            class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all resize-none"
                            placeholder="Masukkan teks pertanyaan... Gunakan $rumus$ untuk rumus matematika"></textarea>
                        <p class="text-white/50 text-xs mt-1">Tip: Gunakan $...$ untuk rumus matematika inline, contoh: $\frac{x}{y}$</p>
                    </div>
                    
                    <!-- Image Upload -->
                    <div>
                        <label class="block text-white font-medium mb-2">
                            <i class="bi bi-image me-1"></i> Gambar Soal (Opsional)
                        </label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white file:cursor-pointer">
                        <p class="text-white/50 text-xs mt-1">Format: JPG, PNG, GIF, SVG. Maks: 2MB</p>
                    </div>
                    
                    <!-- Math Toggle -->
                    <div class="flex items-center gap-3">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_math" value="1" class="sr-only peer">
                            <div class="w-11 h-6 bg-white/20 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                        <span class="text-white font-medium">Soal Matematika (dengan rumus)</span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-white font-medium mb-2">Pilihan A</label>
                            <input type="text" name="option_a" required 
                                class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"
                                placeholder="Jawaban A">
                        </div>
                        <div>
                            <label class="block text-white font-medium mb-2">Pilihan B</label>
                            <input type="text" name="option_b" required 
                                class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"
                                placeholder="Jawaban B">
                        </div>
                        <div>
                            <label class="block text-white font-medium mb-2">Pilihan C</label>
                            <input type="text" name="option_c" required 
                                class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"
                                placeholder="Jawaban C">
                        </div>
                        <div>
                            <label class="block text-white font-medium mb-2">Pilihan D</label>
                            <input type="text" name="option_d" required 
                                class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"
                                placeholder="Jawaban D">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-white font-medium mb-2">Jawaban Benar</label>
                        <select name="correct_option" required class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                            <option value="" class="bg-gray-800">Pilih Jawaban Benar</option>
                            <option value="a" class="bg-gray-800">A</option>
                            <option value="b" class="bg-gray-800">B</option>
                            <option value="c" class="bg-gray-800">C</option>
                            <option value="d" class="bg-gray-800">D</option>
                        </select>
                    </div>
                </div>
                <div class="p-6 border-t border-white/20 flex gap-3 justify-end">
                    <button type="button" onclick="closeAddModal()" class="px-6 py-2.5 rounded-xl border border-white/30 text-white hover:bg-white/10 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition-all">
                        <i class="bi bi-save mr-2"></i> Simpan Soal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Question Modal -->
<div class="fixed inset-0 z-[1001] hidden" id="viewModal">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeViewModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-2xl glass-white rounded-2xl shadow-2xl relative" style="background: rgba(30, 30, 50, 0.95);">
            <div class="p-6 border-b border-white/20">
                <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                    <i class="bi bi-eye"></i> Detail Soal
                </h3>
            </div>
            <div class="p-6" id="viewQuestionContent">
                <!-- Content loaded via JS -->
            </div>
            <div class="p-6 border-t border-white/20 flex gap-3 justify-end">
                <button type="button" onclick="closeViewModal()" class="px-6 py-2.5 rounded-xl border border-white/30 text-white hover:bg-white/10 transition-all">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Question Modal -->
<div class="fixed inset-0 z-[1001] hidden" id="editModal">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4 overflow-y-auto">
        <div class="w-full max-w-2xl my-8 glass-white rounded-2xl shadow-2xl relative" style="background: rgba(30, 30, 50, 0.95);">
            <div class="p-6 border-b border-white/20">
                <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                    <i class="bi bi-pencil"></i> Edit Soal
                </h3>
            </div>
            <form id="editQuestionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6 max-h-[70vh] overflow-y-auto" id="editQuestionContent">
                    <!-- Content loaded via JS -->
                </div>
                <div class="p-6 border-t border-white/20 flex gap-3 justify-end">
                    <button type="button" onclick="closeEditModal()" class="px-6 py-2.5 rounded-xl border border-white/30 text-white hover:bg-white/10 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-yellow-600 text-white font-semibold hover:bg-yellow-700 transition-all">
                        <i class="bi bi-save mr-2"></i> Update Soal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="fixed inset-0 z-[1001] hidden" id="deleteModal">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md glass-white rounded-2xl shadow-2xl relative" style="background: rgba(30, 30, 50, 0.95);">
            <div class="p-6 border-b border-white/20">
                <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                    <i class="bi bi-trash"></i> Hapus Soal
                </h3>
            </div>
            <div class="p-6">
                <p class="text-white mb-3">Apakah Anda yakin ingin menghapus soal ini?</p>
                <p class="text-yellow-400 text-sm flex items-center gap-2">
                    <i class="bi bi-exclamation-triangle"></i> Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="p-6 border-t border-white/20 flex gap-3 justify-end">
                <button type="button" onclick="closeDeleteModal()" class="px-6 py-2.5 rounded-xl border border-white/30 text-white hover:bg-white/10 transition-all">
                    Batal
                </button>
                <form id="deleteQuestionForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 transition-all">
                        <i class="bi bi-trash mr-2"></i> Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Question data storage
    const questions = @json($questions->items());
    
    // Modal Functions
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }
    
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }
    
    function closeViewModal() {
        document.getElementById('viewModal').classList.add('hidden');
    }
    
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    function viewQuestion(id) {
        const question = questions.find(q => q.id === id);
        if (!question) return;
        
        const categoryClass = {
            'TWK': 'bg-blue-500/30 text-blue-200',
            'TIU': 'bg-green-500/30 text-green-200',
            'TKP': 'bg-purple-500/30 text-purple-200'
        };
        
        const content = `
            <div class="mb-4">
                <span class="px-4 py-1.5 rounded-full text-sm font-medium ${categoryClass[question.category] || 'bg-gray-500/30 text-gray-200'}">
                    ${question.category}
                </span>
            </div>
            <div class="mb-6">
                <label class="block text-white/60 text-sm mb-2">Pertanyaan:</label>
                <p class="text-white text-lg">${question.question_text}</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="p-4 rounded-xl ${question.correct_option === 'a' ? 'bg-green-600/30 border border-green-500' : 'bg-white/10'}">
                    <strong class="text-white">A.</strong> <span class="text-white">${question.option_a}</span>
                    ${question.correct_option === 'a' ? '<i class="bi bi-check-circle-fill ml-2 text-green-400"></i>' : ''}
                </div>
                <div class="p-4 rounded-xl ${question.correct_option === 'b' ? 'bg-green-600/30 border border-green-500' : 'bg-white/10'}">
                    <strong class="text-white">B.</strong> <span class="text-white">${question.option_b}</span>
                    ${question.correct_option === 'b' ? '<i class="bi bi-check-circle-fill ml-2 text-green-400"></i>' : ''}
                </div>
                <div class="p-4 rounded-xl ${question.correct_option === 'c' ? 'bg-green-600/30 border border-green-500' : 'bg-white/10'}">
                    <strong class="text-white">C.</strong> <span class="text-white">${question.option_c}</span>
                    ${question.correct_option === 'c' ? '<i class="bi bi-check-circle-fill ml-2 text-green-400"></i>' : ''}
                </div>
                <div class="p-4 rounded-xl ${question.correct_option === 'd' ? 'bg-green-600/30 border border-green-500' : 'bg-white/10'}">
                    <strong class="text-white">D.</strong> <span class="text-white">${question.option_d}</span>
                    ${question.correct_option === 'd' ? '<i class="bi bi-check-circle-fill ml-2 text-green-400"></i>' : ''}
                </div>
            </div>
        `;
        
        document.getElementById('viewQuestionContent').innerHTML = content;
        document.getElementById('viewModal').classList.remove('hidden');
    }
    
    function editQuestion(id) {
        const question = questions.find(q => q.id === id);
        if (!question) return;
        
        const content = `
            <div class="space-y-5">
                <div>
                    <label class="block text-white font-medium mb-2">Kategori Soal</label>
                    <select name="category" required class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        <option value="TWK" ${question.category === 'TWK' ? 'selected' : ''} class="bg-gray-800">TWK - Tes Wawasan Kebangsaan</option>
                        <option value="TIU" ${question.category === 'TIU' ? 'selected' : ''} class="bg-gray-800">TIU - Tes Intelegensi Umum</option>
                        <option value="TKP" ${question.category === 'TKP' ? 'selected' : ''} class="bg-gray-800">TKP - Tes Karakteristik Pribadi</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-white font-medium mb-2">Pertanyaan</label>
                    <textarea name="question_text" rows="4" required 
                        class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all resize-none">${question.question_text}</textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-white font-medium mb-2">Pilihan A</label>
                        <input type="text" name="option_a" required value="${question.option_a}"
                            class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                    </div>
                    <div>
                        <label class="block text-white font-medium mb-2">Pilihan B</label>
                        <input type="text" name="option_b" required value="${question.option_b}"
                            class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                    </div>
                    <div>
                        <label class="block text-white font-medium mb-2">Pilihan C</label>
                        <input type="text" name="option_c" required value="${question.option_c}"
                            class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                    </div>
                    <div>
                        <label class="block text-white font-medium mb-2">Pilihan D</label>
                        <input type="text" name="option_d" required value="${question.option_d}"
                            class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                    </div>
                </div>
                
                <div>
                    <label class="block text-white font-medium mb-2">Jawaban Benar</label>
                    <select name="correct_option" required class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        <option value="a" ${question.correct_option === 'a' ? 'selected' : ''} class="bg-gray-800">A</option>
                        <option value="b" ${question.correct_option === 'b' ? 'selected' : ''} class="bg-gray-800">B</option>
                        <option value="c" ${question.correct_option === 'c' ? 'selected' : ''} class="bg-gray-800">C</option>
                        <option value="d" ${question.correct_option === 'd' ? 'selected' : ''} class="bg-gray-800">D</option>
                    </select>
                </div>
            </div>
        `;
        
        document.getElementById('editQuestionContent').innerHTML = content;
        document.getElementById('editQuestionForm').action = `/admin/questions/${id}`;
        document.getElementById('editModal').classList.remove('hidden');
    }
    
    function confirmDelete(id) {
        document.getElementById('deleteQuestionForm').action = `/admin/questions/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    // Close modals on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAddModal();
            closeViewModal();
            closeEditModal();
            closeDeleteModal();
        }
    });
</script>
@endpush
