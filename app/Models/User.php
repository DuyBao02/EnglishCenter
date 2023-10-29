<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Model;
use App\Models\Course;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'birthday',
        'address',
        'phone',
        'role',
        'experience',
        'level',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function bills()
    {
        return $this->hasMany(Bill::class, 'user_id');
    }

    public function isPaid($courseId)
    {
        $bill = $this->bills()->where('name_bill', 'like', '%' . $courseId . '%')->first();
        return $bill ? $bill->is_paid : false;
    }
    
    public function isCoursePaid($courseName)
    {
        $course = Course::where('name_course', $courseName)->first();
        if ($course) {
            return $this->isPaid($course->id_course);
        }
        return false;
    }
    

    public function course()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id');
    }

    public function hasRole($role)
    {
        return $this->role == $role;
    }

    public function registeredCourse()
    {
        return $this->hasOne(Course::class, 'teacher', 'id');
    }
    
    public function registeredCourseStudent()
    {
        $courses = Course::whereJsonContains('students_list', $this->id)->get();
        if ($courses->isNotEmpty()) {
            return $courses->pluck('name_course')->toArray();
        }
        return null;
    }

    public function registeredCourseTeacher()
    {
        $courses = Course::whereJsonContains('teacher', $this->id)->get();
        if ($courses->isNotEmpty()) {
            return $courses->pluck('name_course')->toArray();
        }
        return null;
    }

    public function pendingEdit()
    {
        return $this->hasOne(Edit::class)->where('status', 'pending');
    }
    
    public function pendingSecondEdit()
    {
        return $this->hasOne(Secondedit::class)->where('status', 'pending');
    }
}