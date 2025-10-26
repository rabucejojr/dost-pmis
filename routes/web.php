<?php

use Inertia\Inertia;
use App\Models\Program;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AccomplishmentController;
use App\Http\Controllers\PhysicalAccomplishmentController;
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
})
    ->middleware(['auth', 'role:Admin'])
    ->name('dashboard');

Route::get('/user', fn() => Inertia::render('User'))
    ->middleware(['auth', 'role:User'])
    ->name('user');

Route::get('/guest', fn() => Inertia::render('Guest'))
    ->middleware(['auth', 'role:Guest'])
    ->name('guest');

Route::middleware(['auth'])->group(function () {
    // ==============================
    // ADMIN ROUTES
    // ==============================
    Route::middleware(['role:Admin'])->group(function () {
        // Programs
        Route::resource('programs', ProgramController::class);

        // Projects
        Route::resource('projects', ProjectController::class);

        // Projects: Soft delete management
        Route::prefix('projects')->name('projects.')->group(function () {
            Route::get('projects/trashed', [ProjectController::class, 'trashed'])->name('trashed');
            Route::put('/{id}/restore', [ProjectController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete', [ProjectController::class, 'forceDelete'])->name('forceDelete');
        });

        // Financial Accomplishments
        Route::prefix('financial')->name('financial.')->group(function () {
            Route::get('/', [AccomplishmentController::class, 'index'])->name('index');
            Route::get('/create', [AccomplishmentController::class, 'create'])->name('create');
            Route::post('/', [AccomplishmentController::class, 'store'])->name('store');
            Route::get('/{financial}', [AccomplishmentController::class, 'show'])->name('show');
            Route::get('/{financial}/edit', [AccomplishmentController::class, 'edit'])->name('edit');
            Route::put('/{financial}', [AccomplishmentController::class, 'update'])->name('update');
            Route::delete('/{financial}', [AccomplishmentController::class, 'destroy'])->name('destroy');
        });
        // Physical Accomplishments
        Route::resource('physical', PhysicalAccomplishmentController::class);
    });

    // ==============================
    // 👤 USER ROUTES
    // ==============================
    Route::middleware(['role:User'])->group(function () {
        Route::get('/user', [UserDashboardController::class, 'index'])->name('user');
    });

    // ==============================
    // GUEST ROUTES
    // ==============================
    Route::middleware(['role:Guest'])->group(function () {
        Route::get('/guest', [GuestDashboardController::class, 'index'])->name('guest');
    });
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
