
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReportController;

Route::get('/', [BookController::class, 'catalog'])->name('home');
Route::get('/catalog', [BookController::class, 'catalog'])->name('catalog');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Admin and Librarian
    Route::middleware('role:admin,librarian')->group(function () {
        Route::resource('books', BookController::class)->except(['show']);
        Route::resource('borrowers', BorrowerController::class)->except(['show']);

        Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
        Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
        Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
        Route::post('/loans/{loan}/return', [LoanController::class, 'returnBook'])->name('loans.return');

        Route::get('/reports', ReportController::class)->name('reports');
    });

    // Student
    Route::post('/catalog/{book}/borrow', [LoanController::class, 'borrow'])
        ->middleware('role:student')
        ->name('catalog.borrow');

    Route::get('/my-loans', [LoanController::class, 'myLoans'])
        ->middleware('role:student')
        ->name('my-loans');
});
