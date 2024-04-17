<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiGeneratorController;
Route::get('/', function () {
    return view('chat');
});
Route::post('/ai-generator/question', [AiGeneratorController::class, 'sendQuestion'])->name('ai.sendQuestion');