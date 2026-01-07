<?php

use App\Http\Controllers\MenuCategoryController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TableAreaController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'outlet.access'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Menu & Table Management Routes
Route::middleware(['auth', 'verified', 'outlet.access'])->group(function () {
    // Menu Categories
    Route::resource('menu-categories', MenuCategoryController::class)->except(['show']);
    Route::post('menu-categories/reorder', [MenuCategoryController::class, 'reorder'])->name('menu-categories.reorder');

    // Menu Items
    Route::resource('menu-items', MenuItemController::class)->except(['show']);
    Route::post('menu-items/{menuItem}/toggle-availability', [MenuItemController::class, 'toggleAvailability'])
        ->name('menu-items.toggle-availability');

    // Table Areas
    Route::resource('table-areas', TableAreaController::class)->except(['show']);

    // Tables
    Route::resource('tables', TableController::class)->except(['show']);
    Route::post('tables/{table}/status', [TableController::class, 'updateStatus'])->name('tables.update-status');
    Route::post('tables/{table}/regenerate-qr', [TableController::class, 'regenerateQr'])->name('tables.regenerate-qr');
    Route::get('tables/{table}/download-qr', [TableController::class, 'downloadQr'])->name('tables.download-qr');
});

require __DIR__.'/auth.php';
