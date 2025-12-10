@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 pt-24 pb-12">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">Admin Dashboard</h1>
            <p class="text-blue-300">Monitoring peserta dan soal test CPNS</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <!-- Total Peserta -->
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/15 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-300 text-sm font-medium">Total Peserta</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $totalUsers }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500/30 rounded-xl flex items-center justify-center">
                        <i class="bi bi-people text-2xl text-blue-400"></i>
                    </div>
                </div>
            </div>

            <!-- Peserta Aktif -->
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/15 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-300 text-sm font-medium">Peserta Aktif</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $activeUsers }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-500/30 rounded-xl flex items-center justify-center">
                        <i class="bi bi-activity text-2xl text-green-400"></i>
                    </div>
                </div>
            </div>

            <!-- Test Selesai -->
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/15 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-300 text-sm font-medium">Test Selesai</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $completedTests }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500/30 rounded-xl flex items-center justify-center">
                        <i class="bi bi-check-circle text-2xl text-purple-400"></i>
                    </div>
                </div>
            </div>

            <!-- Total Soal -->
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/15 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-300 text-sm font-medium">Total Soal</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $totalQuestions }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-500/30 rounded-xl flex items-center justify-center">
                        <i class="bi bi-question-circle text-2xl text-orange-400"></i>
                    </div>
                </div>
            </div>

            <!-- Berita -->
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/15 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-pink-300 text-sm font-medium">Berita</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $totalNews }}</p>
                    </div>
                    <div class="w-12 h-12 bg-pink-500/30 rounded-xl flex items-center justify-center">
                        <i class="bi bi-newspaper text-2xl text-pink-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Soal per Kategori -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <i class="bi bi-bar-chart"></i> Soal per Kategori
                    </h3>
                    <div class="space-y-3">
                        @forelse($questionsByCategory as $cat)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="w-10 h-10 bg-blue-500/30 rounded-lg flex items-center justify-center text-blue-300 font-semibold">{{ $cat->category }}</span>
                                    <span class="text-gray-300">{{ ucfirst($cat->category) }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="h-2 bg-white/10 rounded-full w-32">
                                        <div class="h-2 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full" style="width: {{ min(100, ($cat->total / ($totalQuestions ?: 1)) * 100) }}%"></div>
                                    </div>
                                    <span class="text-white font-semibold min-w-8 text-right">{{ $cat->total }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-400">Belum ada soal</p>
                        @endforelse
                    </div>
                </div>

                <!-- Peserta Hasil Test Terbaru -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <i class="bi bi-list-check"></i> Hasil Test Terbaru
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-white/10">
                                    <th class="text-left py-3 px-2 text-gray-400 font-medium">Peserta</th>
                                    <th class="text-center py-3 px-2 text-gray-400 font-medium">Kategori</th>
                                    <th class="text-center py-3 px-2 text-gray-400 font-medium">Skor</th>
                                    <th class="text-center py-3 px-2 text-gray-400 font-medium">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pesertaResults as $result)
                                    <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                                        <td class="py-3 px-2">
                                            <div class="flex items-center gap-2">
                                                <img src="{{ $result->user->photo_path ? asset('storage/' . $result->user->photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($result->user->name) }}" 
                                                     alt="{{ $result->user->name }}"
                                                     class="w-8 h-8 rounded-full object-cover">
                                                <span class="text-white">{{ $result->user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-2 text-center">
                                            <span class="inline-block px-2 py-1 bg-blue-500/30 text-blue-300 rounded-lg text-xs font-medium">
                                                {{ $result->category }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-2 text-center">
                                            <span class="text-white font-semibold">{{ $result->score ?? '-' }}</span>
                                        </td>
                                        <td class="py-3 px-2 text-center text-gray-400 text-xs">
                                            {{ $result->finished_at->format('d M Y H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-center text-gray-400">Belum ada yang mengerjakan test</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($pesertaResults->hasPages())
                        <div class="mt-4">
                            {{ $pesertaResults->links('pagination::simple-bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Semua Peserta -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <i class="bi bi-person-check"></i> Daftar Peserta
                    </h3>
                    <div class="space-y-2 max-h-96 overflow-y-auto pr-2">
                        @forelse($allPeserta as $peserta)
                            <div class="bg-white/5 rounded-lg p-3 hover:bg-white/10 transition-colors">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2 flex-1 min-w-0">
                                        <img src="{{ $peserta->photo_path ? asset('storage/' . $peserta->photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($peserta->name) }}" 
                                             alt="{{ $peserta->name }}"
                                             class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                                        <div class="min-w-0">
                                            <p class="text-white text-sm font-medium truncate">{{ $peserta->name }}</p>
                                            <p class="text-gray-400 text-xs truncate">{{ $peserta->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-400">NIK:</span>
                                    <span class="text-xs text-blue-300 font-mono">{{ $peserta->nik ?? '-' }}</span>
                                </div>
                                @if($peserta->testSessions->count() > 0)
                                    <div class="mt-2 text-xs text-green-400">
                                        ✓ {{ $peserta->testSessions->count() }} test
                                    </div>
                                @else
                                    <div class="mt-2 text-xs text-gray-500">
                                        • Belum ada test
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm">Belum ada peserta</p>
                        @endforelse
                    </div>
                    @if($allPeserta->hasPages())
                        <div class="mt-4 text-xs">
                            {{ $allPeserta->links('pagination::simple-bootstrap-5') }}
                        </div>
                    @endif
                </div>

                <!-- Admin Actions -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <i class="bi bi-sliders"></i> Menu Admin
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('admin.questions.index') }}" class="block w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg py-2 px-4 text-center font-medium hover:shadow-lg hover:-translate-y-0.5 transition-all">
                            <i class="bi bi-pencil me-2"></i> Kelola Soal
                        </a>
                        <a href="{{ route('berita.index') }}" class="block w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg py-2 px-4 text-center font-medium hover:shadow-lg hover:-translate-y-0.5 transition-all">
                            <i class="bi bi-newspaper me-2"></i> Kelola Berita
                        </a>
                        <button onclick="document.getElementById('modal-create-admin').classList.remove('hidden')" class="block w-full bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg py-2 px-4 text-center font-medium hover:shadow-lg hover:-translate-y-0.5 transition-all">
                            <i class="bi bi-person-plus me-2"></i> Buat Admin Baru
                        </button>
                        <a href="{{ route('home') }}" class="block w-full bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-lg py-2 px-4 text-center font-medium hover:shadow-lg hover:-translate-y-0.5 transition-all">
                            <i class="bi bi-house me-2"></i> Kembali ke Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create Admin -->
<div id="modal-create-admin" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 border border-white/20 rounded-2xl p-8 w-full max-w-md shadow-2xl">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                <i class="bi bi-person-plus text-green-400"></i> Buat Admin Baru
            </h2>
            <button onclick="document.getElementById('modal-create-admin').classList.add('hidden')" class="text-gray-400 hover:text-white transition-colors">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-500/20 border border-red-500/50 rounded-lg">
                <ul class="text-red-300 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.store-admin') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nama Admin</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" 
                       class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:bg-white/10 transition-all"
                       placeholder="Nama lengkap admin"
                       required>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:bg-white/10 transition-all"
                       placeholder="admin@example.com"
                       required>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                <input type="password" id="password" name="password"
                       class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:bg-white/10 transition-all"
                       placeholder="Minimal 8 karakter"
                       required>
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:bg-white/10 transition-all"
                       placeholder="Ulang password"
                       required>
            </div>

            <!-- Submit -->
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="document.getElementById('modal-create-admin').classList.add('hidden')" 
                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:shadow-lg hover:-translate-y-0.5 text-white font-medium py-2 px-4 rounded-lg transition-all">
                    <i class="bi bi-check-lg me-2"></i> Buat Admin
                </button>
            </div>
        </form>

        <p class="text-xs text-gray-400 mt-4 text-center">
            Admin baru akan menerima kredensial melalui email (jika email configured)
        </p>
    </div>
</div>

@endsection
