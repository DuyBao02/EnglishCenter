<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view for regular users.
     */
    public function createUser(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request for regular users.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeUser(Request $request): RedirectResponse
    {

        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()->withInput($request->input())->with('error', 'Email already exists!');
        }

        if (strlen($request->password) < 8) {
            return redirect()->back()->withInput($request->input())->with('error', 'The password must be at least 8 characters!');
        }

        if ($request->password != $request->password_confirmation) {
            return redirect()->back()->withInput($request->input())->with('error', 'Confirmation passwords are not the same!');
        }

        if ($request->role == 'Teacher' && ($request->experience < 1 || $request->experience > 50)) {
            return redirect()->back()->withInput($request->input())->with('error', 'Experience must be between 1 and 50!');
        }

        if ($request->role == 'Teacher' && empty($request->level)) {
            return redirect()->back()->withInput($request->input())->with('error', 'Level is required for Teacher!');
        }

        // Lấy tên file gốc và tạo tên mới cho file
        $newName = 'avatar_default.png';

        if ($request->hasFile('avatar')) {
            if (!$request->file('avatar')->isValid()) {
                return redirect()->back()->withInput($request->input())->with('error', 'Invalid avatar file!');
            }

            if ($request->file('avatar')->getSize() > 4096 * 1024) {
                return redirect()->back()->withInput($request->input())->with('error', 'Avatar file size must be less than 4MB!');
            }

            if (!in_array($request->file('avatar')->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif', 'svg'])) {
                return redirect()->back()->withInput($request->input())->with('error', 'Invalid avatar file type!');
            }

            $newName = $request->name . '_' . explode('@', $request->email)[0] . '.' . $request->file('avatar')->getClientOriginalExtension();

            // Di chuyển và đổi tên file
            $request->file('avatar')->move(public_path('images/avatars'), $newName);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'gender' => ['required'],
            'birthday' => ['required'],
            'address' => ['required'],
            'phone' => ['required'],
            'role' => ['required'],
            'avatar' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:4096'],
            'experience' => ['nullable', 'integer', 'min:1', 'max:50'],
            'level' => ['nullable', 'string'],
        ]);

        // $validator = Validator::make($request->all(), [
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        //     'gender' => ['required'],
        //     'birthday' => ['required'],
        //     'address' => ['required'],
        //     'phone' => ['required'],
        //     'role' => ['required'],
        //     'avatar' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:4096'],
        //     'experience' => ['nullable', 'integer', 'min:1', 'max:50'],
        //     'level' => ['nullable', 'string'],
        // ]);

        // if ($validator->fails()) {
        //     // In ra thông báo lỗi để kiểm tra
        //     dd($validator->errors()->all());
        //     // Hoặc bạn có thể chuyển hướng trở lại với thông báo lỗi
        //     return redirect()->back()->withErrors($validator)->withInput($request->input());
        // }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'address' => $request->address,
            'phone' => $request->phone,
            'role' => $request->role,
            'avatar' => $newName,
            'experience' => $request->role == 'Teacher' ? $request->experience : null,
            'level' => $request->role == 'Teacher' ? $request->level : null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($user->role == 'Student') {

            return redirect(RouteServiceProvider::HOME_s);

        } elseif ($user->role == 'Teacher') {

            return redirect(RouteServiceProvider::HOME_t);

        } else {

            return redirect()->back()->with('error', 'Error create user!');
        }
    }


    /**
     * Display the registration view for admin users.
     */
    public function createAdmin(): View
    {
        return view('auth.register_admin');
    }

    /**
     * Handle an incoming registration request for admin users.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeAdmin(Request $request): RedirectResponse
    {

        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()->withInput($request->input())->with('error', 'Email already exists!');
        }

        if ($request->email != $request->password_confirmation) {
            return redirect()->back()->withInput($request->input())->with('error', 'Confirmation passwords are not the same!');
        }

        // Lấy tên file gốc và tạo tên mới cho file
        $newName = 'avatar_default.png';

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

            $newName = $request->name . '_' . explode('@', $request->email)[0] . '.' . $request->file('avatar')->getClientOriginalExtension();

            // Di chuyển và đổi tên file
            $request->file('avatar')->move(public_path('images/avatars'), $newName);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'gender' => ['required'],
            'birthday' => ['required'],
            'address' => ['required'],
            'phone' => ['required', 'max:10'],
            'avatar' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'address' => $request->address,
            'phone' => $request->phone,
            'role' => 'Admin',
            'avatar' => $newName,
            'experience' => null,
            'level' => null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME_a);
    }
}
