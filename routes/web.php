<?php

use Inertia\Inertia;
use App\Models\Program;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProjectController;


Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard',[
//         'programs'=>$programs,
//     ]);
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/dashboard', function () {
    $programs = Cache::remember('programs_list', now()->addHours(6), function () {
        return Program::select('id', 'program_name', 'description', 'slug', 'type')
            ->orderBy('program_name')
            ->get();
    });

    return Inertia::render('Dashboard', [
        'programs' => $programs, // ✅ Must be passed here
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


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


Route::resource('programs', ProgramController::class)->only(['index', 'show']);
Route::resource('projects', ProjectController::class);



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
