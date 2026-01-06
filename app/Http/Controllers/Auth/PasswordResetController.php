<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * Show forgot password form
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send reset password link
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak ditemukan dalam sistem kami.',
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate token
        $token = Str::random(64);

        // Delete existing token for this email
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Insert new token
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

        // Generate reset link
        $resetLink = route('password.reset', ['token' => $token, 'email' => $request->email]);

        // Send email
        try {
            Mail::to($request->email)->send(new ResetPasswordMail($resetLink, $user->name));
            
            return back()->with('success', 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau folder spam.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email. Silakan coba lagi nanti. Error: ' . $e->getMessage());
        }
    }

    /**
     * Show reset password form
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required',
        ], [
            'email.exists' => 'Email tidak ditemukan.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Check token
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record) {
            return back()->withErrors(['email' => 'Token reset password tidak valid atau sudah kadaluarsa.']);
        }

        // Verify token
        if (!Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Token reset password tidak valid.']);
        }

        // Check if token is expired (60 minutes)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token reset password sudah kadaluarsa. Silakan request ulang.']);
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Delete token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login dengan password baru Anda.');
    }
}
