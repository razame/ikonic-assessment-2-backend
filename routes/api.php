<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->group(function (){
    Route::get('feedbacks', [FeedbackController::class, 'index']);
    Route::post('feedbacks', [FeedbackController::class, 'store']);
    Route::get('feedbacks/{id}', [FeedbackController::class, 'show']);
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);


// User             (name, email, password)
// Feedback         (title, desc, user_id, category [e.g., bug report, feature request, improvement, etc.])
// Comment          (text, user_id, feedback_id, is_published)
// Vote             (is_upvote, user_id, feedback_id)
// Notifications    (notification_text) // realtime notifications using websockets
