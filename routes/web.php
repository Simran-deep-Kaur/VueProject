<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PaginatedEmployeesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchEmployeesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValidateEmailController;
use App\Http\Middleware\EmployeeAccessControl;
use App\Http\Middleware\EnsureSuperAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');

Route::middleware(EnsureSuperAdmin::class)->get('/dashboard/{type?}', [EmployeeController::class, 'index'])->name('dashboard');


Route::get('/users/show/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
Route::delete('/users/delete/{user}', [UserController::class, 'destroy'])->name('user.destroy');
Route::put('/users/update/{user}', [UserController::class, 'update'])->name('user.update');

Route::get('/paginated-employees', [PaginatedEmployeesController::class, 'paginatedEmployees'])->name('paginated-employees');
Route::post('/store', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/search', [SearchEmployeesController::class, 'search'])->name('employees.search');

Route::middleware(EmployeeAccessControl::class)->group(function() {
    Route::get('/show/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('/edit/{employee}', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/update/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/delete/{employee}', [EmployeeController::class, 'destroy'])->name('employees.delete');    
});

Route::get('/user/create', [UserController::class, 'create'])->name('users.create');
Route::post('/user/store', [UserController::class, 'store'])->name('users.store');

Route::get('/validateEmail', [ValidateEmailController::class, 'validateEmail'])->name('employees.validateEmail');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';