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
Route::get('/phpinfo', function () {
    phpinfo();
});

Route::get('/', 'App\Http\Controllers\AdminController@showPostTeacherWelcome')
    ->name('welcome');

//Authenticate Admin

Route::get('/registerAdmin', 'App\Http\Controllers\Auth\AuthenticateAdminController@showRegisterAdmin')->name('showRegisterAdmin');

Route::get('/admin', 'App\Http\Controllers\Auth\AuthenticateAdminController@showformAdmin');

Route::post('accuracyAdmin', 'App\Http\Controllers\Auth\AuthenticateAdminController@AuthenticateAdmin')
    ->name('accuracyAdmin');


Route::post('logout-homepage', 'App\Http\Controllers\Auth\AuthenticatedSessionController@destroyHomePage')
    ->name('logout-homepage');

Route::get('/management-system', 'App\Http\Controllers\ManagementSystemController@index')
    ->middleware(['auth', 'verified'])->name('management-system');

Route::get('/currentcourses', 'App\Http\Controllers\FeedbackController@showCurrentcourses')
    ->name('current_courses');


//Fullcalender
    Route::get('fullcalendar','App\Http\Controllers\FullCalendarController@index')->name('calendarIndex');
    Route::post('fullcalendar/create','App\Http\Controllers\FullCalendarController@create');
    Route::post('fullcalendar/update','App\Http\Controllers\FullCalendarController@update');
    Route::post('fullcalendar/delete','App\Http\Controllers\FullCalendarController@destroy');

// Student's routes

    Route::get('/dashboard-student', 'App\Http\Controllers\StudentController@showRLDashBoardStudent')
        ->middleware(['auth', 'verified'])->name('dashboard-student');

    Route::get('/schedule-student', 'App\Http\Controllers\StudentController@showCalenderStudent')
        ->middleware(['auth', 'verified'])->name('schedule-student');

    Route::get('/course-list-student', 'App\Http\Controllers\StudentController@CourseListStudent')
        ->middleware(['auth', 'verified'])->name('course-list-student');

    Route::get('/register-course-student/{userId}/{courseId}', 'App\Http\Controllers\StudentController@registerCourseStudent')
        ->middleware(['auth', 'verified', 'role:Student'])
        ->name('register-course-student');

    Route::get('/tuition-student', 'App\Http\Controllers\StudentController@showCourseBillStudent')
        ->middleware(['auth', 'verified'])->name('tuition-student');

    // PayPal
        Route::post('paypal/{id}/{date}', 'App\Http\Controllers\PaypalController@paymen')->name('paypal');
        Route::get('paypal/success', 'App\Http\Controllers\PaypalController@success')->name('paypal-success');
        Route::get('paypal/cancel', 'App\Http\Controllers\PaypalController@cancel')->name('paypal-cancel');

// Teacher's routes

    Route::get('/dashboard-teacher', 'App\Http\Controllers\TeacherController@showRLDashBoardTeacher')
        ->middleware(['auth', 'verified'])->name('dashboard-teacher');

    Route::get('/schedule-teacher', 'App\Http\Controllers\TeacherController@showCalenderTeacher')
        ->middleware(['auth', 'verified'])->name('schedule-teacher');

    Route::get('/course-list-teacher', 'App\Http\Controllers\TeacherController@CourseListTeacher')
        ->middleware(['auth', 'verified', 'role:Teacher'])
        ->name('course-list-teacher');

    Route::get('/register-course-teacher/{userId}/{courseId}', 'App\Http\Controllers\TeacherController@registerCourseTeacher')
        ->middleware(['auth', 'verified', 'role:Teacher'])
        ->name('register-course-teacher');

    Route::get('/student-list-teacher/{id}', 'App\Http\Controllers\TeacherController@StudentListTeacher')
        ->middleware(['auth', 'verified', 'role:Teacher'])
        ->name('student-list-teacher');

    Route::get('/student-list', 'App\Http\Controllers\TeacherController@hienthiStudentList')
        ->middleware(['auth', 'verified'])->name('student-list');

