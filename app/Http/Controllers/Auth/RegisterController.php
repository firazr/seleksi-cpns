<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * List of available domisili
     */
    protected $domisiliList = [
        'Jakarta',
        'Bandung',
        'Surabaya',
        'Yogyakarta',
        'Semarang',
        'Medan',
        'Makassar',
        'Palembang',
        'Denpasar',
        'Pontianak',
    ];

    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        $domisiliList = $this->domisiliList;
        return view('auth.register', compact('domisiliList'));
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'nik' => 'required|string|size:16|unique:users',
            'domisili' => 'required|string|in:' . implode(',', $this->domisiliList),
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => ['required', 'date'],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nik.size' => 'NIK harus terdiri dari 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid',
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        // Format TTL: "Tempat Lahir, DD MMMM YYYY"
        $tanggalFormatted = \Carbon\Carbon::parse($validated['tanggal_lahir'])->translatedFormat('d F Y');
        $ttl = $validated['tempat_lahir'] . ', ' . $tanggalFormatted;

        // Create user with role peserta
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'peserta',
            'nik' => $validated['nik'],
            'domisili' => $validated['domisili'],
            'ttl' => $ttl,
            'photo_path' => $photoPath,
        ]);

        // Generate OTP and send email
        $otp = $user->generateOtp();

        try {
            Mail::to($user->email)->send(new OtpMail($otp, $user->name));
        } catch (\Exception $e) {
            // Log error but don't fail registration
            \Log::error('Failed to send OTP email: ' . $e->getMessage());
        }

        // Login user automatically
        Auth::login($user);

        return redirect()->route('verification.notice')->with('success', 'Pendaftaran berhasil! Silakan verifikasi email Anda.');
    }
}
