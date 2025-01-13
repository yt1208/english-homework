<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\VocabularyController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});


Route::get('/about', function () {
    return view('about');
})->middleware('auth')->name('about');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('homeworks', HomeworkController::class, ['except'=>['show']]);

Route::get('/homeworks/{id}/destroy', [HomeworkController::class, 'destroyPage'])->name('homeworks.destroyPage');

Route::resource('units', UnitController::class);

Route::get('units/{slug}/test', [UnitController::class, 'test'])->name('units.test');

Route::resource('vocabularies', VocabularyController::class, ['except'=>['show']]);



