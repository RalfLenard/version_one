<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnimalProfileController;
use App\Http\Controllers\AnimalAbuseReportController;
use App\Http\Controllers\AdoptionRequestController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PusherAuthController;


use App\Events\AnimalProfileCreated;

// Route for the admin homepage
Route::get('/home', [HomeController::class, 'adminHomepage'])->name('admin.home')->middleware('auth');

Route::get('/home', [HomeController::class, 'userHomepage'])->name('user.home')->middleware('auth');


// Animal profile uploading
// Route to store a newly created animal profile
Route::post('/animal-profiles/store', [AnimalProfileController::class, 'store'])->name('animal-profiles.store');

// Route to list all animal profiles
Route::get('/animal-profiles', [AnimalProfileController::class, 'list'])->name('admin.animal-profile-list');

// delete animal and update
Route::post('/update-animal/{id}', [AnimalProfileController::class, 'update']);
Route::post('/delete-animal/{id}', [AnimalProfileController::class, 'destroy']);

// Animal view profile
Route::get('/animals/{id}', [HomeController::class, 'show'])->name('animals.show');



//adoption
Route::get('/adopt/{animalprofile}/request', [AdoptionRequestController::class, 'showAdoptionForm'])->name('adopt.show');

Route::post('/adopt/{id}/request', [AdoptionRequestController::class, 'submitAdoptionRequest'])->name('adoption.submit');

Route::get('/adoption-requests', [AdoptionRequestController::class, 'submitted'])->name('admin.adoption.requests');

Route::post('/adoption-request/{id}/approve', [AdoptionRequestController::class, 'approveAdoption'])->name('admin.adoption.approve');

Route::delete('/adoption-request/{id}/reject', [AdoptionRequestController::class, 'rejectAdoption'])->name('admin.adoption.reject');

Route::get('/rejected-Form', [AdoptionRequestController::class, 'rejectedForm']);

// Route to verify adoption requests
Route::post('/adoption/requests/{id}/verify', [AdoptionRequestController::class, 'setToVerifying'])->name('admin.adoption.verify');




// animal report
// Route to show the form for creating a new animal abuse report
Route::get('/report/abuse', [AnimalAbuseReportController::class, 'create'])->name('report.abuse.form');

// Route to store the submitted animal abuse report
Route::post('/report-abuse', [AnimalAbuseReportController::class, 'store'])->name('report.abuse.store');

// Route to display a listing of animal abuse reports for admin
Route::get('/animal-abuse-reports', [AnimalAbuseReportController::class, 'index'])->name('admin.animal-abuse-reports');


// meeting
// Display approved adoption requests
Route::get('/approved-requests', [MeetingController::class, 'showApprovedAdoptionRequests'])->name('admin.approved.requests');
// Show the form to schedule a meeting
Route::get('/schedule-meeting/{id}', [MeetingController::class, 'showScheduleMeetingForm'])->name('admin.schedule.meeting.form');
// Handle scheduling of the meeting
Route::post('/schedule-meeting', [MeetingController::class, 'scheduleMeeting'])->name('admin.schedule.meeting');
Route::get('/appointments', [MeetingController::class, 'viewAppointmentList'])->name('admin.appointments.list');
// Route to fetch appointments for a specific date
Route::get('/appointments/by-date', [MeetingController::class, 'getAppointmentsByDate'])->name('admin.appointments.byDate');
// Route to get all appointments
Route::get('/appointments/all', [MeetingController::class, 'getAllAppointments'])->name('admin.appointments.all');
// update meeting
Route::post('/meeting/update', [MeetingController::class, 'update'])->name('admin.meeting.update');




// notification
Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

//mesage
Route::get('/admin-messenger', [MessageController::class, 'adminMessage'])->name('admin.Message');
Route::get('/user-messenger', [MessageController::class, 'userMessage'])->name('user.Message');

Route::get('/messenger/{id}', [MessageController::class, 'chatWithUser']);
Route::get('/messenger/{id}', [MessageController::class, 'chatWithAdmin']);

Route::get('/chatify/{id}', function ($id) {
    // Redirect to the custom URL format
    return redirect()->route('user.Message', ['chat_user' => $id]);
})->where('id', '[0-9]+');

Route::get('/chatify/{id}', function ($id) {
    // Redirect to the custom URL format
    return redirect()->route('admin.Message', ['chat_user' => $id]);
})->where('id', '[0-9]+');


Route::get('/check-routes', function () {
    $routes = Route::getRoutes();
    foreach ($routes as $route) {
        if (strpos($route->uri(), 'appointments') !== false) {
            echo $route->uri() . '<br>';
        }
    }
});



Route::get('/', function () {
    return view('welcome');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/profile', function () {
    return view('profile.show');
})->name('profile.show');

Route::post('/pusher/auth', [PusherAuthController::class, 'auth'])->name('pusher.auth');


Route::get('/test-event', function () {
    $meeting = new \App\Models\Meeting([
        'user_id' => auth()->user()->id,
        'adoption_request_id' => 1, // Provide an actual ID if needed
        'meeting_date' => now(),
        'status' => 'Scheduled'
    ]);

    event(new \App\Events\MeetingScheduled($meeting));

    return 'Event triggered!';
});