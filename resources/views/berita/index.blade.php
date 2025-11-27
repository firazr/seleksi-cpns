@extends('layouts.app')

@section('title', 'Berita')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12" data-aos="fade-up">
            <span class="inline-flex items-center px-4 py-2 bg-white/20 text-white rounded-full text-sm font-medium mb-4">
                <i class="bi bi-newspaper me-2"></i> Update Terkini
            </span>
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Berita & Pengumuman</h1>
            <p class="text-white/80 max-w-2xl mx-auto">Informasi terbaru seputar seleksi CPNS 2025</p>
        </div>
        
        <!-- Filter & Admin Actions -->
        <div class="glass-section rounded-2xl p-6 mb-8" data-aos="fade-up">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <!-- Filter -->
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('berita.index') }}" class="px-4 py-2 rounded-lg font-medium transition-all {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Semua
                    </a>
                    <a href="{{ route('berita.index', ['category' => 'pengumuman']) }}" class="px-4 py-2 rounded-lg font-medium transition-all {{ request('category') == 'pengumuman' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Pengumuman
                    </a>
                    <a href="{{ route('berita.index', ['category' => 'tahapan']) }}" class="px-4 py-2 rounded-lg font-medium transition-all {{ request('category') == 'tahapan' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Tahapan
                    </a>
                    <a href="{{ route('berita.index', ['category' => 'tata_cara']) }}" class="px-4 py-2 rounded-lg font-medium transition-all {{ request('category') == 'tata_cara' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Tata Cara
                    </a>
                </div>
                
                @auth
                @if(auth()->user()->isAdmin())
                <button onclick="openAddModal()" class="px-6 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg font-medium hover:shadow-lg transition-all">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Berita
                </button>
                @endif
                @endauth
            </div>
        </div>
        
        <!-- News Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="news-grid">
            @forelse($news as $item)
            <div class="glass-card rounded-2xl overflow-hidden card-hover" data-aos="fade-up">
                @if($item->image_path)
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                    <i class="bi bi-newspaper text-white text-5xl"></i>
                </div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                            {{ $item->category == 'pengumuman' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $item->category == 'tahapan' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $item->category == 'tata_cara' ? 'bg-green-100 text-green-700' : '' }}">
                            {{ $item->category_label }}
                        </span>
                        @if($item->domisili)
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">
                            {{ $item->domisili }}
                        </span>
                        @endif
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $item->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ $item->excerpt }}</p>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $item->created_at->format('d M Y') }}
                        </span>
                        <button onclick="openNewsModal({{ $item->id }})" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                            Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                    
                    @auth
                    @if(auth()->user()->isAdmin())
                    <div class="flex gap-2 mt-4 pt-4 border-t border-gray-100">
                        <button onclick="openEditModal({{ $item->id }})" class="flex-1 px-3 py-2 bg-yellow-100 text-yellow-700 rounded-lg text-sm font-medium hover:bg-yellow-200 transition-colors">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </button>
                        <button onclick="deleteNews({{ $item->id }})" class="flex-1 px-3 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-medium hover:bg-red-200 transition-colors">
                            <i class="bi bi-trash me-1"></i> Hapus
                        </button>
                    </div>
                    @endif
                    @endauth
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-16">
                <i class="bi bi-newspaper text-6xl text-white/40"></i>
                <p class="text-white/60 mt-4">Belum ada berita</p>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $news->links() }}
        </div>
    </div>
</div>

<!-- News Detail Modal -->
<div id="news-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="modal-backdrop absolute inset-0" onclick="closeNewsModal()"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <button onclick="closeNewsModal()" class="absolute top-4 right-4 z-10 w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
                <i class="bi bi-x-lg"></i>
            </button>
            <div id="news-modal-content">
                <!-- Content loaded via AJAX -->
            </div>
        </div>
    </div>
</div>

@auth
@if(auth()->user()->isAdmin())
<!-- Add/Edit News Modal -->
<div id="news-form-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="modal-backdrop absolute inset-0" onclick="closeFormModal()"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full">
            <div class="p-6 border-b border-gray-100">
                <h3 id="form-modal-title" class="text-xl font-bold text-gray-900">Tambah Berita</h3>
            </div>
            <form id="news-form" enctype="multipart/form-data" class="p-6">
                @csrf
                <input type="hidden" id="news-id" name="id">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                        <input type="text" name="title" id="news-title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select name="category" id="news-category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                <option value="pengumuman">Pengumuman</option>
                                <option value="tahapan">Tahapan</option>
                                <option value="tata_cara">Tata Cara</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Domisili (Opsional)</label>
                            <input type="text" name="domisili" id="news-domisili" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Contoh: Jakarta">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konten</label>
                        <textarea name="content" id="news-content" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gambar (Opsional)</label>
                        <input type="file" name="image" id="news-image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
                
                <div class="flex gap-4 mt-6">
                    <button type="button" onclick="closeFormModal()" class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-medium hover:shadow-lg transition-all">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endauth

@push('scripts')
<script>
// View News Modal
function openNewsModal(id) {
    $.get(`/berita/${id}`, function(response) {
        if (response.success) {
            const news = response.data;
            let html = `
                ${news.image_path ? `<img src="/storage/${news.image_path}" alt="${news.title}" class="w-full h-64 object-cover">` : ''}
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                            ${news.category}
                        </span>
                        ${news.domisili ? `<span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">${news.domisili}</span>` : ''}
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">${news.title}</h2>
                    <div class="prose max-w-none text-gray-600">${news.content}</div>
                    <p class="mt-6 text-sm text-gray-500">
                        <i class="bi bi-calendar3 me-1"></i>
                        ${new Date(news.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}
                    </p>
                </div>
            `;
            $('#news-modal-content').html(html);
            $('#news-modal').removeClass('hidden');
        }
    });
}

function closeNewsModal() {
    $('#news-modal').addClass('hidden');
}

@auth
@if(auth()->user()->isAdmin())
// Add News Modal
function openAddModal() {
    $('#form-modal-title').text('Tambah Berita');
    $('#news-form')[0].reset();
    $('#news-id').val('');
    $('#news-form-modal').removeClass('hidden');
}

// Edit News Modal
function openEditModal(id) {
    $.get(`/berita/${id}`, function(response) {
        if (response.success) {
            const news = response.data;
            $('#form-modal-title').text('Edit Berita');
            $('#news-id').val(news.id);
            $('#news-title').val(news.title);
            $('#news-category').val(news.category);
            $('#news-domisili').val(news.domisili || '');
            $('#news-content').val(news.content);
            $('#news-form-modal').removeClass('hidden');
        }
    });
}

function closeFormModal() {
    $('#news-form-modal').addClass('hidden');
}

// Submit Form
$('#news-form').on('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const id = $('#news-id').val();
    const url = id ? `/admin/berita/${id}` : '/admin/berita';
    
    if (id) {
        formData.append('_method', 'PUT');
    }
    
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                alert(response.message);
                location.reload();
            }
        },
        error: function(xhr) {
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    });
});

// Delete News
function deleteNews(id) {
    if (confirm('Apakah Anda yakin ingin menghapus berita ini?')) {
        $.ajax({
            url: `/admin/berita/${id}`,
            type: 'DELETE',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    }
}
@endif
@endauth

// Close modals on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeNewsModal();
        @auth
        @if(auth()->user()->isAdmin())
        closeFormModal();
        @endif
        @endauth
    }
});
</script>
@endpush
@endsection
