<?php

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BorrowRecordController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


//Main Page
Route::get('/',[CatalogController::class,'index'])->name('home');
Route::get('/book/{book}',[CatalogController::class,'show'])->name('books.show');

//Client Routes
Route::middleware(['auth','role:client'])->group(function(){
    Route::post('/book/{book}/borrow',[BorrowController::class, 'store'])->name('borrow.store');
    Route::get('/my-borrows',[BorrowController::class, 'index'])->name('borrows.index');
});

//Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('authors', AuthorController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('books', BookController::class);

    Route::get('/borrows', [BorrowRecordController::class, 'index'])->name('borrows.index');
    Route::patch('/borrows/{record}/return', [BorrowRecordController::class, 'returnBook'])
        ->name('borrows.return');
});

// Dashboard Route (Breeze Default)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes (Breeze Default)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
