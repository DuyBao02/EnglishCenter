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
use App\Models\Edit;
use App\Models\Secondedit;
use Carbon\Carbon;

class EditRequestController extends Controller
{

    public function sendRequestToSecondEdit(Request $request)
    {
        // Lấy user hiện tại
        $user = auth()->user();

        // Validate và lấy dữ liệu
        $rules = [
            'name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($user->role == 'Teacher') {
            $rules['experience'] = 'required|integer';
            $rules['level'] = 'required|string|max:255';
        }

        $request->validate($rules);

        if ($request->role == 'Teacher' && ($request->experience < 1 || $request->experience > 50)) {
            return redirect()->back()->with('error', 'Experience must be between 1 and 50!'); 
        }
    
        // Lấy user hiện tại
        $user = auth()->user();

        // Lấy dữ liệu cũ và mới để so sánh
        $data = [
            'old' => [
                'name' => $user->name,
                'birthday' => $user->birthday,
                'address' => $user->address,
                'phone' => $user->phone,
                'experience' => $user->experience,
                'level' => $user->level,
                'avatar' => $user->avatar, 
            ],
            'new' => $request->only(['name', 'birthday', 'address', 'phone', 'experience', 'level']),
        ];

        // Kiểm tra xem có file avatar được tải lên hay không
        if ($request->hasFile('avatar')) {

            if (!$request->file('avatar')->isValid()) {
                return redirect()->back()->withInput($request->input())->with('error', 'Invalid avatar file!'); 
            }
                
            if ($request->file('avatar')->getSize() > 2048 * 1024) {
                return redirect()->back()->withInput($request->input())->with('error', 'Avatar file size must be less than 2MB!'); 
            }
    
            if (!in_array($request->file('avatar')->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif', 'svg'])) {
                return redirect()->back()->withInput($request->input())->with('error', 'Invalid avatar file type!'); 
            }

            $avatarName = $user->name . '_' . explode('@', $user->email)[0] . '.' . $request->file('avatar')->getClientOriginalExtension();
            
            $oldAvatarPath = public_path('images/avatars/' . $user->avatar);
                
            if ($user->avatar != 'avatar_default.png' && file_exists($oldAvatarPath)) {
                // Xóa file avatar cũ
                unlink($oldAvatarPath);
            } 
            
            $request->file('avatar')->move(public_path('images/avatars'), $avatarName);

            // Lưu tên file vào $data['new']['avatar']
            $data['new']['avatar'] = $avatarName;
        } 

        else if ($request->defaultAvatar == '1') {
            // Nếu avatar là avatar mặc định
            $data['new']['avatar'] = 'avatar_default.png';
        }

        else {
            $data['new']['avatar'] = null;
        }

        // Kiểm tra xem dữ liệu đã được chỉnh sửa hay chưa
        if ($user->name == $data['new']['name'] && $user->birthday == $data['new']['birthday'] && $user->address == $data['new']['address'] 
            && $user->phone == $data['new']['phone'] && $user->avatar == $data['new']['avatar'] 
            && ($user->role != 'Teacher' || ($user->experience == $data['new']['experience'] && $user->level == $data['new']['level']))) {
            return redirect()->back()->withInput($request->input())->with('error', 'No changes were made!');
        }

        // Tạo một instance mới của Secondedit và lưu dữ liệu
        $secondEdit = new Secondedit;
        $secondEdit->user_id = $user->id;
        $secondEdit->data = json_encode($data);
        $secondEdit->status = 'pending'; // Khởi tạo trạng thái
        $secondEdit->save();
    
        return redirect()->back()->withInput($request->input())->with('success', 'Success! Please wait for Admin to agree');
    }
    
    public function showRequestToAdmin()
    {   
        $secondEdits = Secondedit::all();
    
        foreach ($secondEdits as $secondEdit) {
            // Tạo một instance mới của Edit và lưu dữ liệu từ second edit
            $edit = new Edit;
            $edit->user_id = $secondEdit->user_id;
            $edit->data = $secondEdit->data;
            $edit->status = $secondEdit->status;
            $edit->save();
            $secondEdit->delete();
        }

        // Lấy tất cả các edit requests
        $allEdits = Edit::with('user')->orderBy('created_at', 'desc')->get();

        // Chia danh sách edits thành hai dựa trên cột role
        [$editsStudent, $editsTeacher] = $allEdits->partition(function ($edit) {
            return $edit->user->role == "Student"; // Thay đổi điều kiện này theo yêu cầu của bạn
        });

        // Nếu số lượng edit requests của Student lớn hơn 10
        if ($editsStudent->count() > 10) {
            // Xóa các edit requests cũ nhất của Student cho đến khi chỉ còn lại 10
            $editsStudent->sortBy('created_at')->take($editsStudent->count() - 10)->each(function ($edit) {
                $edit->delete();
            });
            // Lấy lại danh sách edit requests sau khi đã xóa
            $editsStudent = $editsStudent->diff($editsStudent->sortBy('created_at')->take($editsStudent->count() - 10));
        }

        // Nếu số lượng edit requests của Teacher lớn hơn 10
        if ($editsTeacher->count() > 10) {
            // Xóa các edit requests cũ nhất của Teacher cho đến khi chỉ còn lại 10
            $editsTeacher->sortBy('created_at')->take($editsTeacher->count() - 10)->each(function ($edit) {
                $edit->delete();
            });
            // Lấy lại danh sách edit requests sau khi đã xóa
            $editsTeacher = $editsTeacher->diff($editsTeacher->sortBy('created_at')->take($editsTeacher->count() - 10));
        }

        return view('pages.ql_admin.receive_edit_request', compact('editsStudent', 'editsTeacher'));
    }
    
    
    public function editAcceptFromAdmin($id_user, $id_edit)
    {

        // Tìm edit request bằng id
        $edit = Edit::find($id_edit);

        // Kiểm tra xem edit request có tồn tại hay không
        if (!$edit) {
            return redirect()->back()->with('error', 'Edit request not found!');
        }

        // Giải mã dữ liệu từ JSON trở lại thành mảng
        $data = json_decode($edit->data, true);

        // Tìm user bằng user_id trong edit request
        $user = User::find($id_user);
        
        // Cập nhật thông tin user với dữ liệu mới
        $user->name = $data['new']['name'];
        $user->birthday = $data['new']['birthday'];
        $user->address = $data['new']['address'];
        $user->phone = $data['new']['phone'];
        if ($user->role == 'Teacher') {
             $user->experience = $data['new']['experience'];
            $user->level = $data['new']['level'];
        }
        if (isset($data['new']['avatar'])) {
            $user->avatar = $data['new']['avatar'];
        }
        
        $user->save();

        // Cập nhật trạng thái của edit request thành 'accepted'
        $edit->status = 'accepted';
        $edit->save();

        return redirect()->route('edit-request');
    }

    public function editRefuseFromAdmin($id_edit)
    {
        // Tìm edit request bằng id
        $edit = Edit::find($id_edit);

        // Kiểm tra xem edit request có tồn tại hay không
        if (!$edit) {
            return redirect()->back()->with('error', 'Edit request not found!');
        }

        // Cập nhật trạng thái của edit request thành 'refused'
        $edit->status = 'refused';
        $edit->save();

        return redirect()->route('edit-request');
    }

}
