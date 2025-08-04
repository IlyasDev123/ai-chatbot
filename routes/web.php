<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Domains\Chatbot\Controllers\ChatbotController;
use App\Domains\LeafLetMap\Controllers\LeafLetMapController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::middleware('auth')->group(function () {
    Route::resource('events', \App\Http\Controllers\EventController::class);
    Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
    Route::post('/chatbot/message', [ChatbotController::class, 'ask'])->name('chatbot.ask');
    Route::get('/map', [LeafLetMapController::class, 'index'])->name('map.index');
    Route::post('/ai/map', [LeafLetMapController::class, 'getPlaces'])->name('map.getPlaces');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/train-data', [\App\Http\Controllers\AIController::class, 'trainData'])->name('ai.trainData');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
