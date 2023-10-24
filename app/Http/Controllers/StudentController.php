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

class StudentController extends Controller
{

    public function publicToStudent($id)
    {
        $course = Course::find($id);
        if (!$course) {
            return redirect()->back()->with('error', 'Course not found!');
        }
        
        $course2 = Secondcourse::find($id);
        if (!$course2) {
            return redirect()->back()->with('error', 'You must public '. $course->name_course .' to teacher first!');
        }

        if (!$course->teacher) {
            return redirect()->back()->with('error', $course->name_course . ' does not have a registered teacher!');
        }

        $course3 = Thirdcourse::where('id_3course', $id)->first();
        if ($course3) {
            return redirect()->back()->with('error', 'You have already made ' . $course3->name_course . ' public to student!');
        }else{
            $thirdcourse = new Thirdcourse;
            $thirdcourse->id_3course = $course->id_course;
            $thirdcourse->time_start = $course->time_start;
            $thirdcourse->name_course = $course->name_course;
            $thirdcourse->weeks = $course->weeks;
            $thirdcourse->days = $course->days;
            $thirdcourse->lessons = $course->lessons;
            $thirdcourse->rooms = $course->rooms;
            $thirdcourse->maxStudents = $course->maxStudents;
            $thirdcourse->tuitionFee = $course->tuitionFee;
            $thirdcourse->teacher = $course->teacher;
            $thirdcourse->students_list = $course->students_list;
            
            $thirdcourse->save();
            
            return redirect()->back()->with('success', 'Public to student successfully!');
        }
    }
    

    public function CourseListStudent()
    {
        $course3 = thirdcourse::all();
        return view('pages.ql_student.register_course_student', ['course3' => $course3]);
    }

    public function registerCourseStudent($userId, $courseId)
    {
        $user = User::find($userId);
        $course = Course::find($courseId);
        $secondcourse = Secondcourse::where('id_2course', $courseId)->first();
        $thirdcourse = Thirdcourse::where('id_3course', $courseId)->first();
        if($user && $course){
            // Check if the user has already registered for a course
            $registeredCourse = $user->registeredCourseStudent();
            if ($registeredCourse) { 
                return redirect()->back()->with('error', 'You have already registered for course ' . $user->registeredCourseStudent() . '!');
            }

            if ($course->teacher == null && $secondcourse->teacher == null &&  $thirdcourse->teacher == null){
                return redirect()->back()->with('error', 'The ' . $course->name_course . ' does not have a teacher!');
            }
            
            $students_list = $course->students_list;
            array_push($students_list, $user->id);
            $course->students_list = $students_list;
            $course->save();

            $students_list = $thirdcourse->students_list;
            array_push($students_list, $user->id);
            $thirdcourse->students_list = $students_list;
            $thirdcourse->save();
    
            return redirect()->back()->with('success', 'Register successfully!');
        } else {
            return redirect()->back()->with('error', 'User or Course not found!');
        }
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