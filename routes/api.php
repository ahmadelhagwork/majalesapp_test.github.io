<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SettingController;
use App\Http\Controllers\API\SocialiteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('check-api-token')->group(function () {

    Route::controller(SettingController::class)->group(function () {

        Route::get('/languages', 'ShowLanguages');

        Route::post('/set-language', 'SetLanguage');
    });
    Route::middleware('locale-API')->group(function () {

        Route::controller(AuthController::class)->group(function () {

            Route::post('/register', 'AuthRegister');

            Route::post('/login', 'AuthLogin');

            Route::post('/confirm-email', 'ConfirmEmail');

            Route::put('/reset-password', 'ResetPassword')->middleware('email-not-found');
        });
        Route::controller(SocialiteController::class)->group(function () {

            Route::get('auth/{provider}/', 'LoginSocial');
        });
        Route::middleware('auth-api-user')->group(function () {

            Route::controller(AuthController::class)->group(function () {

                Route::post('/verfiy', 'VerficationAccount')
                    ->middleware(['verficationCode-Header', 'user-Verfication-API']);

                Route::post('/logout', 'AuthLogout');
            });
            Route::middleware('userAccount-notVerfication-API')->group(function () {

                Route::controller(AuthController::class)->group(function () {

                    Route::get('/user', 'GetAuthenticatedUser');
                });
            });
        });
    });
});
