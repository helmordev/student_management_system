<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_id',
        'action',
        'description',
        'ip_address',
        'user_agent',
        'performed_at',
    ];

    protected $casts = [
        'performed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'student_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->performed_at)) {
                $model->performed_at = now();
            }
        });
    }
}
