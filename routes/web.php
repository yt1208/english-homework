<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\VocabularyController;
use App\Http\Controllers\GrammarChatGPTController;


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

Route::resource('units', UnitController::class);

Route::resource('vocabularies', VocabularyController::class, ['except'=>['show']]);

Route::get('/units/{slug}/grammarChatGPT', [GrammarChatGPTController::class, 'index'])->name('grammar.index');

Route::post('/units/{slug}/grammarChatGPT/post', [GrammarChatGPTController::class, 'post'])->name('grammar.post');





