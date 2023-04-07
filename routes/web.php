<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\ReviewsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/', [IndexController::class, 'Index'])->name('/');

//Frontend 
Route::middleware(['auth'])->group(function () {

    Route::prefix('user')->group(function () {
        Route::get('/logout', [IndexController::class, 'UserLogout'])->name('user.logout');

        Route::get('/profile/edit', [IndexController::class, 'UserProfileEdit'])->name('user.profile.edit');
        Route::post('/profile/store', [IndexController::class, 'UserProfileStore'])->name('user.profile.store');

        Route::get('/change/password', [IndexController::class, 'UserChangePassword'])->name('user.change.password');
        Route::post('/password/update', [IndexController::class, 'UserPasswordUpdate'])->name('user.password.update');


        Route::get('/blog/add', [BlogController::class, 'BlogAdd'])->name('blog.add');
        Route::post('/blog/store', [BlogController::class, 'BlogStore'])->name('blog.store');

        Route::get('/all/blog', [BlogController::class, 'AllBlog'])->name('all.blog');

        Route::get('/blog/detail/{id}', [BlogController::class, 'BlogDetails'])->name('blog.detail');

        Route::post('/review/store', [ReviewsController::class, 'ReviewStore'])->name('review.store');
    });
});

//Admin 
Route::middleware(['can:admin'])->group(function () {

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'Index'])->name('admin.dashboard');
        Route::get('/all/user', [AdminController::class, 'AllUser'])->name('all.user');
        Route::get('/user/inactive/{id}', [AdminController::class, 'UserInactive'])->name('user.inactive');
        Route::get('/user/active/{id}', [AdminController::class, 'UserActive'])->name('user.active');
    });
});

Route::get('/login', [IndexController::class, 'Login'])->name('login');
Route::post('/login/store', [IndexController::class, 'LoginStore'])->name('user.login');
