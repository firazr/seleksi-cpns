<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'domisili_penempatan',
        'category',
        'started_at',
        'finished_at',
        'score',
        'score_twk',
        'score_tiu',
        'score_tkp',
        'answers',
        'shuffled_questions',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'answers' => 'array',
        'shuffled_questions' => 'array',
    ];

    /**
     * Get the user for this session
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if session is completed
     */
    public function isCompleted(): bool
    {
        return $this->finished_at !== null;
    }

    /**
     * Check if session is still active (within time limit)
     */
    public function isActive(): bool
    {
        if ($this->isCompleted()) {
            return false;
        }
        
        // 90 minutes time limit
        $timeLimit = 90 * 60;
        $elapsed = now()->diffInSeconds($this->started_at);
        
        return $elapsed < $timeLimit;
    }

    /**
     * Get remaining time in seconds
     */
    public function getRemainingTimeAttribute(): int
    {
        $timeLimit = 90 * 60;
        $elapsed = now()->diffInSeconds($this->started_at);
        
        return max(0, $timeLimit - $elapsed);
    }

    /**
     * Get category label
     */
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'TWK' => 'Tes Wawasan Kebangsaan',
            'TIU' => 'Tes Intelegensia Umum',
            'TKP' => 'Tes Karakteristik Pribadi',
            'full' => 'Paket Lengkap (TWK, TIU, TKP)',
            default => $this->category,
        };
    }

    /**
     * Scope by domisili penempatan
     */
    public function scopeByDomisiliPenempatan($query, $domisili)
    {
        return $query->where('domisili_penempatan', $domisili);
    }

    /**
     * Scope completed sessions
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('finished_at');
    }
}
