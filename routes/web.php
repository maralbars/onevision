<?php

use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::redirect('/', 'feedback');

Route::resource('feedback', FeedbackController::class)->only([
    'index', 'create', 'store', 'update'
]);;

Route::get('feedback/{feedback}/download', [FeedbackController::class, 'downloadAttachment'])->name('feedback.download');