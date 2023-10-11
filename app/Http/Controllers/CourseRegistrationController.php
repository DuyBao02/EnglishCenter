<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;

class CourseRegistrationController extends Controller
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
        return view('course-registration');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate form data
        $course = $request->validate([
            'id_course'  => 'required',
            'name_course' => 'required',
            'weeks' => 'required',
            'days' => 'required',
            'rooms' => 'required',
            'shifts' => 'required',
            'maxStudents' => 'required',
            'tuitionFee' => 'required',
            'teacher' => 'nullable',
            'students_list' => 'nullable',
        ]);

        // $courseRegistration = Course::create($course);
        event(new Registered($course));

        return redirect()->back()->with('success', 'Course registration successful.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
