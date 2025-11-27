@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="glass-section rounded-3xl p-8 lg:p-12 w-full max-w-2xl" data-aos="fade-up">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                <i class="bi bi-person-plus text-white text-4xl"></i>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Daftar Akun Baru</h1>
            <p class="text-gray-600">Isi data diri Anda dengan lengkap dan benar</p>
        </div>
        
        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" id="register-form">
            @csrf
            
            <div class="space-y-6">
                <!-- NIK -->
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-900 mb-2">
                        <i class="bi bi-credit-card me-1"></i> NIK (Nomor Induk Kependudukan)
                    </label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white text-gray-900 placeholder-gray-400 @error('nik') border-red-500 @enderror"
                           placeholder="Masukkan 16 digit NIK" maxlength="16" required>
                    @error('nik')
                    <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-900 mb-2">
                        <i class="bi bi-person me-1"></i> Nama Lengkap
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white text-gray-900 placeholder-gray-400 @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama lengkap sesuai KTP" required>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-900 mb-2">
                        <i class="bi bi-envelope me-1"></i> Email
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white text-gray-900 placeholder-gray-400 @error('email') border-red-500 @enderror"
                           placeholder="contoh@email.com" required>
                    @error('email')
                    <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Domisili -->
                    <div>
                        <label for="domisili" class="block text-sm font-medium text-gray-900 mb-2">
                            <i class="bi bi-geo-alt me-1"></i> Domisili
                        </label>
                        <select name="domisili" id="domisili" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white text-gray-900 @error('domisili') border-red-500 @enderror" required>
                            <option value="" class="text-gray-400">Pilih Domisili</option>
                            @foreach($domisiliList as $dom)
                            <option value="{{ $dom }}" {{ old('domisili') == $dom ? 'selected' : '' }}>{{ $dom }}</option>
                            @endforeach
                        </select>
                        @error('domisili')
                        <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Tempat Lahir -->
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-medium text-gray-900 mb-2">
                            <i class="bi bi-geo me-1"></i> Tempat Lahir
                        </label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white text-gray-900 placeholder-gray-400 @error('tempat_lahir') border-red-500 @enderror"
                               placeholder="Contoh: Jakarta" required>
                        @error('tempat_lahir')
                        <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Tanggal Lahir dengan Datepicker -->
                <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-900 mb-2">
                        <i class="bi bi-calendar-event me-1"></i> Tanggal Lahir
                    </label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white text-gray-900 @error('tanggal_lahir') border-red-500 @enderror"
                           max="{{ date('Y-m-d', strtotime('-17 years')) }}" required>
                    @error('tanggal_lahir')
                    <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-900 mb-2">
                            <i class="bi bi-lock me-1"></i> Password
                        </label>
                        <input type="password" name="password" id="password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white text-gray-900 placeholder-gray-400 @error('password') border-red-500 @enderror"
                               placeholder="Minimal 8 karakter" required>
                        @error('password')
                        <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-900 mb-2">
                            <i class="bi bi-lock-fill me-1"></i> Konfirmasi Password
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white text-gray-900 placeholder-gray-400"
                               placeholder="Ulangi password" required>
                    </div>
                </div>
                
                <!-- Photo -->
                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-900 mb-2">
                        <i class="bi bi-camera me-1"></i> Foto (Opsional)
                    </label>
                    <input type="file" name="photo" id="photo" accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('photo') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maks: 2MB</p>
                    @error('photo')
                    <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <button type="submit" class="w-full mt-8 px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold text-lg shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                <i class="bi bi-check-circle me-2"></i> Daftar Sekarang
            </button>
            
            <p class="text-center mt-6 text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Login di sini</a>
            </p>
        </form>
    </div>
</div>

<!-- Validation Error Modal -->
@if($errors->any())
<div id="error-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeErrorModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 text-center" data-aos="zoom-in">
        <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="bi bi-exclamation-triangle text-red-600 text-4xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Data Belum Lengkap/Valid</h3>
        <p class="text-gray-600 mb-6">Silakan periksa kembali data yang Anda masukkan dan pastikan semua field terisi dengan benar.</p>
        <button onclick="closeErrorModal()" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
            Mengerti
        </button>
    </div>
</div>

<script>
function closeErrorModal() {
    document.getElementById('error-modal').style.display = 'none';
}
</script>
@endif

@push('scripts')
<script>
// NIK validation - only numbers
document.getElementById('nik').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);
});
</script>
@endpush
@endsection
