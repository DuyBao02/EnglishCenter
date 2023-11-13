<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Course extends Model
{
    use HasApiTokens, HasFactory, Notifiable, Sortable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $casts = [
        'days' => 'array',
        'rooms' => 'array',
        'lessons' => 'array',
        'students_list' => 'array',
    ];

    public $incrementing = false; //Xử lý việc khóa chính là chuỗi và không phải cột tự tăng
    protected $primaryKey = 'id_course';

    protected $fillable = [
        'id_course',
        'name_course',
        'time_start',
        'weeks',
        'days',
        'rooms',
        'lessons',
        'maxStudents',
        'tuitionFee',
        'teacher',
        'students_list',
        'user_id_create',
    ];

    public $sortable = ['id_course', 'name_course', 'time_start', 'weeks', 'tuitionFee', 'teacher', 'created_at', 'updated_at'];

    public function lesson()
    {
        return $this->belongsToMany(Lesson::class, 'course_lesson', 'course_id', 'lesson_id');
    }

    public function room()
    {
        return $this->belongsToMany(Room::class, 'course_room', 'course_id', 'room_id');
    }

    public static function getTuitionFeeInUSD($id_course, $exchangeRate = 23000)
    {
        $course = self::find($id_course);
        if ($course) {
            return $course->tuitionFee / $exchangeRate;
        }
        return 0;
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'course_room', 'course_id', 'user_id');
    }

    public function teacherUser()
    {
        return $this->belongsTo(User::class, 'teacher');
    }

    public function secondCourse()
    {
        return $this->hasOne(Secondcourse::class, 'id_2course', 'id_course');
    }

    public function thirdCourse()
    {
        return $this->hasOne(Thirdcourse::class, 'id_3course', 'id_course');
    }

}
