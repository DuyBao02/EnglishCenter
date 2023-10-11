<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class course extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'days' => 'json',
        'lesson' => 'json',
        'rooms' => 'json',
        'students_list' => 'json',
    ];

    protected $fillable = [
        'id_course',
        'name_course',
        'weeks',
        'days',
        'rooms',
        'lesson',
        'maxStudents',
        'tuitionFee',
        'teacher',
        'students_list',
    ];

    public function lesson()
    {
        return $this->belongsToMany(Lesson::class, 'course_lesson', 'course_id', 'lesson_id');
    }

    public function room()
    {
        return $this->belongsToMany(Room::class, 'course_room', 'course_id', 'room_id');
    }

    public function bill()
    {
        return $this->hasMany(Bill::class);
    }

    public function homework()
    {
        return $this->hasMany(Homework::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
