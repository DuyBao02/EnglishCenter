<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class AuthenticateAdminController extends Controller
{
    public function showRegisterAdmin(): View
    {
        return view('welcome_admin');
    }

    public function showformAdmin(): View
    {
        return view('AuthenticateAdmin');
    }

    public function AuthenticateAdmin(Request $request): RedirectResponse
    {
        // dd($request->all());

        // $validator = Validator::make($request->all(), [
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // ]);

        // if ($validator->fails()) {
        //     // In ra thông báo lỗi để kiểm tra
        //     dd($validator->errors()->all());
        //     // Hoặc bạn có thể chuyển hướng trở lại với thông báo lỗi
        //     return redirect()->back()->withErrors($validator)->withInput($request->input());
        // }

        $result = False;
        if ($request->password !== 'DBECaaabbb') {
            return redirect()->back()->with('error', 'Invalid password!');
        }

        if ($request->password != $request->password_confirmation) {
            return redirect()->back()->with('error', 'Confirmation passwords are not the same!');
        }

        $result = True;
        if($result)
            return redirect()->route('showRegisterAdmin')->with('success', 'Admin authentication successful');

        return redirect()->back()->with('error', 'Error Authentication!');

    }
}
