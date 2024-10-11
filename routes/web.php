<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('users', [UserController::class, 'index'])->name('users')->middleware('auth');
Route::get('user_list', [UserController::class, 'getUserlist'])->name('user_list')->middleware('auth');
Route::post('user_details', [UserController::class, 'getUserDetails'])->name('user_details')->middleware('auth');
Route::post('update_user', [UserController::class, 'updateUser'])->name('update_user')->middleware('auth');
Route::post('create_user', [UserController::class, 'createUser'])->name('create_user')->middleware('auth');
Route::post('/soft_delete_user', [UserController::class, 'softDeleteUser'])->name('user.soft_delete')->middleware('auth');;
Route::get('/trashed_users_list', [UserController::class, 'getTrashedUserList'])->name('user.trashed_users_list')->middleware('auth');;
Route::get('/trashed_users', [UserController::class, 'getTrashedUser'])->name('user.trashed_users')->middleware('auth');;
Route::get('reactivate_user/{id}', [UserController::class, 'reactivateUser'])->name('user.reactivate_user')->middleware('auth');
Route::delete('permanentlyDeleteUser/{id}', [UserController::class, 'permanentlyDeleteUser'])
    ->name('user.permanent_delete_user')
    ->middleware('auth');





require __DIR__ . '/auth.php';
