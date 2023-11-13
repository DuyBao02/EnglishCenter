<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Room;
use App\Models\Lesson;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RoomCustomController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_room'  => ['required'],
            'name_room' => ['required'],
        ]);

        $existingLesson = Room::where('id_room', $request->id_room)->first();
        $exitsingName_room = Room::where('name_room', $request->name_room)->first();

        if ($existingLesson) {
            session()->flash('error', 'Room ' . $request->id_room . ' already exists!');
            return redirect()->back()->withInput($request->input());
        }elseif ($exitsingName_room) {
            session()->flash('error', $request->id_room . ' already exists!');
            return redirect()->back()->withInput($request->input());
        }

        $room = Room::create([
            'id_room'  => $request->id_room,
            'name_room' => $request->name_room,
        ]);

        event(new Registered($room));

        session()->flash('success', 'Room ' . $room->id_room . ' created successful!');

        $rooms = Room::all();
        return redirect()->route('rl-custom-admin')->withInput($request->input());
    }

    public function createBoth()
    {
        $rooms = Room::all();
        $lessons = Lesson::all();
        return view('pages.ql_admin.rl_custom', ['rooms' => $rooms, 'lessons' => $lessons]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room = Room::find($id);
        return view('pages.ql_admin.room_edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name_room' => ['required'],
        ]);

        $existingNameRoom = Room::where('name_room', $request->name_room)->where('id_room', '!=', $id)->first();

        if ($existingNameRoom) {

            session()->flash('error', 'Room name ' . $request->name_room . ' already exists!');
            return redirect()->back();
        }

        $room = Room::find($id);
        $room->update($request->all());
        return redirect()->route('rl-custom-admin')->with('success', 'Room ' . $room->id_room . ' update successful!');
    }

    public function destroy($id)
    {
        $room = Room::where('id_room', $id)->first();
        if ($room) {
            $courses = Course::all();
            foreach ($courses as $course) {
                if (in_array($room->id_room, $course->rooms)) {
                    return response()->json(['success' => false, 'message' => 'Cannot delete room as it exists in ' . $course->id_course]);
                }
            }
            $room->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
