<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'content',
        'domisili',
        'image_path',
    ];

    /**
     * Get category label
     */
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'tahapan' => 'Tahapan',
            'tata_cara' => 'Tata Cara',
            'pengumuman' => 'Pengumuman',
            default => ucfirst($this->category),
        };
    }

    /**
     * Get short excerpt
     */
    public function getExcerptAttribute(): string
    {
        return \Str::limit(strip_tags($this->content), 150);
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope by domisili
     */
    public function scopeByDomisili($query, $domisili)
    {
        return $query->where('domisili', $domisili);
    }
}
