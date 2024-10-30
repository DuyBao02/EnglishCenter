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
use App\Models\Bill;
use App\Models\Secondcourse;
use App\Models\Thirdcourse;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Room;

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


    public function CourseListStudent(Request $request)
    {
        $search = $request['search'] ?? '';
        if ($search != ''){
            $course3 =  Thirdcourse::where('id_3course', 'LIKE', "%$search%")
                                ->orWhere('name_course', 'LIKE', "%$search%")
                                ->orWhere('tuitionFee', 'LIKE', "%$search%")

                                ->orWhere(function ($query) use ($search) {
                                    $query->orWhere('rooms', 'LIKE', "%$search%")
                                        ->orWhereRaw('LENGTH(rooms) = 3 AND rooms LIKE ?', ['%' . $search . '%']);
                                })

                                ->orWhereHas('teacherUser3', function ($query) use ($search) {
                                    $query->where('name', 'LIKE', "%$search%");
                                })

                                ->orWhere(function ($query) use ($search) {
                                    for ($i = 0; $i < 7; $i++) { //Kiem tra 7 ngay trong tuan
                                        $query->orWhereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(days, "$['.$i.']"))) LIKE ?', ['%' . strtolower($search) . '%']);
                                    }
                                })
                                ->sortable()->paginate(3);
        }
        else {
            $course3 = Thirdcourse::sortable()->paginate(3);
        }
        return view('pages.ql_student.register_course_student', ['course3' => $course3, 'search' => $search]);
    }

    public function registerCourseStudent($userId, $courseId)
    {
        $user = User::find($userId);
        $course = Course::find($courseId);
        $secondcourse = Secondcourse::where('id_2course', $courseId)->first();
        $thirdcourse = Thirdcourse::where('id_3course', $courseId)->first();
        if($user && $course){

            if ($course->teacher == null && $secondcourse->teacher == null &&  $thirdcourse->teacher == null){
                return redirect()->back()->with('error', 'The ' . $course->name_course . ' does not have a teacher!');
            }

            $students_list = $course->students_list;
            array_push($students_list, $user->id);
            $course->students_list = $students_list;
            $course->save();

            if ($thirdcourse) {
                $students_list = $thirdcourse->students_list;
                array_push($students_list, $user->id);
                $thirdcourse->students_list = $students_list;
                $thirdcourse->save();
            }

            $bill = new Bill;
            $bill->user_id = $userId;
            $bill->name_bill = json_encode([$courseId]);
            $bill->tuitionFee = $course->tuitionFee;
            $bill->save();

            return redirect()->back()->with('success', 'Register successfully!');
        } else {
            return redirect()->back()->with('error', 'User or Course not found!');
        }
    }

    public function showCourseBillStudent(): View
    {
        // Lấy người dùng hiện tại
        $user = Auth::user();

        // Lấy tất cả hóa đơn của người dùng hiện tại
        $bills = Bill::where('user_id', $user->id)->get();

        if(!$bills->isEmpty())
            return view('pages.ql_student.tuition_student', ['bills' => $bills]);
        else
            return view('pages.ql_student.tuition_student');
    }

    public function showCalenderStudent(): View
    {
        return view('pages.ql_student.schedule_student');
    }

    public function getRegisteredCourses()
    {
        $user = Auth::user();
        $courses = Course::whereJsonContains('students_list', $user->id)->get();
        return $courses;
    }

    public function showRLDashBoardStudent()
    {
        $lessons = Lesson::all();
        $rooms = Room::all();
        return view('dashboard_student', compact(['lessons','rooms']));
    }

}
