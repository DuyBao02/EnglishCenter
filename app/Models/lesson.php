<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class lesson extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'id_lesson';
    
    protected $fillable = [
        'id_lesson',
        'start_time',
        'end_time',
    ];

    public function course()
    {
        return $this->belongsToMany(Course::class, 'course_lesson', 'lesson_id', 'course_id');
    }
}
