<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_option',
    ];

    /**
     * Get category label
     */
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'TWK' => 'Tes Wawasan Kebangsaan',
            'TIU' => 'Tes Intelegensia Umum',
            'TKP' => 'Tes Karakteristik Pribadi',
            default => $this->category,
        };
    }

    /**
     * Get options as array
     */
    public function getOptionsAttribute(): array
    {
        return [
            'a' => $this->option_a,
            'b' => $this->option_b,
            'c' => $this->option_c,
            'd' => $this->option_d,
        ];
    }

    /**
     * Check if answer is correct
     */
    public function isCorrect(string $answer): bool
    {
        return strtolower($answer) === strtolower($this->correct_option);
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $category)
    {
        if ($category === 'full') {
            return $query;
        }
        return $query->where('category', $category);
    }
}
