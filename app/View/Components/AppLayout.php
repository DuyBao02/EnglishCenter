<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AppLayout extends Component
{   
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $request = Auth::user()->role;

        if ($request == "Student") {

            return view('layouts_student.app_student');

        } elseif ($request == "Teacher") {

            return view('layouts_teacher.app_teacher');

        }else {

            return view('layouts_admin.app_admin');

        }
    }
}
