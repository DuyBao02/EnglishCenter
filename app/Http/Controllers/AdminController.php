<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Bill;
use App\Models\Secondcourse;
use App\Models\Thirdcourse;
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

class AdminController extends Controller
{

    public function teacherManagement()
    {
        //Chia teacher co khoa hoc va chua co khoa hoc
        $teachers = User::where('role', 'Teacher')->get();
        $registeredTeachers = $teachers->filter(function ($teacher) {
            return $teacher->registeredCourse != null;
        });
        $notRegisteredTeachers = $teachers->diff($registeredTeachers);
    
        return view('pages.ql_admin.teacher_management', [
            'totalTeachers' => $teachers->count(),
            'registeredTeachers' => $registeredTeachers,
            'notRegisteredTeachers' => $notRegisteredTeachers,
        ]);
    }
    
    public function deleteTeacherfromCourse($userId, $courseName)
    {
        $course = Course::where('name_course', $courseName)->first();
        $secondCourse = Secondcourse::where('name_course', $courseName)->first();
        $thirdCourse = Thirdcourse::where('name_course', $courseName)->first();
        $user = User::find($userId);
    
        if (!$course && !$secondCourse && !$thirdCourse) {
            return response()->json(['error' => $courseName .' not found!'], 404);
        }
    
        if (!$user) {
            return response()->json(['error' => 'User not found!'], 404);
        }
    
        // Kiểm tra (có cột teacher, cột is_registered là true trong SecondCourse)
        if (($secondCourse && $secondCourse->teacher == $userId && $secondCourse->is_registered) || 
            ($thirdCourse && $thirdCourse->teacher == $userId) || 
            ($course && $course->teacher == $userId)) {
            // Kiểm tra nếu students_list không rỗng trong Course)
            if (!empty($course->students_list) && !empty($thirdCourse->students_list)) {
                return response()->json(['error' => 'It cannot be deleted, the Course still has students!'], 400);
            } else {
                // Nếu students_List rỗng trong Course
                // Tiến hành xóa userId
                if ($secondCourse) {
                    $secondCourse->teacher = null;
                    $secondCourse->is_registered = false;
                    $secondCourse->save();
                }
    
                if ($thirdCourse) {
                    $thirdCourse->teacher = null;
                    $thirdCourse->save();
                }
    
                if ($course) {
                    $course->teacher = null;
                    $course->save();
                }
    
                return response()->json(['success' => 'Teacher removed from ' . $courseName . ' successfully!'], 200);
            }
        } else {
            return response()->json(['error' => 'Teacher not found in ' . $courseName . ' or not registered!'], 404);
        }
    }

    public function confirmDelete(Request $request, $id)
    {
        $userToDelete = User::find($id);
    
        // Get the current authenticated user
        $currentUser = Auth::user();
    
        if (!$userToDelete) {
            return redirect()->back()->with('error', 'User not found!'); 
        }
    
        // Check if the current user's password matches the input password
        if (!Hash::check($request->password, $currentUser->password)) {
            return redirect()->back()->with('error', 'Incorrect password!');
        }
    
        $userToDelete->delete();
    
        return redirect()->back()->with('success', 'User removed successfully!');
    }
    

