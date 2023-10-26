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

class FullCalendarController extends Controller
{
 
    public function index()
    {
        if(request()->ajax()) 
        {
            $studentController = new StudentController();
            $courses = $studentController->getRegisteredCourses();
    
            $events = [];
            foreach ($courses as $course) {
                $event = [];
                $event['id'] = $course->id_course;
                $event['title'] = 'Time Course Create'; // Đặt tiêu đề sự kiện
                $event['start'] = $course->time_start;
                $event['end'] = $course->time_start;
                $event['color'] = 'red';
                $event['allDay'] = true; // Sự kiện suốt cả ngày
                $events[] = $event;
            }
    
            return Response::json($events);
        }
        return redirect()->route('schedule-student');
    }
    
    
   
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
