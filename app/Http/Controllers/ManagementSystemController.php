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

        if (Auth::check() == null) {
            return redirect()->route('welcome')->with('error', 'Please log in before entering the system!');
        }

        if (Auth::user()->role == "Student") {
            return redirect(RouteServiceProvider::HOME_s);
        }
        
        elseif (Auth::user()->role == "Teacher") {
            return redirect(RouteServiceProvider::HOME_t);
        }

        elseif (Auth::user()->role == "Admin") {
            return redirect(RouteServiceProvider::HOME_t);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
