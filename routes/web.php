<?php

use App\Http\Livewire\Home;
use App\Http\Livewire\Login;
use Illuminate\Http\Request;
use App\Http\Livewire\Register;
use App\Http\Livewire\SeatPicker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmation;

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
    Route::get('/seat-picker', SeatPicker::class)->name('seat-picker');
});

Route::get('/', Home::class)->name('home');

Route::middleware(['admin'])->group(function() {
    Lean::routes([
        'home' => '/admin/p/tableLayout',
    ]);
});


Route::get('/logout', function(Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/register');
})->name('logout');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/seat-picker');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Email byl odeslán!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/order/verify/{id}/{hash}', function (Request $request, $id) {
    $order = $request->user()->orders()->findOrFail($id);
    if($order->state_id !== 1){
        abort(403);
    }

    $order->state_id = 2;
    $order->save();
    return redirect('/seat-picker')->with('order_verified', 'Objednávka úspěšně potvrzena.');
})->middleware(['auth', 'signed'])->name('order.verify');