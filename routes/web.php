<?php

use Inertia\Inertia;
use App\Models\Program;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Guest\DashboardController as GuestDashboardController;



Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');


Route::get('/dashboard', function () {
    $programs = Cache::remember('programs_list', now()->addHours(6), function () {
        return Program::select('id', 'program_name', 'description', 'slug', 'type')
            ->orderBy('program_name')
            ->get();
    });

    return Inertia::render('Dashboard', [
        'programs' => $programs,
    ]);
})  ->middleware(['auth', 'role:Admin'])
    ->name('dashboard');

Route::get('/user', fn() => Inertia::render('User'))
    ->middleware(['auth', 'role:User'])
    ->name('user');

Route::get('/guest', fn() => Inertia::render('Guest'))
    ->middleware(['auth', 'role:Guest'])
    ->name('guest');


Route::middleware(['auth'])->group(function () {
    // Admin Routes
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('programs', ProgramController::class);
        Route::resource('projects', ProjectController::class);

        // 🗑️ Extra routes for soft delete management (Projects)
        Route::prefix('projects')->name('projects.')->group(function () {
        // View trashed (soft-deleted) projects
        Route::get('/trashed', [ProjectController::class, 'trashed'])->name('trashed');

        // Restore a soft-deleted project
        Route::put('/{id}/restore', [ProjectController::class, 'restore'])->name('restore');

        // Permanently delete a soft-deleted project
        Route::delete('/{id}/force-delete', [ProjectController::class, 'forceDelete'])->name('forceDelete');
    });

    });

    // User Routes
    Route::middleware(['role:User'])->group(function () {
        Route::get('/user', [UserDashboardController::class, 'index'])->name('user');
    });

    // Guest Routes (Authenticated Guest Account)
    Route::middleware(['role:Guest'])->group(function () {
        Route::get('/guest', [GuestDashboardController::class, 'index'])->name('guest');
    });
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
