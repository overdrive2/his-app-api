<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth:sanctum'])->prefix('nurse')->group(function () {
    Route::get('/', [App\Http\Livewire\NurseModule\NurseIpdList::class, '__invoke'])->name('nurse.ipdlist');
    Route::get('newcase', [App\Http\Livewire\NurseModule\NurseIpdNewcaseList::class, '__invoke'])->name('nurse.newcase');
    Route::get('ipd-asm-entry', [App\Http\Livewire\NurseModule\NurseIpdAsmEntry::class, '__invoke'])->name('nurse.asm.entry');
    Route::get('ipd-bedmove', [App\Http\Livewire\NurseModule\IpdBedMoveList::class, '__invoke'])->name('nurse.ipd.bedmove.list');
});

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('user', [App\Http\Livewire\Admin\Users::class, '__invoke'])->name('admin.user');
    Route::get('user-profile', [App\Http\Livewire\Admin\UserProfile::class, '__invoke'])->name('admin.user-profile');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
