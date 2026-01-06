<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nik',
        'domisili',
        'ttl',
        'photo_path',
        'email_verified_at',
        'otp_code',
        'otp_expires_at',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is peserta
     */
    public function isPeserta(): bool
    {
        return $this->role === 'peserta';
    }

    /**
     * Get test sessions for the user
     */
    public function testSessions()
    {
        return $this->hasMany(TestSession::class);
    }

    /**
     * Generate participant number
     */
    public function getParticipantNumberAttribute(): string
    {
        return 'CPNS-' . date('Y') . '-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Generate OTP code
     */
    public function generateOtp(): string
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $this->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        return $otp;
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(string $otp): bool
    {
        if ($this->otp_code !== $otp) {
            return false;
        }

        if (Carbon::now()->isAfter($this->otp_expires_at)) {
            return false;
        }

        $this->update([
            'email_verified_at' => Carbon::now(),
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        return true;
    }

    /**
     * Check if email is verified
     */
    public function hasVerifiedEmail(): bool
    {
        return $this->email_verified_at !== null;
    }

    /**
     * Check if OTP is expired
     */
    public function isOtpExpired(): bool
    {
        if (!$this->otp_expires_at) {
            return true;
        }

        return Carbon::now()->isAfter($this->otp_expires_at);
    }
}
