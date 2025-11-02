<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        // Guests can only *view* public program data (read-only)
        $programs = Program::select('id', 'program_name as name', 'description')
            ->orderBy('id')
            ->get();

        return Inertia::render('Guest', [
            'programs' => $programs,
        ]);
    }
}
