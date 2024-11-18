<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/uploadFile/{group_id}', [FileController::class, 'uploadFile']);
    Route::post('/downloadFile/{file_id}', [FileController::class, 'downloadFile']);
    Route::post('/checkOutFile/{file_id}', [FileController::class, 'checkOutFile']);
    Route::post('/checkInFile/{file_id}', [FileController::class, 'checkInFile']);
    Route::post('/CreateGroup', [AuthController::class, 'CreateGroup']);
    Route::post('/AddUser_Group/{user_id}/{group_id}', [AuthController::class, 'AddUser_Group']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



