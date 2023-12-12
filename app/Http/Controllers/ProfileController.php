<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

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

            $avatarName = now()->format('Ymd_His') . '_' . explode('@', $user->email)[0] . '.' . $request->file('avatar')->getClientOriginalExtension();

            $request->file('avatar')->move(public_path('images/avatars'), $avatarName);
            $user->avatar = $avatarName;
        }

        else if ($request->defaultAvatar == '1') {
            // Nếu avatar là avatar mặc định
            $user->avatar = 'avatar_default.png';
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    /**
     * Delete the account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        // Lấy đường dẫn đến ảnh đại diện
        $avatarPath = public_path('images/avatars/' . $user->avatar);

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Kiểm tra xem tệp ảnh đại diện có tồn tại không và sau đó xóa nó
        if (file_exists($avatarPath)) {
            unlink($avatarPath);
        }

        return Redirect::to('/');
    }
}
