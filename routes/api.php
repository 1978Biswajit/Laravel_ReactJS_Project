<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
});





Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| এখানে API রাউটসমূহ সংজ্ঞায়িত করা হয়েছে। Sanctum Middleware ব্যবহার করে API
| কে সুরক্ষিত করা হয়েছে, যাতে শুধু অনুমোদিত ব্যবহারকারী কিছু নির্দিষ্ট অ্যাকশন করতে পারে।
|
*/

// 🟢 Public Routes (Authentication)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 🛑 Protected Routes (Requires Authentication)
Route::middleware('auth:sanctum')->group(function () {
    
    // 🔴 User Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // 🟢 Authenticated User Information
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    // 🔵 Role-Based Access Control (Admin Only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    });

    // 🟠 Product Management (Authenticated Users Only)
    Route::apiResource('/products', ProductController::class);
});
