<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'title',
        'description',
        'credits',
        'capacity',
        'instructor_id',
        'enrollment_start_at',
        'enrollment_end_at',
    ];

    protected $casts = [
        'enrollment_start_at' => 'datetime',
        'enrollment_end_at' => 'datetime',
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments')
            ->withTimestamps()
            ->withPivot('enrolled_at');
    }
}