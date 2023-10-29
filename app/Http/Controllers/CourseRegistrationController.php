<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Room;
use App\Models\Lesson;
use App\Models\Secondcourse;
use App\Models\Thirdcourse;
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
     * Display the registration view for regular users.
     */
    public function create(): View
    {   
        $courses = Course::all();
        $secondCourses = Secondcourse::all()->pluck('id_2course')->toArray();
        $thirdCourses = Thirdcourse::all()->pluck('id_3course')->toArray();
        return view('pages.ql_admin.course_admin', ['courses' => $courses, 'secondCourses' => $secondCourses, 'thirdCourses' => $thirdCourses]);
    }
    
    /**
     * Handle an incoming registration request for regular users.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
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
        ]);
    
        if (Course::where('id_course', $request->id_course)->exists() ) {
            return redirect()->back()->withInput($request->input())->with('error', $request->id_course . ' already exists!');
        }

        if (Course::where('name_course', $request->name_course)->exists()) {
            return redirect()->back()->withInput($request->input())->with('error', $request->name_course . ' already exists!'); 
        }
    
        if (strlen(floor($request->tuitionFee)) > 8) {
            return redirect()->back()->withInput($request->input())->with('error', 'Tuition fees do not exceed 8 figures!');
        }

        $a = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $days = $request->input('days');
        $rooms = $request->input('rooms');
        $lessons = $request->input('lessons');

        for ($i = 0; $i < count($days); $i++) {
            for ($j = 0; $j < count($days) - $i - 1; $j++) {
                if (array_search($days[$j], $a) > array_search($days[$j + 1], $a) || (array_search($days[$j], $a) == array_search($days[$j + 1], $a) && $lessons[$j] > $lessons[$j + 1])) {
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
        
        $data = collect($request->input('days'))->map(function ($day, $index) use ($request, $a) {
            return ['day' => $day, 'lesson' => $request->input('lessons')[$index], 'room' => $request->input('rooms')[$index], 'index' => array_search($day, $a)];
        })->sortBy(['index', 'lesson']);

        if ($data->duplicates(function ($value) {

            return $value['day'] . $value['lesson'];

        })->isNotEmpty()) {

            $duplicate = $data->duplicates(function ($value) {
                return $value['day'] . $value['lesson'];
            })->first();
            return redirect()->back()->withInput($request->input())->with('error', 'Lessons ' . $duplicate['lesson'] . ' overlap within ' . $duplicate['day'] . '!');
        }

        $existingCourses = Course::all();
        foreach ($existingCourses as $existingCourse) {
            for ($i = 0; $i < count($data); $i++) {
                for ($j = 0; $j < count($existingCourse->days); $j++) {
                    if ($data[$i]['day'] == $existingCourse->days[$j] && $data[$i]['lesson'] == $existingCourse->lessons[$j] && $data[$i]['room'] == $existingCourse->rooms[$j]) {
                        return redirect()->back()->withInput($request->input())->with('error', $data[$i]['day'] . ', Lesson ' . $data[$i]['lesson'] . ', Room ' . $data[$i]['room'] . ' already exist in ' . $existingCourse->name_course . '!');
                    }
                }
            }
        }
    
        $course = Course::create([
            'id_course'  => $request->id_course,
            'name_course' => $request->name_course,
            'time_start' => $request->time_start,
            'weeks' => $request->weeks,
            'days' => $data->pluck('day')->all(),
            'rooms' => $data->pluck('room')->all(),
            'lessons' => $data->pluck('lesson')->all(),
            'maxStudents' => $request->maxStudents,
            'tuitionFee' => $request->tuitionFee,
            'teacher' => $request->teacher,
            'students_list' => array_filter($request->input('students_list', [])),
        ]);
        
        // Kiểm tra xem trường 'teacher' có giá trị hay không
        if ($request->teacher) {
            // Tạo một bản ghi mới trong bảng 'Secondcourse'
            Secondcourse::create([
                'id_2course'  => $request->id_course,
                'name_course' => $request->name_course,
                'time_start' => $request->time_start,
                'weeks' => $request->weeks,
                'days' => $data->pluck('day')->all(),
                'rooms' => $data->pluck('room')->all(),
                'lessons' => $data->pluck('lesson')->all(),
                'maxStudents' => $request->maxStudents,
                'tuitionFee' => $request->tuitionFee,
                'teacher' => $request->teacher,
                'students_list' => array_filter($request->input('students_list', [])),
                'is_registered' => true,
            ]);
        }

        event(new Registered($course));
        
        return redirect()->route('course-registration-create', ['courses' => Course::all()])
        ->with('success', $course->name_course . ' registration successful!');
    }
    

    public function getLessonsAndRoomsForCreateCourse()
    {
        $lessons = Lesson::all();
        $rooms = Room::all();
        $teachers = User::where('role', 'Teacher')->get();
        $notRegisteredTeachers = $teachers->filter(function ($teacher) {
            return $teacher->registeredCourse == null;
        });
        return view('pages.ql_admin.create_course', ['rooms' => $rooms, 'lessons' => $lessons, 'notRegisteredTeachers' => $notRegisteredTeachers]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editForm($id)
    {
        $course = Course::where('id_course', $id)->first();
        $secondCourse = $course->secondCourse;
        $thirdCourse = $course->thirdCourse;
        $lessons = Lesson::all();
        $rooms = Room::all();
        if ($course) {
            // Truyền biến $lessons vào view
            return view('pages.ql_admin.course_edit', compact('course', 'lessons', 'rooms', 'secondCourse', 'thirdCourse'));
        } else {
            return redirect()->route('course-admin')->with('error', $course->name_course . ' not found!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::where('id_course', $id)->first();
        
        if (Course::where('name_course', $request->name_course)->exists()) {
            return redirect()->back()->with('error', $request->name_course . ' already exists!'); 
        }
    
        $a = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $days = $request->input('days');
        $rooms = $request->input('rooms');
        $lessons = $request->input('lessons');

        for ($i = 0; $i < count($days); $i++) {
            for ($j = 0; $j < count($days) - $i - 1; $j++) {
                if (array_search($days[$j], $a) > array_search($days[$j + 1], $a) || (array_search($days[$j], $a) == array_search($days[$j + 1], $a) && $lessons[$j] > $lessons[$j + 1])) {
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
        
        $data = collect($request->input('days'))->map(function ($day, $index) use ($request, $a) {
            return ['day' => $day, 'lesson' => $request->input('lessons')[$index], 'room' => $request->input('rooms')[$index], 'index' => array_search($day, $a)];
        })->sortBy(['index', 'lesson']);

        if ($data->duplicates(function ($value) {
            return $value['day'] . $value['lesson'];
        })->isNotEmpty()) {
            return redirect()->back()->withInput($request->input())->with('error', 'Lessons ' . $duplicate['lesson'] . ' overlap within ' . $duplicate['day'] . '!');
        }

        $existingCourses2 = Course::where('id_course', '!=', $id)->get();
        foreach ($existingCourses2 as $existingCourse2) {
            for ($i = 0; $i < count($data); $i++) {
                for ($j = 0; $j < count($existingCourse2->days); $j++) {
                    if ($data[$i]['day'] == $existingCourse2->days[$j] && $data[$i]['lesson'] == $existingCourse2->lessons[$j] && $data[$i]['room'] == $existingCourse2->rooms[$j]) {
                        return redirect()->back()->withInput($request->input())->with('error', $data[$i]['day'] . ', Lesson ' . $data[$i]['lesson'] . ', Room ' . $data[$i]['room'] . ' already exist in ' . $existingCourse->name_course . '!');
                    }
                }
            }
        }

        $course->update($request->all());

        $secondCourse = $course->secondCourse;
        if ($secondCourse) {
            $secondCourse->update($request->all());
        }

        $thirdCourse = $course->thirdCourse;
        if ($thirdCourse) {
            $thirdCourse->update($request->all());
        }

        return redirect()->route('course-admin')->with('success', $course->name_course . ' update successful!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = Auth::user();
        $course = Course::where('id_course', $id)->first();

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Incorrect password!');
        }

        if ($course) {
            $secondCourse = $course->secondCourse;
            if ($secondCourse) {
                $secondCourse->delete();
            }

            $thirdCourse = $course->thirdCourse;
            if ($thirdCourse) {
                $thirdCourse->delete();
            }

            $course->delete();
            return redirect()->back()->with('success', $course->name_course . ' has been deleted!');
        } else {
            return redirect()->back()->with('error', $course->name_course . ' not found!');
        }
    }

    public function StudentListAdmin($courseID)
    {
        $course = Course::find($courseID);
    
        if ($course) {
            if ($course->teacherUser) {
                $students_list = User::whereIn('id', $course->students_list)->get();
                $get_name_course = $course->name_course; // Lấy tên của khóa học
                $get_id_course = $course->id_course; //Lấy id khóa học
                session(['students_list' => $students_list, 'get_name_course' => $get_name_course, 'get_id_course' => $get_id_course]); // Lưu dữ liệu vào session
                if ($students_list->isEmpty()){
                    return redirect()->back()->with('error', 'Cannot watch because there is no student yet!');
                }
                return redirect()->route('student-list-admin');
            } else {
                return redirect()->back()->with('error', 'Cannot watch because there is no teacher yet!');
            }
        }
        return redirect()->back()->with('error', 'Unauthorized access');
    }

    public function hienthiStudentListA()
    {
        $students_list = session('students_list'); // Lấy dữ liệu từ session
        $get_name_course = session('get_name_course');
        $get_id_course = session('get_id_course');
        return view('pages.ql_admin.student_list_admin', compact('students_list', 'get_name_course', 'get_id_course'));
    }
    
}
