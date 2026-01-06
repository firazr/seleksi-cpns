@extends('layouts.app')

@section('title', 'Verifikasi Email')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="glass-section rounded-3xl p-8 lg:p-12 w-full max-w-md" data-aos="fade-up">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                <i class="bi bi-envelope-check text-white text-4xl"></i>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Verifikasi Email</h1>
            <p class="text-gray-600">Masukkan kode OTP yang telah dikirim ke email Anda</p>
        </div>
        
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-300 rounded-xl text-green-700 flex items-center gap-2">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-300 rounded-xl text-red-700 flex items-center gap-2">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ session('error') }}
        </div>
        @endif
        
        <!-- Email Info -->
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
            <p class="text-blue-800 text-sm">
                <i class="bi bi-info-circle me-1"></i>
                Kode OTP telah dikirim ke: <strong>{{ auth()->user()->email }}</strong>
            </p>
        </div>
        
        <form action="{{ route('verification.verify') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- OTP Input -->
                <div>
                    <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-shield-lock me-1"></i> Kode OTP (6 digit)
                    </label>
                    <input type="text" name="otp" id="otp" maxlength="6" 
                           class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all bg-white text-gray-900 placeholder-gray-400 text-center text-2xl tracking-widest font-bold @error('otp') border-red-500 @enderror"
                           placeholder="000000" required autofocus
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    @error('otp')
                    <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <button type="submit" class="w-full mt-8 px-6 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-semibold text-lg shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                <i class="bi bi-check-circle me-2"></i> Verifikasi
            </button>
        </form>
        
        <!-- Resend OTP -->
        <div class="mt-6 text-center">
            <p class="text-gray-600 mb-3">Tidak menerima kode?</p>
            <form action="{{ route('verification.resend') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-blue-600 hover:text-blue-800 font-medium hover:underline">
                    <i class="bi bi-arrow-clockwise me-1"></i> Kirim Ulang Kode OTP
                </button>
            </form>
        </div>
        
        <!-- Timer Info -->
        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl text-center">
            <p class="text-yellow-800 text-sm">
                <i class="bi bi-clock me-1"></i>
                Kode OTP berlaku selama <strong>10 menit</strong>
            </p>
        </div>
        
        <!-- Logout Option -->
        <div class="mt-6 text-center">
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-gray-700 text-sm">
                    <i class="bi bi-box-arrow-left me-1"></i> Logout dan gunakan email lain
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
