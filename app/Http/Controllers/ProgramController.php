<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = Program::select('id', 'program_name', 'description',  'slug', 'type')->get();
        return Inertia::render('programs/index', [
            'programs' => $programs,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
        return Inertia::render('programs/show', [
            'program' => [
            'id' => $program->id,
            'name' => $program->program_name,
            'slug' => $program->slug,
            'description' => $program->description,
            'type' => $program->type,
            ],
        ]);
    }

}
