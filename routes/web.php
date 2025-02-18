<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VideoController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('upload', [VideoController::class, 'showUploadForm']);
Route::post('upload', [VideoController::class, 'handleUpload'])->name('upload.video');