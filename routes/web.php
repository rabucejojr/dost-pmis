<?php

use Inertia\Inertia;
use App\Models\Program;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\ProgramController;

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

Route::resource('programs', ProgramController::class)->only(['index', 'show']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
