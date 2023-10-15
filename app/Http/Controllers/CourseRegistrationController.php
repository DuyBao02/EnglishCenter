<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Room;
use App\Models\Lesson;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class CourseRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //
    }

    /**
     * Display the registration view for regular users.
     */
    public function create(): View
    {   
        $courses = Course::all();
        return view('pages.ql_admin.course_admin', ['courses' => $courses]);
    }

    /**
     * Handle an incoming registration request for regular users.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        //dd($request->all());

        // Validate form data
        $request->validate([
            'id_course'  => ['required'],
            'name_course' => ['required'],
            'weeks' => ['required'],
            'days.*' => ['required'],
            'rooms.*' => ['required'],
            'lessons.*' => ['required'],
            'maxStudents' => ['required'],
            'tuitionFee' => ['required'],
            'teacher' => ['nullable'],
            'students_list.*' => ['nullable'],
            'user_id' => ['nullable'],
        ]);

        // // Lấy giá trị của mảng từ request và chuyển thành chuỗi JSON
        // $days = json_encode($request->input('days'));
        // $lessons = json_encode($request->input('lessons'));
        // $rooms = json_encode($request->input('rooms'));
        // $students_list = json_encode($request->input('students_list'));

        $user = Auth::user();

        $course = Course::create([
            'id_course'  => $request->id_course,
            'name_course' => $request->name_course,
            'time_start' => $request->time_start,
            'weeks' => $request->weeks,
            'days' => $request->input('days'),
            'rooms' => $request->input('rooms'),
            'lessons' => $request->input('lessons'),
            'maxStudents' => $request->maxStudents,
            'tuitionFee' => $request->tuitionFee,
            'teacher' => $request->teacher,
            'students_list' => json_encode($request->input('students_list')),
            'user_id_create' => $user->id,
        ]);
        

        event(new Registered($course));

        session()->flash('success', 'Course registration successful!');

        $courses = Course::all()->map(function ($course) {
            $course->students_list = json_decode($course->students_list, true);
            return $course;
        });
        
        return redirect()->route('course-registration-create', ['courses' => $courses]);
    }

    public function getLessonsAndRoomsForCreateCourse()
    {
        $lessons = Lesson::all();
        $rooms = Room::all();
        return view('pages.ql_admin.create_course', ['rooms' => $rooms, 'lessons' => $lessons]);
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
    public function edit($id)
    {
        $course = Course::where('id_course', $id)->first();
        $lessons = Lesson::all(); // Lấy danh sách các bài học từ cơ sở dữ liệu
        $rooms = Room::all();
        if ($course) {
            return view('pages.ql_admin.course_edit', compact('course', 'lessons', 'rooms')); // Truyền biến $lessons vào view
        } else {
            return redirect()->route('course-admin')->with('error', 'Course not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::where('id_course', $id)->first();
        $course->update($request->all());
        return redirect()->route('course-admin')->with('success', 'Course update successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::where('id_course', $id)->first();
        if ($course) {
            $course->delete();
            session()->flash('success', 'Course deleted successfully!');
        } else {
            session()->flash('error', 'Course not found!');
        }
        return redirect()->route('course-admin');
    }
}
