<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\HasApiTokens;
use App\Models\Course;
use App\Models\Secondcourse;
use App\Models\Thirdcourse;
use App\Models\User;

class TeacherController extends Controller
{
    public function publicToTeacher($id)
    {
        $course2 = Secondcourse::where('id_2course', $id)->first();
        if (!$course2) {
            $course = Course::find($id);
            if ($course) {
                $secondcourse = new secondcourse;
                $secondcourse->id_2course = $course->id_course;
                $secondcourse->time_start = $course->time_start;
                $secondcourse->name_course = $course->name_course;
                $secondcourse->weeks = $course->weeks;
                $secondcourse->days = $course->days;
                $secondcourse->lessons = $course->lessons;
                $secondcourse->rooms = $course->rooms;
                $secondcourse->maxStudents = $course->maxStudents;
                $secondcourse->tuitionFee = $course->tuitionFee;
                $secondcourse->teacher = $course->teacher;
                $secondcourse->save();

                return redirect()->back()->with('success', 'Public to teacher successfully!');
            } else {
                return redirect()->back()->with('error', $course2->name_course . ' not found!');
            }
        }
        else {
            return redirect()->back()->with('error', 'You have already made ' . $course2->name_course . ' public to teachers!');
        }
    }

    public function CourseListTeacher()
    {
        $course2 = secondcourse::all();
        return view('pages.ql_teacher.courseList_teacher', ['course2' => $course2]);
    }

    public function registerCourseTeacher($userId, $courseId)
    {
        $user = User::find($userId);
        $course = Course::find($courseId);
        if($user && $course){
            // Check if the user has already registered for a course
            $registeredCourse = $user->registeredCourse;
            if ($registeredCourse) { 
                return redirect()->back()->with('error', 'You have already registered for course ' . $registeredCourse->id_course . '!');
            }
            
            $course->teacher = $user->id;

            $course->save();
    
            // Update the is_registered field of the corresponding secondcourse
            $secondcourse = Secondcourse::where('id_2course', $courseId)->first();
            if ($secondcourse) {
                $secondcourse->is_registered = true;
                $secondcourse->teacher = $user->id;

                $secondcourse->save();
            }

            $thirdcourse = Thirdcourse::where('id_3course', $courseId)->first();
            if ($thirdcourse) {
                $thirdcourse->teacher = $user->id;

                $thirdcourse->save();
            }
    
            return redirect()->back()->with('success', 'Register successfully!');
        } else {
            return redirect()->back()->with('error', 'User or Course not found!');
        }
    }

    public function StudentListTeacher($id)
    {
        $course = Course::find($id);
        if ($course && $course->teacher == Auth::user()->id) {
            $students_list = User::whereIn('id', $course->students_list)->get();
            session(['students_list' => $students_list]); // Lưu dữ liệu vào session
            return redirect()->route('student-list');
        }
        return redirect()->back()->with('error', 'Unauthorized access');
    }
    
    public function hienthiStudentList()
    {
        $students_list = session('students_list'); // Lấy dữ liệu từ session
        return view('pages.ql_teacher.student_list_teacher', compact('students_list'));      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
