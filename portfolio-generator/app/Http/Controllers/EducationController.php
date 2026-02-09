<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Education;
use App\Models\Portfolio;

class EducationController extends Controller
{
    // Show all education entries for a portfolio
    public function index(Portfolio $portfolio)
    {
        $educations = $portfolio->educations; // fetch all education entries
        return view('portfolio.education', compact('portfolio', 'educations'));
    }

    // Store a new education entry
    public function store(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'institution_name' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Education::create([
            'portfolio_id' => $portfolio->id,
            'institution_name' => $request->institution_name,
            'degree' => $request->degree,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('education.index', $portfolio->id)
                         ->with('success', 'Education added!');
    }
}
