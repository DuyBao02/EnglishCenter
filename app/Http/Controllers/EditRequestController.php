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
        // Validate và lấy dữ liệu như phương thức sendRequestToAdmin
        $request->validate([
            'name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);
    
        // Lấy user hiện tại
        $user = auth()->user();
    
        // Lấy dữ liệu cũ và mới để so sánh
        $data = [
            'old' => [
                'name' => $user->name,
                'birthday' => $user->birthday,
                'address' => $user->address,
                'phone' => $user->phone,
            ],
            'new' => $request->only(['name', 'birthday', 'address', 'phone']),
        ];

        // Kiểm tra xem dữ liệu đã được chỉnh sửa hay chưa
        if ($user->name == $data['new']['name'] && $user->birthday == $data['new']['birthday'] && $user->address == $data['new']['address'] && $user->phone == $data['new']['phone']) {
            return redirect()->back()->with('error', 'No changes were made!');
        }

        // Tạo một instance mới của Secondedit và lưu dữ liệu
        $secondEdit = new Secondedit;
        $secondEdit->user_id = $user->id;
        $secondEdit->data = json_encode($data);
        $secondEdit->daytime = Carbon::now();
        $secondEdit->status = 'pending'; // Khởi tạo trạng thái
        $secondEdit->save();
    
        return redirect()->back()->with('success', 'Success! Please wait for Admin to agree');
    }
    
    public function showRequestToAdmin()
    {   
        $secondEdits = Secondedit::all();
    
        foreach ($secondEdits as $secondEdit) {
            // Tạo một instance mới của Edit và lưu dữ liệu từ second edit
            $edit = new Edit;
            $edit->user_id = $secondEdit->user_id;
            $edit->data = $secondEdit->data;
            $edit->daytime = $secondEdit->daytime;
            $edit->status = $secondEdit->status;
            $edit->save();
            $secondEdit->delete();
        }
        // Lấy tất cả các edit requests
        $allEdits = Edit::with('user')->get();
    
        // Nếu số lượng edit requests lớn hơn 10
        if ($allEdits->count() > 10) {
            // Xóa các edit requests cũ nhất cho đến khi chỉ còn lại 10
            $allEdits->sortBy('created_at')->take($allEdits->count() - 10)->each(function ($edit) {
                $edit->delete();
            });
        }

        // Lấy lại danh sách edit requests sau khi đã xóa
        $edit_show = Edit::with('user')->get()->map(function ($edit) {
            $data = json_decode($edit->data, true);
            if (isset($data['old']) && isset($data['new'])) {
                $edit->changes = array_diff_assoc($data['new'], $data['old']);
            } else {
                $edit->changes = [];
            }
            return $edit;
        });
       
        return view('pages.ql_admin.receive_edit_request', compact('edit_show'));
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
        $user->save();

        // Cập nhật trạng thái của edit request thành 'accepted'
        $edit->status = 'accepted';
        $edit->save();

        return redirect()->route('profile.edit')->with('success', 'User information has been updated successfully!');
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

        return redirect()->back()->with('success', 'Edit request has been refused successfully!');
    }

}