// Admin's routes

    Route::get('/dashboard-admin', 'App\Http\Controllers\AdminController@showRLDashBoard')
        ->middleware(['auth', 'verified'])->name('dashboard-admin');

    //Notification Edit to Admin
        Route::get('/edit-requests', 'App\Http\Controllers\EditRequestController@showRequestToAdmin')
            ->middleware(['auth', 'verified'])->name('edit-request');

        Route::post('/receive-edit-request', 'App\Http\Controllers\EditRequestController@sendRequestToSecondEdit')
            ->middleware(['auth', 'verified'])->name('receive-edit-request');

        Route::post('/edit-accept/{id_user}/{id_edit}', 'App\Http\Controllers\EditRequestController@editAcceptFromAdmin')
            ->name('edit-accept');

        Route::post('/edit-refuse/{id_edit}', 'App\Http\Controllers\EditRequestController@editRefuseFromAdmin')
            ->name('edit-refuse');

    Route::get('/create-course', 'App\Http\Controllers\CourseRegistrationController@getLessonsAndRoomsForCreateCourse')
        ->middleware(['auth', 'verified'])->name('create-course');

    Route::get('/courses', 'App\Http\Controllers\CourseRegistrationController@create')
        ->middleware(['auth', 'verified'])->name('course-admin');

    // Course Registration routes
    Route::get('/course-edit/{id}', 'App\Http\Controllers\CourseRegistrationController@editForm')
        ->middleware(['auth', 'verified'])
        ->name('course-edit');

    Route::get('/course-registration', 'App\Http\Controllers\CourseRegistrationController@create')
        ->middleware(['auth', 'verified'])
        ->name('course-registration-create');

    Route::post('/course-registration', 'App\Http\Controllers\CourseRegistrationController@store')
        ->middleware(['auth', 'verified'])
        ->name('course-registration-store');

    Route::delete('/course-custom-destroy/{id}', 'App\Http\Controllers\CourseRegistrationController@destroy')
        ->middleware(['auth', 'verified'])
        ->name('course-custom-destroy');

    Route::get('/course-custom-edit/{id}', 'App\Http\Controllers\CourseRegistrationController@edit')
        ->middleware(['auth', 'verified'])
        ->name('course-custom-edit');

    Route::post('/course-custom-update/{id}', 'App\Http\Controllers\CourseRegistrationController@update')
        ->middleware(['auth', 'verified','role:Admin'])
        ->name('course-custom-update');

    Route::get('/public-to-teacher/{id}', 'App\Http\Controllers\TeacherController@publicToTeacher')
        ->middleware(['auth', 'verified', 'role:Admin'])
        ->name('public-to-teacher');

    Route::get('/public-to-student/{id}', 'App\Http\Controllers\StudentController@publicToStudent')
        ->middleware(['auth', 'verified', 'role:Admin'])
        ->name('public-to-student');

    Route::get('/published-to-student/{id}', 'App\Http\Controllers\StudentController@index')
        ->middleware(['auth', 'verified'])
        ->name('published-to-student');

    //Room Custom routes
    Route::get('/room-edit/{id}', 'App\Http\Controllers\RoomCustomController@edit')
        ->middleware(['auth', 'verified'])->name('room-edit');

    // Route::get('/room-custom', 'App\Http\Controllers\RoomCustomController@create')
    //     ->middleware(['auth', 'verified'])->name('room-custom-create');

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

    // Route::get('/lesson-custom', 'App\Http\Controllers\LessonCustomController@create')
    //     ->middleware(['auth', 'verified'])->name('lesson-custom-create');

    Route::post('/lesson-custom', 'App\Http\Controllers\LessonCustomController@store')
        ->middleware(['auth', 'verified'])->name('lesson-custom-store');

    Route::delete('/lesson-custom/{id}', 'App\Http\Controllers\LessonCustomController@destroy')
        ->middleware(['auth', 'verified'])->name('lesson-custom-destroy');

    Route::get('/lesson-custom-edit/{id}', 'App\Http\Controllers\LessonCustomController@edit')
        ->middleware(['auth', 'verified'])->name('lesson-custom-edit');

    Route::post('/lesson-custom-update/{id}', 'App\Http\Controllers\LessonCustomController@update')
        ->middleware(['auth', 'verified'])->name('lesson-custom-update');
    //

    Route::get('/rooms-lessons', 'App\Http\Controllers\RoomCustomController@createBoth')
        ->middleware(['auth', 'verified'])->name('rl-custom-admin');

    //Teachers & Students management from Admin
        Route::get('/users-management', 'App\Http\Controllers\AdminController@usersManagement')
            ->middleware(['auth', 'verified'])
            ->name('users-management');

        //Xoa teacher khoi khoa hoc
        Route::delete('/teacher-deleteCourse/{userId}/{courseName}', 'App\Http\Controllers\AdminController@deleteTeacherfromCourse')
            ->middleware(['auth', 'verified'])
            ->name('teacher-deleteCourse');

        //Xoa student khoi khoa hoc
        Route::delete('/student-deleteCourse/{userId}/{idCourse}', 'App\Http\Controllers\AdminController@deleteStudentfromCourse')
            ->middleware(['auth', 'verified'])
            ->name('student-deleteCourse');

    //Xoa User
    Route::delete('/confirm-delete/{id}', 'App\Http\Controllers\AdminController@confirmDelete')
        ->middleware(['auth', 'verified'])
        ->name('confirm-delete');

    Route::get('/student-list-a/{courseID}', 'App\Http\Controllers\CourseRegistrationController@StudentListAdmin')
        ->middleware(['auth', 'verified', 'role:Admin'])
        ->name('student-list-a');

    Route::get('/student-list-admin', 'App\Http\Controllers\CourseRegistrationController@hienthiStudentListA')
        ->middleware(['auth', 'verified'])->name('student-list-admin');

    Route::get('/schedule-admin', 'App\Http\Controllers\AdminController@showCalenderAdmin')
        ->middleware(['auth', 'verified'])->name('schedule-admin');

    Route::get('/teachers/{id}', 'App\Http\Controllers\AdminController@showTeachersdetails')
        ->name('teachers-details');

    //Posts
    Route::get('/posts', 'App\Http\Controllers\AdminController@showPosts')
        ->name('posts');

    Route::get('/posts/{id}', 'App\Http\Controllers\AdminController@showPostsdetails')
        ->name('posts-details');

    Route::get('/posts-admin', 'App\Http\Controllers\AdminController@showPostsManagement')
        ->middleware(['auth', 'verified'])->name('posts-admin');

    Route::post('/create-post', 'App\Http\Controllers\AdminController@createPost')
        ->middleware(['auth', 'verified'])->name('create-post');

    Route::get('/post-edit/{id}', 'App\Http\Controllers\AdminController@editPost')
        ->middleware(['auth', 'verified'])->name('post-edit');

    Route::post('/post-update/{id}', 'App\Http\Controllers\AdminController@updatePost')
        ->middleware(['auth', 'verified'])->name('post-update');

    Route::delete('/post-delete/{id}', 'App\Http\Controllers\AdminController@deletePost')
        ->middleware(['auth', 'verified'])->name('post-delete');

    //Banner
    Route::get('/banners', 'App\Http\Controllers\BannerController@list')
        ->name('banners');

    Route::post('/create-banner', 'App\Http\Controllers\BannerController@create')
        ->middleware(['auth', 'verified'])->name('create-banner');

    Route::post('/banner/update-showhide/{id}', 'App\Http\Controllers\BannerController@updateShowHide')
        ->middleware(['auth', 'verified'])->name('update-showhide-banner');

    Route::delete('/banner-delete/{id}', 'App\Http\Controllers\BannerController@delete')
        ->middleware(['auth', 'verified'])->name('banner-delete');

    //Bill
    Route::get('/bills', 'App\Http\Controllers\AdminController@showBills')
        ->name('bills');

    //Feedback
    Route::get('/contact', 'App\Http\Controllers\FeedbackController@contactus')
        ->name('contact');

    Route::post('/contact/create-feedback', 'App\Http\Controllers\FeedbackController@createFeedback')
        ->name('feedback');

    Route::get('/feedbacks', 'App\Http\Controllers\FeedbackController@showFeedbacks')
        ->name('showFeedbacks');

    Route::get('/showFeedbackstoAdmin', 'App\Http\Controllers\FeedbackController@showFBtoAdmin')
        ->middleware(['auth', 'verified'])->name('showFBtoAdmin');

//Profile's Admin routes

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
