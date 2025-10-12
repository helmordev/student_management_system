<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'priority',
        'created_by',
        'is_active',
        'publish_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'publish_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('publish_at')
                    ->orWhere('publish_at', '<=', now());
            });
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }
}
