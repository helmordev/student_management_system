<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject',
        'subject_code',
        'grade',
        'units',
        'academic_year',
        'semester',
        'remarks',
    ];

    protected $casts = [
        'grade' => 'decimal:2',
        'units' => 'integer',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function getLetterGradeAttribute()
    {
        if ($this->grade >= 90) {
            return 'A';
        } elseif ($this->grade >= 80) {
            return 'B';
        } elseif ($this->grade >= 70) {
            return 'C';
        } elseif ($this->grade >= 60) {
            return 'D';
        }

        return 'F';
    }
}
