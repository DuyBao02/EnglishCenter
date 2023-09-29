<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('welcome_admin');
});

// Student's routes

Route::get('/dashboard-student', function () {
    return view('dashboard_student');
})->middleware(['auth', 'verified'])->name('dashboard-student');

Route::get('/exercise-student', function () {
    return view('pages.ql_student.exercise_student');
})->middleware(['auth', 'verified'])->name('exercise-student');

Route::get('/schedule-student', function () {
    return view('pages.ql_student.schedule_student');
})->middleware(['auth', 'verified'])->name('schedule-student');

Route::get('/register-course-student', function () {
    return view('pages.ql_student.register_course_student');
})->middleware(['auth', 'verified'])->name('register-course-student');

Route::get('/tuition-student', function () {
    return view('pages.ql_student.tuition_student');
})->middleware(['auth', 'verified'])->name('tuition-student');

// Teacher's routes

Route::get('/dashboard-teacher', function () {
    return view('dashboard_teacher');
})->middleware(['auth', 'verified'])->name('dashboard-teacher');

Route::get('/schedule-teacher', function () {
    return view('pages.ql_teacher.schedule_teacher');
})->middleware(['auth', 'verified'])->name('schedule-teacher');

Route::get('/student-list-teacher', function () {
    return view('pages.ql_teacher.student_list_teacher');
})->middleware(['auth', 'verified'])->name('student-list-teacher');

// Admin's routes

Route::get('/dashboard-admin', function () {
    return view('dashboard_admin');
})->middleware(['auth', 'verified'])->name('dashboard-admin');

Route::get('/course-admin', function () {
    return view('pages.ql_admin.course_admin');
})->middleware(['auth', 'verified'])->name('course-admin');

Route::get('/learning-need-admin', function () {
    return view('pages.ql_admin.learning_need_admin');
})->middleware(['auth', 'verified'])->name('learning-need-admin');

Route::get('/schedule-admin', function () {
    return view('pages.ql_admin.schedule_admin');
})->middleware(['auth', 'verified'])->name('schedule-admin');

Route::get('/homework-admin', function () {
    return view('pages.ql_admin.homework_admin');
})->middleware(['auth', 'verified'])->name('homework-admin');

Route::get('/teacher-list-admin', function () {
    return view('pages.ql_admin.teacher_list_admin');
})->middleware(['auth', 'verified'])->name('teacher-list-admin');

Route::get('/student-list-admin', function () {
    return view('pages.ql_admin.student_list_admin');
})->middleware(['auth', 'verified'])->name('student-list-admin');

//Profile's routes

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Verify email's route

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

require __DIR__.'/auth.php';