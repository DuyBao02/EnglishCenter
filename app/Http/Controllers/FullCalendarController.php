<?php
   
namespace App\Http\Controllers;
   
use App\Event;
use Illuminate\Http\Request;
use Redirect,Response;
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
use Carbon\Carbon;

class FullCalendarController extends Controller
{
 
    public function index()
    {
        $user = Auth::user();

        if(request()->ajax()) 
        {
            if  ($user->role == 'Student') {
                $studentController = new StudentController();
                $courses = $studentController->getRegisteredCourses();
            }
            elseif  ($user->role == 'Teacher') {
                $teacherController = new TeacherController();
                $courses = $teacherController->getRegisteredCoursesTeacher();
            }
            elseif  ($user->role == 'Admin') {
                $adminController = new AdminController();
                $courses = $adminController->getRegisteredCoursesAdmin();
            }
            
    
            $events = [];
            $colors = ['yellow', 'blue', 'red', 'green', 'purple', 'orange', 'pink']; // Mảng màu sắc
            $colorIndex = 0;
    
            foreach ($courses as $course) {
                $days = $course->days; // 'days' đã được chuyển đổi thành mảng PHP
                $time_start = Carbon::createFromFormat('Y-m-d', $course->time_start);
    
                $dayOfWeek = ['Sunday' => 0, 'Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6];
    
                for ($week = 0; $week < $course->weeks; $week++) {
                    foreach ($days as $index => $day) {
                        
                        $event = [];
                        $event['id'] = $course->id_course;
    
                        // Tìm ngày tiếp theo tương ứng với ngày trong mảng Days từ ngày bắt đầu khóa học
                        $nextDay = $time_start->copy()->addWeeks($week)->next($dayOfWeek[$day]);
                        $event['start'] = $nextDay->format('Y-m-d H:i:s');
                        $event['end'] = $nextDay->format('Y-m-d H:i:s');
                        $event['color'] = $colors[$colorIndex];
                        $event['allDay'] = true; // Sự kiện suốt cả ngày
    
                        // Đặt tiêu đề sự kiện
                        $event['title'] = $course->id_course . "\n" . 'Lesson: ' . $course->lessons[$index] . "\n" . 'Room: ' . $course->rooms[$index];    
                        $events[] = $event;
                    }
                }
                $colorIndex++;
                if($colorIndex >= count($colors)) {
                    $colorIndex = 0; 
                  }
            }
    
            return Response::json($events);
        }

        if  ($user->role == 'Student') {
            return redirect()->route('schedule-student');
        }
        elseif  ($user->role == 'Teacher') {
            return redirect()->route('schedule-teacher');
        }
        elseif  ($user->role == 'Admin') {
            return redirect()->route('course-admin');
        }
        
    }
    
    // // Hiển thị ngày bắt đầu khóa học lên calendar
    // public function index()
    // {
    //     if(request()->ajax()) 
    //     {
    //         $studentController = new StudentController();
    //         $courses = $studentController->getRegisteredCourses();
    
    //         $events = [];
    //         foreach ($courses as $course) {
    //             $event = [];
    //             $event['id'] = $course->id_course;
    //             $event['title'] = $course->name_course; // Đặt tiêu đề sự kiện
    //             $time_start = Carbon::createFromFormat('Y-m-d', $course->time_start)->format('Y-m-d H:i:s');
    //             $event['start'] = $time_start;
    //             $event['end'] = $time_start;
    //             $event['color'] = 'yellow';
    //             $event['allDay'] = true; // Sự kiện suốt cả ngày
    //             $events[] = $event;
    //         }
    
    //         return Response::json($events);
    //     }
    //     return redirect()->route('schedule-student');
    // }
   
    public function create(Request $request)
    {  
        $insertArr = [ 'title' => $request->title,
                       'start' => $request->start,
                       'end' => $request->end
                    ];
        $event = Event::insert($insertArr);   
        return Response::json($event);
    }
     
 
    public function update(Request $request)
    {   
        $where = array('id' => $request->id);
        $updateArr = ['title' => $request->title,'start' => $request->start, 'end' => $request->end];
        $event  = Event::where($where)->update($updateArr);
 
        return Response::json($event);
    } 
 
 
    public function destroy(Request $request)
    {
        $event = Event::where('id',$request->id)->delete();
   
        return Response::json($event);
    }    
 
 
}
