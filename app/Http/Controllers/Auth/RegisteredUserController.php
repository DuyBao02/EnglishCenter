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



class RegisteredUserController extends Controller
{
    /**
     * Display the registration view for regular users.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request for regular users.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        if (User::where('name', $request->name)->exists()) {
            return redirect()->back()->with('error', 'Name already exists!'); 
        }
        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()->with('error', 'Email already exists!'); 
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
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'address' => $request->address,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);
        
        event(new Registered($user));

        Auth::login($user);
        
        if ($user->role == 'Student') {

            return redirect(RouteServiceProvider::HOME_s);

        } else{

            return redirect(RouteServiceProvider::HOME_t);
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
        
        if (User::where('name', $request->name)->exists()) {
            return redirect()->back()->with('error', 'Name already exists!'); 
        }
        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()->with('error', 'Email already exists!'); 
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
        ]);
        
        event(new Registered($user));

        Auth::login($user);
        
        return redirect(RouteServiceProvider::HOME_a);
    }
}
