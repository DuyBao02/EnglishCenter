<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
use Carbon\Carbon;

class LessonCustomController extends Controller
{
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
            session()->flash('error', 'The ' . $request->id_lesson . ' lesson already exists!');
            return redirect()->back()->withInput($request->input());
        }

        $conflictingLesson = Lesson::where('end_time', '>', $request->start_time)->first();;

        if ($conflictingLesson) {
            session()->flash('error', 'The start time must be greater than the end time in ' . $conflictingLesson->id_lesson . '!');
            return redirect()->back()->withInput($request->input());
        }

        $lesson = Lesson::create([
            'id_lesson'  => $request->id_lesson,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        event(new Registered($lesson));

        session()->flash('success', 'The ' . $lesson->id_lesson . ' lesson created successful!');

        $lessons = Lesson::all();
        return redirect()->route('rl-custom-admin')->withInput($request->input());
    }


    public function getLessonsForCourseCreation()
    {
        $lessons = Lesson::all();
        $rooms = Room::all();
        return view('pages.ql_admin.create_course', ['rooms' => $rooms, 'lessons' => $lessons]);
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
        $request->validate([
            'start_time' => ['required'],
            'end_time' => ['required'],
        ]);

        $conflictingLesson = Lesson::where('end_time', '>', $request->start_time)->first();;

        if ($conflictingLesson) {
            session()->flash('error', 'The start time must be greater than the end time in ' . $conflictingLesson->id_lesson . '!');
            return redirect()->back();
        }

        $lesson = Lesson::find($id);
        $lesson->update($request->all());
        return redirect()->route('rl-custom-admin')->with('success', 'The ' . $lesson->id_lesson . ' lesson update successful!');
    }

    public function destroy($id)
    {
        $lesson = Lesson::where('id_lesson', $id)->first();
        if ($lesson) {
            $courses = Course::all();
            foreach ($courses as $course) {
                if (in_array($lesson->id_lesson, $course->lessons)) {
                    return response()->json(['success' => false, 'message' => 'Cannot delete lesson as it exists in ' . $course->id_course]);
                }
            }
            $lesson->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
