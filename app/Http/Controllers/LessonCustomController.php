<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Course;
use App\Models\Room;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class LessonCustomController extends Controller
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
        $lessons = Lesson::all();
        return view('pages.ql_admin.rl_custom', ['lessons' => $lessons]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_lesson'  => ['required'],
            'start_time' => ['required'],
            'end_time' => ['required'],
        ]);
    
        $existingLesson = Lesson::where('id_lesson', $request->id_lesson)->first();
    
        if ($existingLesson) {
            session()->flash('error', 'The Lesson already exists.');
            return redirect()->back();
        }
    
        if ($request->start_time >= $request->end_time) {
            session()->flash('error', 'Start time must be less than end time.');
            return redirect()->back();
        }
    
        $lesson = Lesson::create([
            'id_lesson'  => $request->id_lesson,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);
    
        event(new Registered($lesson));
    
        session()->flash('success', 'New Lesson created successful!');
    
        $lessons = Lesson::all();
        return redirect()->route('rl-custom-admin');
    }

    public function getLessonsForCourseCreation()
    {
        $lessons = Lesson::all();
        $rooms = Room::all();
        return view('pages.ql_admin.create_course', ['rooms' => $rooms, 'lessons' => $lessons]);
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
    public function edit($id)
    {
        $lesson = Lesson::find($id);
        return view('pages.ql_admin.lesson_edit', compact('lesson'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $lesson = Lesson::find($id);
        $lesson->update($request->all());
        return redirect()->route('rl-custom-admin')->with('success', 'Lesson update successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lesson = Lesson::where('id_lesson', $id)->first();
        if ($lesson) {
            $lesson->delete();
            session()->flash('success', 'Lesson deleted successfully!');
        } else {
            session()->flash('error', 'Lesson not found!');
        }
        return redirect()->route('rl-custom-admin');
    }
    
}
