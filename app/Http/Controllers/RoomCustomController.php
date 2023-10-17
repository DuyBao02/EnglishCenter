<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::all();
        return view('pages.ql_admin.rl_custom', ['rooms' => $rooms]);
    }

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
            session()->flash('error', 'The Room already exists.');
            return redirect()->back();
        }elseif ($exitsingName_room) {
            session()->flash('error', 'Name Room already exists.');
            return redirect()->back();
        }
    
        $room = Room::create([
            'id_room'  => $request->id_room,
            'name_room' => $request->name_room,
        ]);

        event(new Registered($room));
    
        session()->flash('success', 'New Room created successful!');
    
        $rooms = Room::all();
        return redirect()->route('rl-custom-admin');
    }

    public function createBoth()
    {
        $rooms = Room::all();
        $lessons = Lesson::all();
        return view('pages.ql_admin.rl_custom', ['rooms' => $rooms, 'lessons' => $lessons]);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $room = Room::find($id);
        $room->update($request->all());
        return redirect()->route('rl-custom-admin')->with('success', 'Room update successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::where('id_room', $id)->first();
        if ($room) {
            $room->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
