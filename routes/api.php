<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CandidatesController;
use App\Http\Controllers\Api\CompetenciesController;
use App\Http\Controllers\Api\LanguagesController;
use App\Http\Controllers\Api\PositionsController;
use App\Http\Controllers\Api\TrainingController;
use App\Http\Controllers\Api\RecruiterTokenController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function() {
    Route::post('register', 'register');
    Route::post('login', 'login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', 'userProfile');
        Route::get('logout', 'logout');
        Route::apiResource('competencies', CompetenciesController::class);
        Route::apiResource('languages', LanguagesController::class);
        Route::apiResource('training', TrainingController::class);
        Route::apiResource('positions', PositionsController::class);
        Route::apiResource('candidates', CandidatesController::class);
    });

    Route::apiResource('recruiter-tokens', RecruiterTokenController::class);
});
