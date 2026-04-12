<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'student_id',
        'major',
        'batch',
    ];
     // Each student belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
