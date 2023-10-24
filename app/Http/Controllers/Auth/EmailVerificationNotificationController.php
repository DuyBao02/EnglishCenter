<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail() && $request->user()->role == "Student") {
            return redirect()->intended(RouteServiceProvider::HOME_s);
        }

        if ($request->user()->hasVerifiedEmail() && $request->user()->role == "Teacher") {
            return redirect()->intended(RouteServiceProvider::HOME_t);
        }

        if ($request->user()->hasVerifiedEmail() && $request->user()->role == "Admin") {
            return redirect()->intended(RouteServiceProvider::HOME_a);
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');

    }
}
