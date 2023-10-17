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
})->name('welcome');

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

Route::get('/create-course', 'App\Http\Controllers\CourseRegistrationController@getLessonsAndRoomsForCreateCourse')
->middleware(['auth', 'verified'])->name('create-course');

Route::get('/course-admin', 'App\Http\Controllers\CourseRegistrationController@create')
->middleware(['auth', 'verified'])->name('course-admin');

// Course Registration routes
Route::get('/course-edit/{id}', 'App\Http\Controllers\CourseRegistrationController@edit')
    ->middleware(['auth', 'verified'])
    ->name('course-edit');

Route::get('/course-registration', 'App\Http\Controllers\CourseRegistrationController@create')
    ->middleware(['auth', 'verified'])
    ->name('course-registration-create');

Route::post('/course-registration', 'App\Http\Controllers\CourseRegistrationController@store')
    ->middleware(['auth', 'verified'])
    ->name('course-registration-store');

Route::delete('/course-custom/{id}', 'App\Http\Controllers\CourseRegistrationController@destroy')
    ->middleware(['auth', 'verified'])
    ->name('course-custom-destroy');

Route::get('/course-custom-edit/{id}', 'App\Http\Controllers\CourseRegistrationController@edit')
    ->middleware(['auth', 'verified'])
    ->name('course-custom-edit');

Route::post('/course-custom-update/{id}', 'App\Http\Controllers\CourseRegistrationController@update')
    ->middleware(['auth', 'verified'])
    ->name('course-custom-update');

// Route::get('/public-to-teacher/{id}', 'CourseController@publicToTeacher')
//     ->middleware(['auth', 'verified'])
//     ->name('public-to-teacher');
//

//Room Custom routes
Route::get('/room-edit/{id}', 'App\Http\Controllers\RoomCustomController@edit')
->middleware(['auth', 'verified'])->name('room-edit');

Route::get('/room-custom', 'App\Http\Controllers\RoomCustomController@create')
->middleware(['auth', 'verified'])->name('room-custom-create');

Route::post('/room-custom', 'App\Http\Controllers\RoomCustomController@store')
->middleware(['auth', 'verified'])->name('room-custom-store');

Route::delete('/room-custom/{id}', 'App\Http\Controllers\RoomCustomController@destroy')
->middleware(['auth', 'verified'])->name('room-custom-destroy');

Route::get('/room-custom-edit/{id}', 'App\Http\Controllers\RoomCustomController@edit')
->middleware(['auth', 'verified'])->name('room-custom-edit');

Route::post('/room-custom-update/{id}', 'App\Http\Controllers\RoomCustomController@update')
->middleware(['auth', 'verified'])->name('room-custom-update');
//

//Lesson Custom route
Route::get('/lesson-edit/{id}', 'App\Http\Controllers\LessonCustomController@edit')
->middleware(['auth', 'verified'])->name('lesson-edit');

Route::get('/lesson-custom', 'App\Http\Controllers\LessonCustomController@create')
->middleware(['auth', 'verified'])->name('lesson-custom-create');

Route::post('/lesson-custom', 'App\Http\Controllers\LessonCustomController@store')
->middleware(['auth', 'verified'])->name('lesson-custom-store');

Route::delete('/lesson-custom/{id}', 'App\Http\Controllers\LessonCustomController@destroy')
->middleware(['auth', 'verified'])->name('lesson-custom-destroy');

Route::get('/lesson-custom-edit/{id}', 'App\Http\Controllers\LessonCustomController@edit')
->middleware(['auth', 'verified'])->name('lesson-custom-edit');

Route::post('/lesson-custom-update/{id}', 'App\Http\Controllers\LessonCustomController@update')
->middleware(['auth', 'verified'])->name('lesson-custom-update');
//

Route::get('/rl-custom-admin', 'App\Http\Controllers\RoomCustomController@createBoth')
->middleware(['auth', 'verified'])->name('rl-custom-admin');

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