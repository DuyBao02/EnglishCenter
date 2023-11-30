<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Secondcourse;
use App\Models\Post;
use App\Models\Thirdcourse;
use App\Models\Room;
use App\Models\Bill;
use App\Models\Lesson;
use App\Models\Banner;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Auth\Events\Registered;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function showRLDashBoard()
    {
        $totalcourses = Course::get()->count();
        $totalposts = Post::get()->count();
        $totallessons = Lesson::get()->count();
        $totalrooms = Room::get()->count();
        $totalfeedbacks = Feedback::get()->count();
        $totalbanners = Banner::get()->count();
        $totalbills = Bill::where('is_paid', 1)->get()->count();
        $totaladmins = User::where('role', 'Admin')->get()->count();
        $totalteachers = User::where('role', 'Teacher')->get()->count();
        $totalstudents = User::where('role', 'Student')->get()->count();
        return view('dashboard_admin', compact([
            'totalposts', 'totalcourses',
            'totaladmins','totalteachers',
            'totalstudents','totallessons',
            'totalrooms', 'totalfeedbacks',
            'totalbanners', 'totalbills'
        ]));
    }

    public function usersManagement(Request $request)
    {
        $admins = User::where('role', 'Admin')->get();

        //Chia teacher co khoa hoc va chua co khoa hoc
        $teachers = User::where('role', 'Teacher')->get();
        $registeredTeachers = $teachers->filter(function ($teacher) {
            return $teacher->registeredCourse != null;
        });
        $notRegisteredTeachers = $teachers->diff($registeredTeachers);

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

        $search = $request['search'] ?? '';
        if ($search != ''){
            $search_user = User::where('name', 'LIKE', "%$search%")
                            ->orWhere('role', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%")
                            ->orWhere('birthday', 'LIKE', "%$search%")
                            ->orWhere('address', 'LIKE', "%$search%")
                            ->orWhere('phone', 'LIKE', "%$search%")
                            ->sortable()->paginate(4);
        }
        else {
            $search_user = User::sortable()->paginate(4);
        }

        return view('pages.ql_admin.users_management', [
            'totalAdmins' => $admins->count(),
            'admins' => $admins,

            'totalStudents' => $students->count(),
            'registeredStudents' => $registeredStudents,
            'notRegisteredStudents' => $notRegisteredStudents,

            'totalTeachers' => $teachers->count(),
            'registeredTeachers' => $registeredTeachers,
            'notRegisteredTeachers' => $notRegisteredTeachers,

            'search' => $search,
            'search_user' => $search_user
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

        // Lấy đường dẫn đến ảnh đại diện
        $avatarPath = public_path('images/avatars/' . $currentUser->avatar);

        // Kiểm tra xem tệp ảnh đại diện có tồn tại không và sau đó xóa nó
        if (file_exists($avatarPath)) {
            unlink($avatarPath);
        }

        return redirect()->back()->with('success', 'User removed successfully!');
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
        $bills = Bill::where('user_id', $userId)->get();
        foreach ($bills as $bill) {
            if ($bill->is_paid){
                $nameBill = json_decode($bill->name_bill, true);
                if (in_array($idCourse, $nameBill)) {
                    return response()->json(['error' => 'You cannot remove because they have already paid their tuition!'], 409);
                }
            }
            elseif (!$bill->is_paid) {
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
        }

        // User thanh toán tiền rôì vẫn xóa khỏi Course được và xóa luôn bill đã thanh toán
        // $bill = Bill::where('user_id', $userId)->first();
        // if($bill){
        //     $nameBill = json_decode($bill->name_bill, true);
        //     if (in_array($idCourse, $nameBill)) {
        //         $nameBill = array_diff($nameBill, [$idCourse]); // remove the value from array
        //         $nameBill = array_values($nameBill); // re-index the array
        //         $bill->name_bill = json_encode($nameBill);
        //         if(empty($nameBill)) {
        //             $bill->delete();
        //         } else {
        //             $bill->tuitionFee -= $course->tuitionFee;
        //             $bill->save();
        //         }
        //     }
        // }

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

    public function getRegisteredCoursesAdmin()
    {
        $courses = Course::all();
        return $courses;
    }

    public function createPost(Request $request)
    {
        if (Post::where('title', $request->title)->exists()) {
            return redirect()->back()->withInput($request->input())->with('error', 'Title already exists!');
        }

        $newName = null;

        if ($request->hasFile('picture')) {
            if (!$request->file('picture')->isValid()) {
                return redirect()->back()->withInput($request->input())->with('error', 'Invalid picture file!');
            }

            if ($request->file('picture')->getSize() > 5 * 1024 * 1024) {
                return redirect()->back()->withInput($request->input())->with('error', 'Picture file size must be less than 5MB!');
            }

            if (!in_array($request->file('picture')->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif', 'svg'])) {
                return redirect()->back()->withInput($request->input())->with('error', 'Invalid picture file type!');
            }

            $newName = $request->title . '.' . $request->file('picture')->getClientOriginalExtension();

            // Di chuyển và đổi tên file
            $request->file('picture')->move(public_path('images/posts'), $newName);
        }

        // dd($request->title,$request->content, $newName );

        $request->validate([
            'title'  => ['required'],
            'content' => ['required'],
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::user()->id,
            'picture' => $newName,
        ]);

        if(!$post) {
            return redirect()->back()->with('error', 'Failed to create post');
        }

        event(new Registered($post));

        return redirect()->route('posts-admin')->with('success', $post->title . ' create successful!');
    }

    public function showPostTeacherWelcome()
    {
        // Lấy danh sách giáo viên, phân trang và mỗi trang chứa 4 giáo viên
        $teachers = User::where('role', 'Teacher')->paginate(4);

        // Lấy bài viết có id 11 và 12
        $post11 = Post::find(11);
        $post12 = Post::find(12);

        // Lấy danh sách bài viết, phân trang và mỗi trang chứa 3 bài viết
        $posts = Post::all();
        $banners = Banner::all();

        return view('welcome', [
            'banners' => $banners,
            'posts' => $posts,
            'post11' => $post11,
            'post12' => $post12,
            'teachers' => $teachers
        ]);
    }

    public function showPosts(): View
    {
        return view('showposts', ['posts' => Post::all()]);
    }

    public function showBills(Request $request)
    {
        // $search = $request['search'] ?? '';

        // if ($search != ''){
        //     $bills = Bill::where('is_paid', 1)
        //                     ->orWhere('name_bill', 'LIKE', "%$search%")
        //                     ->sortable()->paginate(4);
        // }
        // else {
        //     $bills = Bill::where('is_paid', 1)->sortable()->paginate(4);
        // }

        $bills = Bill::where('is_paid', 1)->sortable()->paginate(4);

        return view('pages.ql_admin.bills', [
            'bills' => $bills,
            // 'search' => $search
        ]);
    }

    public function showPostsManagement(Request $request)
    {
        $search = $request['search'] ?? '';

        if ($search != ''){
            $posts =  Post::where('title', 'LIKE', "%$search%")->sortable()->paginate(4);
        }
        else {
            $posts = Post::sortable()->paginate(4);
        }

        return view('pages.ql_admin.posts', [
            'posts' => $posts,
            'search' => $search
        ]);
    }

    public function showPostsdetails($id)
    {
        $postDetails = Post::find($id);

        if (!$postDetails) {
            return redirect()->back()->with('error', 'Post not found!');
        }

        if ($postDetails)
            return view('posts_details', compact('postDetails'));
        else
            return redirect()->back()->with('error', 'Posts not found!');
    }

    public function showTeachersdetails($id)
    {
        $teacherDetails = User::where('role', 'Teacher')->find($id);
        if (!$teacherDetails) {
            return redirect()->back()->with('error', 'Teacher not found!');
        }

        if ($teacherDetails)
            return view('teachers_details', compact('teacherDetails'));
        else
            return redirect()->back()->with('error', 'Teacher not found!');
    }

    public function editPost($id)
    {
        $post = Post::find($id);
        return view('pages.ql_admin.post_edit', compact('post'));
    }

    public function updatePost(Request $request, $id)
    {
        // dd($request->title, $request->picture, $request->content, $request->user_id);
        $request->validate([
            'title' => ['required'],
        ]);

        $post = Post::find($id);

        $existingNamePost = Post::where('title', $request->title)->where('title', '!=', $id)->first();

        if ($existingNamePost) {
            session()->flash('error', 'Post name ' . $request->title . ' already exists!');
            return redirect()->back();
        }
        // dd($post->picture);
        if ($request->hasFile('picture')) {
            if (!$request->file('picture')->isValid()) {
                return redirect()->back()->withInput($request->input())->with('error', 'Invalid picture file!');
            }

            if ($request->file('picture')->getSize() > 5 * 1024 * 1024) {
                return redirect()->back()->withInput($request->input())->with('error', 'Picture file size must be less than 5MB!');
            }

            if (!in_array($request->file('picture')->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif', 'svg'])) {
                return redirect()->back()->withInput($request->input())->with('error', 'Invalid picture file type!');
            }

            $pictureName = $request->title . '.' . $request->file('picture')->getClientOriginalExtension();

            $oldPicturePath = public_path('images/posts/' . $post->picture);
            // dd($oldPicturePath);
            if (file_exists($oldPicturePath)) {
                // Xóa file avatar cũ
                unlink($oldPicturePath);
            }
            $request->file('picture')->move(public_path('images/posts'), $pictureName);
            $post->picture = $pictureName;
        }

        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id =  Auth::user()->id;
        $post->save();

        // dd($post);

        return redirect()->route('posts-admin')->with('success', $post->title . ' update successful!');
    }

    public function deletePost($id)
    {
        $post = Post::where('id', $id)->first();
        if ($post) {
            $post->delete();

            unlink(public_path("images/posts/$post->picture"));

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }


}
