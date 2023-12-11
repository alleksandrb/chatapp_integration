<?php

use App\Models\LogMessage;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// })->name('main');

Route::get('/status', function () {
    $text = Message::latest()->get()->value('text');
    $status = LogMessage::where('message', $text)->get();
    return view('status', compact('status'));
})->name('status')->middleware('base');

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('base');
Route::get('/goout', function () {
    return view('goout');
})->name('go.out');
