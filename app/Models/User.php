<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role',
        'student_id',
        'full_name',
        'email',
        'password',
        'course',
        'year_level',
        'phone',
        'address',
        'is_active',
    ];

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
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'created_by');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'user_id');
    }

    // Scopes
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getAcademicYearAttribute()
    {
        if ($this->student_id) {
            return substr($this->student_id, 0, 4);
        }
        return null;
    }

    public function getGpaAttribute()
    {
        $grades = $this->grades;
        if ($grades->isEmpty()) {
            return 0;
        }

        $totalUnits = $grades->sum('units');
        $totalWeightedGrade = $grades->sum(function ($grade) {
            return $grade->grade * $grade->units;
        });

        return $totalUnits > 0 ? round($totalWeightedGrade / $totalUnits, 2) : 0;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }
}
