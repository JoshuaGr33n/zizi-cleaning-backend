<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth\UserAuthController;
use \App\Http\Controllers\Auth\ForgotPasswordController;
use \App\Http\Controllers\Admin\{AdminProfileController, AdminSettingsController, AdminStaffController};
use \App\Http\Controllers\{AppointmentController};
use App\Http\Middleware\{IsAdmin, IsAdminStaff, IsAdminSubAdmin};

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('login', [UserAuthController::class, 'login']);
// Route::post('register',[\App\Http\Controllers\Auth\UserAuthController::class, 'register']);
// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
// Route::post('/forgot-password', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/reset-password',  [ForgotPasswordController::class, 'reset'])->name('password.reset');



Route::get('settings/{category}', [AdminSettingsController::class, 'getSettingCategory']);

Route::post('book-residential-request', [AppointmentController::class, 'createResidentialRequest']);
Route::post('book-commercial-request', [AppointmentController::class, 'createCommercialRequest']);
Route::get('appointment/{id}', [AppointmentController::class, 'getAppointment']);
Route::post('/appointments/{id}/update-status', [AppointmentController::class, 'updateStatusClient']);

Route::get('/get-admins-staff', [AdminStaffController::class, 'allAdminStaff']);



Route::group(['middleware' => ['auth:api']], function () {
    Route::get('profile', [UserAuthController::class, 'profile']);
    Route::post('logout', [UserAuthController::class, 'logout']);

    Route::prefix('admin')->middleware([IsAdminStaff::class])->group(function () {
        Route::put('update-profile', [AdminProfileController::class, 'updateProfile']);
        Route::put('change-password', [AdminProfileController::class, 'changePassword']);
        Route::post('upload-image', [AdminProfileController::class, 'uploadImage']);

        Route::get('appointments/{flag}', [AppointmentController::class, 'getAppointments']);
        Route::get('appointments/{flag}/count', [AppointmentController::class, 'countUnreadAppointments']);
        Route::post('/appointments/{id}/toggle-read/{tag}', [AppointmentController::class, 'toggleRead']);
        Route::post('/appointments/{id}/update-status', [AppointmentController::class, 'updateStatus']);
        Route::delete('/delete-appointment/{id}/', [AppointmentController::class, 'deleteAppointment']);
    });
    Route::prefix('admin')->middleware([IsAdminSubAdmin::class])->group(function () {
        Route::post('/user/{id}/toggle-status', [AdminStaffController::class, 'toggleUserStatus']);

        Route::post('create-staff', [AdminStaffController::class, 'createStaff']);
      
        Route::post('create-setting', [AdminSettingsController::class, 'createSetting']);
        Route::post('update-setting/{id}', [AdminSettingsController::class, 'updateSetting']);
        Route::get('/settings', [AdminSettingsController::class, 'settings']);
        Route::get('/setting/{id}', [AdminSettingsController::class, 'singleSetting']);
        Route::delete('/delete-setting/{id}', [AdminSettingsController::class, 'deleteSetting']);

        Route::get('staff/{id}', [AdminStaffController::class, 'getUser']);
        Route::delete('staff/{id}/delete', [AdminStaffController::class, 'deleteUser']);

        // Route::post('/test-upload', function (Request $request) {
        //     if ($request->hasFile('image')) {
        //         return response()->json(['message' => 'File is present']);
        //     }
        //     return response()->json(['message' => 'No file uploaded'], 422);
        // });
    });

    Route::prefix('admin')->middleware([IsAdmin::class])->group(function () {
        Route::post('/user/{id}/update-role', [AdminStaffController::class, 'updateRole']);
    });
});
