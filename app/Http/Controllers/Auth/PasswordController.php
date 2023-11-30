<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class PasswordController extends Controller
{
    /**
     * Update the password.
     */
    public function update(Request $request): RedirectResponse
    {
        // dd($request->all());
        //Xu ly password
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->back()->with('error', 'Password is incorrect!');
        }

        if (strlen($request->password) < 8) {
            return redirect()->back()->with('error', 'The password must be at least 8 characters!');
        }

        if ($request->password != $request->password_confirmation) {
            return redirect()->back()->with('error', 'Confirmation passwords are not the same!');
        }

        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // return back()->with('status', 'password-updated');
        return back()->with('success', 'Password has been updated!');

    }
}
