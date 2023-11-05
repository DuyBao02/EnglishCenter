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
            $avatarName = $user->name . '_' . explode('@', $user->email)[0] . '.' . $request->file('avatar')->getClientOriginalExtension();
            $oldAvatarPath = public_path('images/avatars/' . $user->avatar);
                
            // Kiểm tra xem file avatar cũ có tồn tại không
            if ($user->avatar != 'avatar_default.png' && file_exists($oldAvatarPath)) {
                // Xóa file avatar cũ
                unlink($oldAvatarPath);
            }

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
