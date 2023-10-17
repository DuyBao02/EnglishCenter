<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Admin;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        return $request->user()->hasVerifiedEmail()
                ? redirect()->intended(RouteServiceProvider::HOME)
                : view('auth.verify-email');

        if ($request->user()->role == "Student") {

            return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(RouteServiceProvider::HOME_s)
            : view('auth.verify-email');
        
        } elseif ($request->user()->role == "Teacher") {
        
            return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(RouteServiceProvider::HOME_t)
            : view('auth.verify-email');
        
        }else {
        
            return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(RouteServiceProvider::HOME_a)
            : view('auth.verify-email');
        
        };       
        
    }
}
