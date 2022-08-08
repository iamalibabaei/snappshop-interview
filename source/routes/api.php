<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// A veryyy basic authentication method :)
Route::post('/user/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
    return new JsonResponse(['token' => $user->createToken($request->email)->plainTextToken]);
});



Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/transfer', [TransactionController::class, 'transfer']);
    Route::get('/users/most', [UserController::class, 'getUsersWithMostTransactions']);

});
