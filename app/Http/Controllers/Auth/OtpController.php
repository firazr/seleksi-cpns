<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    /**
     * Show OTP verification form
     */
    public function showVerifyForm()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home')->with('success', 'Email sudah terverifikasi.');
        }

        return view('auth.verify-otp', compact('user'));
    }

    /**
     * Verify OTP
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus 6 digit.',
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home')->with('success', 'Email sudah terverifikasi.');
        }

        if ($user->verifyOtp($request->otp)) {
            return redirect()->route('home')->with('success', 'Email berhasil diverifikasi! Selamat datang di CPNS 2025.');
        }

        if ($user->isOtpExpired()) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan kirim ulang.']);
        }

        return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
    }

    /**
     * Resend OTP
     */
    public function resend()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home')->with('success', 'Email sudah terverifikasi.');
        }

        // Generate new OTP
        $otp = $user->generateOtp();

        // Send email
        try {
            Mail::to($user->email)->send(new OtpMail($otp, $user->name));
            
            return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email. Silakan coba lagi. Error: ' . $e->getMessage());
        }
    }
}