    public function studentManagement()
    {
        //Lay tat ca students
        $students = User::where('role', 'Student')->get();
    
        //Lay tat ca courses
        $courses = Course::all();
    
        //Tao 1 mang luu nhung student da dang ky Course
        $registeredStudentIds = [];
    
        // Loop through each course
        foreach ($courses as $course) {
            if ($course->students_list) {
                // Merge the students_list of the course into the registeredStudentIds array
                $registeredStudentIds = array_merge($registeredStudentIds, $course->students_list);
            }
        }
    
        //Loai bo Id trung
        $registeredStudentIds = array_unique($registeredStudentIds);
    
        $registeredStudents = $students->whereIn('id', $registeredStudentIds);
        $notRegisteredStudents = $students->whereNotIn('id', $registeredStudentIds);
    
        // Get the courses for each registered student
        foreach ($registeredStudents as $student) {
            $student->courses = $student->course()->get();
        }
    
        return view('pages.ql_admin.student_management', [
            'totalStudents' => $students->count(),
            'registeredStudents' => $registeredStudents,
            'notRegisteredStudents' => $notRegisteredStudents,
        ]);
    }
    
    
    public function deleteStudentfromCourse($userId, $idCourse)
    {
        
        // Kiểm tra courseName có tồn tại trong bảng Course không
        $course = Course::where('id_course', $idCourse)->first();
        $thirdCourse = ThirdCourse::where('id_3course', $idCourse)->first();
        $user = User::find($userId);
    
        if (!$course && !$thirdCourse) {
            return response()->json(['error' => 'Course not found!'], 404);
        }
    
        if (!$user) {
            return response()->json(['error' => 'User not found!'], 404);
        }
    
        // Kiểm tra userId có tồn tại trong mảng students_list không
        $studentsListCourse = $course ? $course->students_list : [];
        $studentsListThirdCourse = $thirdCourse ? $thirdCourse->students_list : [];
    
        if (!in_array($userId, $studentsListCourse) && !in_array($userId, $studentsListThirdCourse)) {
            return response()->json(['error' => 'This user not found in Course!'], 404);
        }
        
        // User thanh toán rồi thì không được xóa khỏi Course
        // $bills = Bill::where('user_id', $userId)->get();
        // foreach ($bills as $bill) {
        //     if ($bill->is_paid){
        //         $nameBill = json_decode($bill->name_bill, true);
        //         if (in_array($idCourse, $nameBill)) {
        //             return response()->json(['error' => 'You cannot remove because they have already paid their tuition!'], 409);
        //         }
        //     }
        //     elseif (!$bill->is_paid) {
        //         $nameBill = json_decode($bill->name_bill, true);
        //         if (in_array($idCourse, $nameBill)) {
        //             $nameBill = array_diff($nameBill, [$idCourse]); // remove the value from array
        //             $nameBill = array_values($nameBill); // re-index the array
        //             $bill->name_bill = json_encode($nameBill);
        //             if(empty($nameBill)) {
        //                 $bill->delete();
        //             } else {
        //                 $bill->tuitionFee -= $course->tuitionFee;
        //                 $bill->save();
        //             }
        //         }
        //     }
        // }

        // User thanh toán tiền rôì vẫn xóa khỏi Course được và xóa luôn bill đã thanh toán 
        $bill = Bill::where('user_id', $userId)->first();
        if($bill){
            $nameBill = json_decode($bill->name_bill, true);
            if (in_array($idCourse, $nameBill)) {
                $nameBill = array_diff($nameBill, [$idCourse]); // remove the value from array
                $nameBill = array_values($nameBill); // re-index the array
                $bill->name_bill = json_encode($nameBill);
                if(empty($nameBill)) {
                    $bill->delete();
                } else {
                    $bill->tuitionFee -= $course->tuitionFee;
                    $bill->save();
                }
            }
        }
        
        // Xóa userId khỏi mảng students_list
        $studentsListCourse = array_diff($studentsListCourse, [$userId]);
        $studentsListThirdCourse = array_diff($studentsListThirdCourse, [$userId]);
            
        // Cập nhật lại students_list trong bảng Course và ThirdCourse
        if ($course) {
            $course->students_list = array_values($studentsListCourse);
            $course->save();
        }
        if ($thirdCourse) {
            $thirdCourse->students_list = array_values($studentsListThirdCourse);
            $thirdCourse->save();
        }
            
        return response()->json(['success' => 'Student removed from ' . $idCourse . ' successfully!'], 200);
            
    }

    public function showCalenderAdmin(): View
    {   
        return view('pages.ql_admin.schedule_admin');
    }
    
    public function getRegisteredCoursesAdmin()
    {
        $courses = Course::all();
        return $courses;
    }
    
}
