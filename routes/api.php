<?php

use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\Api\ResultController;
use Illuminate\Support\Facades\Route;

Route::apiResource('exams', ExamController::class)->parameters(['exams' => 'exam'])->names('api.exams');
Route::apiResource('results', ResultController::class)->only(['index', 'store'])->names('api.results');

Route::prefix('v1')->group(function (): void {
    Route::apiResource('exams', ExamController::class)->parameters(['exams' => 'exam'])->names('api.v1.exams');
    Route::apiResource('results', ResultController::class)->only(['index', 'store'])->names('api.v1.results');
});
