<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ManagementSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {

        if (Auth::user()->role == "Student") {
            return redirect(RouteServiceProvider::HOME_s);
        }
        
        elseif (Auth::user()->role == "Teacher") {
            return redirect(RouteServiceProvider::HOME_t);
        }

        elseif (Auth::user()->role == "Admin") {
            return redirect(RouteServiceProvider::HOME_a);
        }
    }

}
