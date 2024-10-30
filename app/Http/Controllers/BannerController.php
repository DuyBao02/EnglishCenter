<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class BannerController extends Controller
{
    public function list(Request $request)
    {
        $search = $request['search'] ?? '';

        if ($search != ''){
            $banners =  Banner::where('title', 'LIKE', "%$search%")
                                ->sortable()->paginate(4);
        }
        else {
            $banners = Banner::sortable()->paginate(4);
        }

        return view('pages.ql_admin.banners', [
            'banners' => $banners,
            'search' => $search
        ]);
    }

    public function create(Request $request)
    {
        if (Banner::where('title', $request->title)->exists()) {
            return redirect()->back()->withInput($request->input())->with('error', 'Title already exists!');
        }

        $newName = null;

        if ($request->hasFile('picture')) {
            if (!$request->file('picture')->isValid()) {
                return redirect()->back()->withInput($request->input())->with('error', 'Invalid picture file!');
            }

            if ($request->file('picture')->getSize() > 5 * 1024 * 1024) {
                return redirect()->back()->withInput($request->input())->with('error', 'Picture file size must be less than 5MB!');
            }

            if (!in_array($request->file('picture')->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif', 'svg'])) {
                return redirect()->back()->withInput($request->input())->with('error', 'Invalid picture file type!');
            }

            $newName = 'Banner_' . $request->title . '.' . $request->file('picture')->getClientOriginalExtension();

            // Di chuyển và đổi tên file
            $request->file('picture')->move(public_path('images/banners'), $newName);
        }

        $request->validate([
            'title'  => ['required'],
        ]);

        $banner = Banner::create([
            'title' => $request->title,
            'user_id' => Auth::user()->id,
            'picture' => $newName,
        ]);

        // dd($banner);

        if(!$banner) {
            return redirect()->back()->with('error', 'Failed to create banner');
        }

        event(new Registered($banner));

        return redirect()->route('banners')->with('success', $banner->title . ' create successful!');
    }

    public function updateShowHide(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->showhide = $request->showhide == 1 ? 0 : 1; // Đảo ngược giá trị showhide
        $banner->save();

        return redirect()->back()->with('success', 'Banner updated successfully!');
    }

    public function delete($id)
    {
        $banner = Banner::where('id', $id)->first();
        if ($banner) {
            $banner->delete();

            unlink(public_path("images/banners/$banner->picture"));

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
