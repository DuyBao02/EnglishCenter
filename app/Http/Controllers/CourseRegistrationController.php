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
        
        $course = Course::where('id_course', $request->id_course)->first();
        $name_course = Course::where('name_course', $request->name_course)->first();
        if($course){
            return redirect()->back()->with('error', 'The course already exists'); 
        }elseif($name_course){
            return redirect()->back()->with('error', 'The course name already exists'); 
        }

        // Check if there are any duplicate values in the days and rooms arrays
        $days = $request->input('days');
        if (count($days)!== count(array_unique($days))) {
            return redirect()->back()->with('error', 'Days has been duplicate'); 
        }

        //Sort days[] in order from Monday to Saturday (Bubble sort)
        $a = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $lessons = $request->input('lessons');
        $rooms = $request->input('rooms');

        for ($i = 0; $i < count($days); $i++) {
            for ($j = 0; $j < count($days) - $i - 1; $j++) {
                if (array_search($days[$j], $a) > array_search($days[$j + 1], $a)) {
                    // Swap days
                    $temp = $days[$j];
                    $days[$j] = $days[$j + 1];
                    $days[$j + 1] = $temp;

                    // Swap lessons
                    $temp = $lessons[$j];
                    $lessons[$j] = $lessons[$j + 1];
                    $lessons[$j + 1] = $temp;

                    // Swap rooms
                    $temp = $rooms[$j];
                    $rooms[$j] = $rooms[$j + 1];
                    $rooms[$j + 1] = $temp;
                }
            }
        }

        //Xử lý xung đột giữa khóa học đầu vào và các khóa học hiện có 
        $existingCourses = Course::all();
        
        foreach ($existingCourses as $existingCourse) {
            $existingDays = $existingCourse->days;
            $existingLessons = $existingCourse->lessons;
            $existingRooms = $existingCourse->rooms;
        
            for ($i = 0; $i < count($days); $i++) {
                $dayComparison = $days[$i] == $existingDays[$i] ? 'giống' : 'không giống';
                $lessonComparison = $lessons[$i] == $existingLessons[$i] ? 'giống' : 'không giống';
                $roomComparison = $rooms[$i] == $existingRooms[$i] ? 'giống' : 'không giống';
        
                $cases = [
                    'giốnggiốnggiống' => 'error',
                    'giốnggiốngkhông giống' => 'ok',
                    'giốngkhông giốnggiống' => 'ok',
                    'giốngkhông giốngkhông giống' => 'ok',
                    'không giống' => 'ok',
                ];
        
                $key = $dayComparison . $lessonComparison . $roomComparison;
        
                if (array_key_exists($key, $cases) && $cases[$key] == 'error') {
                    return redirect()->back()->with('error', 'The course schedule conflicts with an existing course');
                }
            }
        }

        $user = Auth::user();

        $course = Course::create([
            'id_course'  => $request->id_course,
            'name_course' => $request->name_course,
            'time_start' => $request->time_start,
            'weeks' => $request->weeks,
            'days' => $days, // Use sorted array
            'rooms' => $rooms, // Use sorted array
            'lessons' => $lessons, // Use sorted array
            'maxStudents' => $request->maxStudents,
            'tuitionFee' => $request->tuitionFee,
            'teacher' => $request->teacher,
            'students_list' => json_encode($request->input('students_list')),
            'user_id_create' => $user->id,
        ]);

        event(new Registered($course));

        $courses = Course::all()->map(function ($course) {
            $course->students_list = json_decode($course->students_list, true);
            return $course;
        });
        
        return redirect()->route('course-registration-create', ['courses' => $courses])
        ->with('success', 'Course registration successful!');
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
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
