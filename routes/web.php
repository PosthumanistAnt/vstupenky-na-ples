<?php

use App\Mail\JustTesting;
use Illuminate\Http\Request;
use App\Http\Livewire\Login;
use App\Http\Livewire\Register;
use App\Http\Livewire\SeatPicker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


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

Route::middleware(['guest'])->group(function() {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/', SeatPicker::class);
});

Route::middleware(['admin'])->group(function() {
    Lean::routes([
        'home' => '/admin/p/home',
    ]);
});


Route::get('/logout', function(Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/register');
})->name('logout');

Route::get('/send-mail', function () {
    Mail::to('newuser@example.com')->send(new JustTesting()); 
    return 'A message has been sent to Mailtrap!';
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Email byl odeslán!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');