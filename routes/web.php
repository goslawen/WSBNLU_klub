<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventMemberController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\WeaponController;
use App\Http\Controllers\WeaponTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('members', MemberController::class);
Route::resource('weapon-types', WeaponTypeController::class);
Route::resource('weapons', WeaponController::class);
Route::resource('events', EventController::class);
Route::resource('fees', FeeController::class);

Route::post('/events/{event}/members', [EventMemberController::class, 'store'])->name('events.members.store');
Route::delete('/events/{event}/members/{member}', [EventMemberController::class, 'destroy'])->name('events.members.destroy');

Route::patch('/members/{member}/deactivate', [MemberController::class, 'deactivate'])->name('members.deactivate');
Route::patch('/weapons/{weapon}/deactivate', [WeaponController::class, 'deactivate'])->name('weapons.deactivate');
Route::patch('/fees/{fee}/mark-paid', [FeeController::class, 'markPaid'])->name('fees.mark-paid');