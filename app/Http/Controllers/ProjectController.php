<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Program;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{

    public function index(Request $request)
    {
        $programId = $request->query('program');
        $program = null;

        // 🧠 Base query
        $query = Project::with('program')
            ->select(
                'id',
                'program_id',
                'user_id',
                'title',
                'description',
                'location',
                'status',
                'budget',
                'start_date',
                'end_date',
                'project_leader',
                'contact_email'
            )
            ->orderByDesc('start_date');

        // 🧠 Optional filtering by program
        if ($programId) {
            $query->where('program_id', $programId);
            $program = Program::find($programId);
        }

        $projects = $query->get();

        // 🧠 Return Inertia page
        return Inertia::render('projects/index', [
            'program'  => $program,
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        $programs = Program::select('id', 'program_name')->get();

        return Inertia::render('projects/create', [
            'programs' => $programs,
        ]);
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id'      => 'required|exists:programs,id',
            'user_id'         => 'required|integer',
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'location'        => 'required|string|max:255',
            'status'          => 'required|string|max:50',
            'budget'          => 'required|numeric|min:0',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'project_leader'  => 'required|string|max:255',
            'contact_email'   => 'required|email|max:255',
        ]);

        Project::create($validated);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        $project->load('program');

        return Inertia::render('projects/show', [
            'project' => $project,
            'program' => $project->program,
        ]);
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        $programs = Program::select('id', 'program_name')->get();

        return Inertia::render('projects/edit', [
            'project'  => $project,
            'programs' => $programs,
        ]);
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'program_id'      => 'required|exists:programs,id',
            'user_id'         => 'required|integer',
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'location'        => 'required|string|max:255',
            'status'          => 'required|string|max:50',
            'budget'          => 'required|numeric|min:0',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'project_leader'  => 'required|string|max:255',
            'contact_email'   => 'required|email|max:255',
        ]);

        $project->update($validated);

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }

}
