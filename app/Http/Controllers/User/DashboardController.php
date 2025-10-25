<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Response;
use App\Models\Program;
use Inertia\Inertia;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
        {
            // Fetch all programs with their related projects
            // Keeping it minimal, only fetching necessary fields
            $programs = Program::with(['projects' => function ($query) {
                $query->select('id', 'program_id', 'title', 'status', 'budget', 'description');
            }])
                ->orderBy('id')
                ->get(['id', 'program_name', 'description']);

            // Render the User Dashboard page with the data
            return Inertia::render('User', [
                'programs' => $programs,
            ]);
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
