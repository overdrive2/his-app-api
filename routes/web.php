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
    return redirect('nurse');
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
    Route::get('/', [App\Http\Livewire\NurseModule\Index::class, '__invoke'])->name('nurse.index');
    Route::get('newcase', [App\Http\Livewire\NurseModule\NurseIpdNewcaseList::class, '__invoke'])->name('nurse.newcase');
    Route::get('ipd-asm-entry', [App\Http\Livewire\NurseModule\NurseIpdAsmEntry::class, '__invoke'])->name('nurse.asm.entry');
    Route::get('ipd-asm-list', [App\Http\Livewire\NurseModule\IpdAsmList::class, '__invoke'])->name('nurse.asm.list');
    Route::get('ipd-bedmove', [App\Http\Livewire\NurseModule\IpdBedMoveList::class, '__invoke'])->name('nurse.ipd.bedmove.list');
});

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [App\Http\Livewire\Admin\Index::class, '__invoke'])->name('admin.index');
    Route::get('user', [App\Http\Livewire\Admin\Users::class, '__invoke'])->name('admin.user');
    Route::get('user-profile', [App\Http\Livewire\Admin\UserProfile::class, '__invoke'])->name('admin.user-profile');
    Route::get('asm-list', [App\Http\Livewire\Admin\AsmList::class, '__invoke'])->name('admin.asm-list');
    Route::get('asm-form', [App\Http\Livewire\Admin\AsmForm::class, '__invoke'])->name('admin.asm-form');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('test', [App\Http\Livewire\Test\Test::class, '__invoke']);

Route::middleware(['auth:sanctum'])->prefix('occuins')->group(function () {
    Route::get('/home', [App\Http\Livewire\OccuInspector\Home::class, '__invoke'])->name('occu.ins');
    Route::get('/detail', [App\Http\Livewire\OccuInspector\Detail::class, '__invoke'])->name('occu.ins.detail');
});

Route::middleware(['auth:sanctum'])->prefix('occuipd')->group(function () {
    Route::get('/home', [App\Http\Livewire\OccuIpd\Home::class, '__invoke'])->name('occu.ipd');
    Route::get('/detail', [App\Http\Livewire\OccuIpd\Detail::class, '__invoke'])->name('occu.ipd.detail');
});
