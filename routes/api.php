<?php

use App\Http\Controllers\Api\V1\AuthenticationController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

// === PUBLIC ROUTES
Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // === AUTH ROUTES
    Route::post('logout', [AuthenticationController::class, 'logout']);
    Route::get('profile', [AuthenticationController::class, 'profile']);

    // === USER ROUTES
    Route::apiResource('users', UserController::class);

    // === ROLE ROUTES
    Route::apiResource('roles', RoleController::class);

    // === PERMISSION ROUTES
    Route::get('permissions', [PermissionController::class, 'index']);

    // =======================================================================
    // =======================================================================
    // === ONLY ADMIN ROLE ROUTES
    Route::middleware('role:admin')->group(function(){
        Route::get('admin/dashboard', fn() => response()->json(['message' => 'You are realy an admin']));
    });

    // === ONLY USER ROLE ROUTES
    Route::middleware('role:user')->group(function(){
        Route::get('user/dashboard', fn() => response()->json(['message' => 'You are realy a user']));
    });

});