<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;

class Secondcourse extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
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
    protected $primaryKey = 'id_2course';

    protected $fillable = [
        'id_2course',
        'name_course',
        'time_start',
        'weeks',
        'days',
        'rooms',
        'lessons',
        'maxStudents',
        'tuitionFee',
        'teacher',
        'is_registered',
    ];

    public function teacherUser2()
    {
        return $this->belongsTo(User::class, 'teacher');
    }
    
}
