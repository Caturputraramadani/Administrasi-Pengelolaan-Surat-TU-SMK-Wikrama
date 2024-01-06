<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LetterTypeController;

// Route Login
Route::middleware('IsGuest')->group(function () {
    Route::get('/', function () {
        return view('login');
    })->name('login');
    Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
});

Route::get('/error-permission', function () {
    return view('errors.permission');
})->name('error.permission');

Route::middleware(['IsLogin'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    // Route Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');
});


// Route User : Staff dan Guru
Route::middleware(['IsLogin', 'IsStaff'])->group(
    function () {
        Route::prefix('users')->name('users.')->group(function () {
            // Route User = Staff
            Route::get('/staff', [UserController::class, 'indexSt'])->name('indexSt');
            Route::get('/staff/create', [UserController::class, 'createSt'])->name('createSt');
            Route::post('/staff/store', [UserController::class, 'storeSt'])->name('storeSt');
            Route::get('/staff/{id}', [UserController::class, 'editSt'])->name('editSt');
            Route::patch('/staff/{id}', [UserController::class, 'updateSt'])->name('updateSt');
            Route::delete('/staff/{id}', [UserController::class, 'destroySt'])->name('destroySt');
            Route::get('/export-excel', [UserController::class, 'exportExcel'])->name('export-excel');

            // Route User = Guru
            Route::get('/guru', [UserController::class, 'indexGr'])->name('indexGr');
            Route::get('/guru/create', [UserController::class, 'createGr'])->name('createGr');
            Route::post('/guru/store', [UserController::class, 'storeGr'])->name('storeGr');
            Route::get('/guru/{id}', [UserController::class, 'editGr'])->name('editGr');
            Route::patch('/guru/{id}', [UserController::class, 'updateGr'])->name('updateGr');
            Route::delete('/guru/{id}', [UserController::class, 'destroyGr'])->name('destroyGr');
        });

        // Route Klasifikasi Surat
        Route::prefix('lettertyp')->name('lettertyp.')->group(function () {
            // Route klasifikasi Surat 
            Route::get('/klasifikasi', [LetterTypeController::class, 'index'])->name('index');
            Route::get('/klasifikasi/create', [LetterTypeController::class, 'create'])->name('create');
            Route::post('/klasifikasi/store', [LetterTypeController::class, 'store'])->name('store');
            Route::get('/klasifikasi/{id}/show', [LetterTypeController::class, 'show'])->name('show');
            Route::get('/klasifikasi/{id}', [LetterTypeController::class, 'edit'])->name('edit');
            Route::patch('/klasifikasi/{id}', [LetterTypeController::class, 'update'])->name('update');
            Route::delete('/klasifikasi/{id}', [LetterTypeController::class, 'destroy'])->name('destroy');
            Route::get('/download/{id}', [LetterTypeController::class, 'downloadPDF'])->name('download');
        });

       
    }
);

// Route Data Surat
Route::prefix('letter')->name('letter.')->group(function () {
    // Route klasifikasi Surat 
    Route::get('/', [LetterController::class, 'index'])->name('index');
    Route::get('/create', [LetterController::class, 'create'])->name('create');
    Route::post('/store', [LetterController::class, 'store'])->name('store');
    Route::get('/{id}', [LetterController::class, 'edit'])->name('edit');
    Route::get('/{id}/show', [LetterController::class, 'show'])->name('show');
    Route::patch('/{id}', [LetterController::class, 'update'])->name('update');
    Route::delete('/{id}', [LetterController::class, 'destroy'])->name('destroy');
    Route::get('/letters/export', [LetterController::class, 'exportExcel'])->name('exportExcel');
    Route::get('/letter/{id}/createMeetingResult', 'LetterController@createMeetingResult')->name('letter.createMeetingResult');
    
});

Route::prefix('result')->name('result.')->group(function () {
    // Route::get('/', [ResultController::class, 'index'])->name('index');
    Route::get('/create', [ResultController::class, 'create'])->name('create');
    Route::post('/store', [ResultController::class, 'store'])->name('store');
    Route::post('/result/store', [ResultController::class, 'store'])->name('result.store');

});


