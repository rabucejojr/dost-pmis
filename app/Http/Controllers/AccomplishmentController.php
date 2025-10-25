<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Accomplishment;

class AccomplishmentController extends Controller
{
    /**
     * Display a listing of the financial accomplishments.
     */
    // public function index()
    // {
    //     $accomplishments = Accomplishment::latest()->get();

    //     return Inertia::render('accomplishments/financial/index', [
    //         'accomplishments' => $accomplishments
    //     ]);
    // }

     public function index(Request $request)
    {
        // ✅ Allow search and filtering if needed
        $search = $request->input('search');

        $accomplishments = Accomplishment::query()
            ->when($search, function ($query, $search) {
                $query->where('project_title', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%")
                      ->orWhere('implementing_year', 'like', "%{$search}%");
            })
            ->orderBy('implementing_year', 'desc')
            ->paginate(10) // ✅ 10 per page
            ->appends($request->query()); // preserves filters on pagination links

        // ✅ For Inertia.js page
        return Inertia::render('accomplishments/financial/index', [
            'accomplishments' => $accomplishments,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    /**
     * Show the form for creating a new financial accomplishment.
     */
    public function create()
    {
        return Inertia::render('accomplishments/financial/create');
    }

    /**
     * Store a newly created record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_title' => 'required|string|max:255',
            'implementing_year' => 'required|integer',
            'budget_utilized' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);

        Accomplishment::create($validated);

        return redirect()
            ->route('financial.index')
            ->with('success', '✅ Financial accomplishment added successfully.');
    }

    /**
     * Display a specific accomplishment.
     */
    public function show(Accomplishment $financial)
    {
        return Inertia::render('accomplishments/financial/show', [
            'accomplishment' => $financial
        ]);
    }

    /**
     * Edit an existing record.
     */
    public function edit(Accomplishment $financial)
    {
        return Inertia::render('accomplishments/financial/edit', [
            'accomplishment' => $financial
        ]);
    }

    /**
     * Update the specified record.
     */
    public function update(Request $request, Accomplishment $financial)
    {
        $validated = $request->validate([
            'project_title' => 'required|string|max:255',
            'implementing_year' => 'required|integer',
            'budget_utilized' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);

        $financial->update($validated);

        return redirect()
            ->route('financial.index')
            ->with('success', '✅ Financial accomplishment updated successfully.');
    }

    /**
     * Remove the specified record.
     */
    public function destroy(Accomplishment $financial)
    {
        $financial->delete();

        return redirect()
            ->route('financial.index')
            ->with('success', '🗑️ Financial accomplishment deleted successfully.');
    }
}
