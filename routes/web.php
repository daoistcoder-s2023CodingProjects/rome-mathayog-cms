<?php

use App\Http\Controllers\DataByLevelController;
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

Route::redirect('/', '/admin');

// Display all data initially
Route::get('/welcome', [DataByLevelController::class, 'displayAllData'])->name('welcome');

// Search and display data
Route::post('/welcome/display_data_by_level', [DataByLevelController::class, 'displayDataByLevel'])
    ->name('welcome.display_data_by_level');
