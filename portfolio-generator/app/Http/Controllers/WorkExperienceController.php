<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Models\WorkExperience;

class WorkExperienceController extends Controller
{
    public function index(Portfolio $portfolio)
    {
        $experiences = $portfolio->workExperiences; // Make sure Portfolio model has: workExperiences() relationship
        return view('portfolio.experience', compact('portfolio', 'experiences'));
    }

    public function store(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255', // must match input name
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        WorkExperience::create([
            'portfolio_id' => $portfolio->id,
            'company_name' => $request->company_name,
            'position' => $request->position, // match input name
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
        ]);

        return redirect()->route('experience.index', $portfolio->id)
                         ->with('success', 'Work experience added!');
    }
}
