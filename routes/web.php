<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\NotificationSettingsController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidentNotificationController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\RequestFeedbackController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\StaffRequestController;
use App\Http\Controllers\StaffResidentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffServicesController;
use App\Http\Controllers\StaffReportsController;
use App\Http\Controllers\StaffSettingsController;
use App\Http\Controllers\ContactMessageController;



Route::get('/', function () {
    return view('landing');
});

Route::get('/signin', function () {
    return view('signin');
});

Route::get('/signup', function () {
    return view('signup');
});

Route::get('/dashboard', [RequestController::class, 'dashboard'])
    ->name('dashboard')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/resident-notifications',
        [ResidentNotificationController::class, 'index']
    )->name('resident-notifications.index');

Route::get('/announcements', function () {
    $announcements = \Illuminate\Support\Facades\DB::table('announcements')
        ->where('is_published', true)
        ->whereNotNull('published_at')
        ->orderByDesc('published_at')
        ->get();

    return view('announcements', compact('announcements'));
})->middleware('auth')->name('announcements.index');


Route::patch('/resident-notifications/{id}/read',
        [ResidentNotificationController::class, 'markAsRead']
    )->name('resident-notifications.read');
});

Route::view('/request', 'request')
    ->name('request')
    ->middleware('auth');

Route::get('/request/create', function () {
    return view('request-form');
})->name('requests.create')->middleware('auth');

Route::get('/my-requests', [RequestController::class, 'index'])
    ->name('requests.index')
    ->middleware('auth');

Route::post(
    '/requests/{requestId}/feedback',
    [RequestFeedbackController::class, 'store']
)->name('requests.feedback.store');

Route::get('/request-history', [RequestController::class, 'history'])
    ->name('requests.history')
    ->middleware('auth');

Route::get('/profile', [NotificationSettingsController::class, 'show'])
    ->middleware('auth')
    ->name('profile');

Route::post('/profile', [ProfileController::class, 'update'])
    ->middleware('auth')
    ->name('profile.update');

Route::post('/notification-settings', [NotificationSettingsController::class, 'update'])
    ->middleware('auth')
    ->name('notification-settings.update');

Route::post('/profile/password', [PasswordController::class, 'update'])
    ->middleware('auth')
    ->name('password.update');

Route::get('/help', function () {
    return view('help');
})->name('help')->middleware('auth');

Route::post('/signup', [AuthController::class, 'register'])
    ->name('register');

Route::post('/signin', [AuthController::class, 'login'])
    ->name('login');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])
->name('google.redirect');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])
    ->name('google.callback');

Route::post('/request/submit', [RequestController::class, 'store'])
    ->name('requests.store')
    ->middleware('auth');

Route::patch('/requests/{id}/cancel', [
    \App\Http\Controllers\RequestController::class,
    'cancel'
])->middleware('auth')->name('requests.cancel');


// staff route

Route::get('/dashstaff', [StaffDashboardController::class, 'index']);

Route::get('/staff/requests/incoming', [
    StaffRequestController::class,
    'incoming'
]);

Route::get('/staff/requests/{id}', [
    StaffRequestController::class,
    'show'
])->name('staff.requests.show');

Route::patch('/staff/requests/{id}/status', [
    StaffRequestController::class,
    'updateStatus'
])->name('staff.requests.updateStatus');

Route::get('/staff/requests', [
    StaffRequestController::class,
    'allRequests'
]);

Route::get('/staff/residents', [StaffResidentsController::class, 'index'])
    ->name('staff.residents');

Route::get('/staff/residents', [StaffController::class, 'residents'])
    ->name('staff.residents');

Route::get('/staff/services', [StaffServicesController::class, 'index'])
    ->name('staff.services.index');

    // staff services
Route::post('/staff/services', [StaffServicesController::class, 'store'])
    ->name('staff.services.store');

Route::get('/staff/services/{id}/edit', [StaffServicesController::class, 'edit'])
    ->name('staff.services.edit');

Route::put('/staff/services/{id}', [StaffServicesController::class, 'update'])
    ->name('staff.services.update');

//  reports
Route::get('/staff/reports', [StaffReportsController::class, 'index'])
    ->name('staff.reports');

Route::get('/staff/reports/export', [StaffReportsController::class, 'export'])
    ->name('staff.reports.export');

    // Settings
Route::get('/staff/settings', [StaffSettingsController::class, 'index'])
    ->name('staff.settings');

Route::put('/staff/settings/profile', [StaffSettingsController::class, 'updateProfile'])
    ->name('staff.settings.profile');

Route::put('/staff/settings/password', [StaffSettingsController::class, 'updatePassword'])
    ->name('staff.settings.password');

Route::put('/staff/settings/notifications', [StaffSettingsController::class, 'updateNotifications'])
    ->name('staff.settings.notifications');

Route::patch('/staff/settings/barangay', [StaffSettingsController::class, 'updateBarangayInfo'])
    ->name('staff.settings.barangay');

Route::post('/contact-messages', [ContactMessageController::class, 'store'])
    ->middleware('auth')
    ->name('contact-messages.store');

Route::post('/contact-messages/{id}/reply', [ContactMessageController::class, 'reply'])
    ->middleware('auth')
    ->name('contact-messages.reply');