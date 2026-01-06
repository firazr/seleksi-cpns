@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="glass-section rounded-3xl p-8 lg:p-12 w-full max-w-md" data-aos="fade-up">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                <i class="bi bi-box-arrow-in-right text-white text-4xl"></i>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Login</h1>
            <p class="text-gray-600">Masuk ke akun Anda untuk melanjutkan</p>
        </div>
        
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-300 rounded-xl text-green-700 flex items-center gap-2">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
        @endif
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-envelope me-1"></i> Email
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white text-gray-900 placeholder-gray-400 @error('email') border-red-500 @enderror"
                           placeholder="contoh@email.com" required autofocus>
                    @error('email')
                    <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-lock me-1"></i> Password
                    </label>
                    <input type="password" name="password" id="password" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white text-gray-900 placeholder-gray-400 @error('password') border-red-500 @enderror"
                           placeholder="Masukkan password" required>
                    @error('password')
                    <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800">Lupa password?</a>
                </div>
            </div>
            
            <button type="submit" class="w-full mt-8 px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold text-lg shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                <i class="bi bi-box-arrow-in-right me-2"></i> Login
            </button>
            
            <p class="text-center mt-6 text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium">Daftar di sini</a>
            </p>
        </form>
    </div>
</div>
@endsection
