<?php

use App\Http\Controllers\DataByLevelController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

//check the files in s3, and show it in json format
Route::get('/s3-test', function () {
    $files = Storage::disk('s3')->files();
    return response()->json($files);
});

// create a file in s3 and show it in json format
Route::get('/s3-test/create', function () {
    Storage::disk('s3')->put('test.txt', 'Hello s3 bucket!');
    return response()->json('File was created');
});

Route::get('/s3-test/access', function () {
    $disk = 's3'; // Change this to 's3'
    $filename = 'sign.PNG';

    // Check if the file exists in the S3 disk
    if (!Storage::disk($disk)->exists($filename)) {
        dd('File does not exist in S3');
    }

    // If the file exists, return its URL
    return Storage::disk($disk)->url($filename);
});

Route::get('/s3_test_dev', function () {
    $disk = 'images';
    $filename = 'dev.jpg';

    // Check if the file exists in the default storage disk
    if (!Storage::exists($filename)) {
        dd('File does not exist');
    }

    $testImage = Storage::get($filename);



    Storage::disk($disk)->put($filename, $testImage);

    return Storage::disk($disk)->url($filename);
});
