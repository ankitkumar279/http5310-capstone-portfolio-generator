<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    // Show personal info form
    public function create()
    {
        return view('portfolio.create');
    }

    // Store portfolio info
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'short_bio' => 'required|string',
            'location' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'github_link' => 'nullable|url',
            'linkedin_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            'template_choice' => 'required|string',
        ]);

        $portfolio = new Portfolio();
        $portfolio->user_id = Auth::id();
        $portfolio->full_name = $request->full_name;
        $portfolio->title = $request->title;
        $portfolio->short_bio = $request->short_bio;
        $portfolio->location = $request->location;
        $portfolio->github_link = $request->github_link;
        $portfolio->linkedin_link = $request->linkedin_link;
        $portfolio->twitter_link = $request->twitter_link;
        $portfolio->template_choice = $request->template_choice;

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $portfolio->profile_photo = $path;
        }

        $portfolio->status = 'draft';
        $portfolio->save();

        return redirect()->route('dashboard')->with('success', 'Portfolio created successfully!');
    }

    public function edit(Portfolio $portfolio)
{
    // Ensure user owns the portfolio
    if ($portfolio->user_id != auth()->id()) {
        abort(403);
    }

    return view('portfolio.edit', compact('portfolio'));
}

public function update(Request $request, Portfolio $portfolio)
{
    // Ensure user owns the portfolio
    if ($portfolio->user_id != auth()->id()) {
        abort(403);
    }

    $request->validate([
        'full_name' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'short_bio' => 'required|string',
        'location' => 'nullable|string|max:255',
        'github_link' => 'nullable|url',
        'linkedin_link' => 'nullable|url',
        'twitter_link' => 'nullable|url',
        'template_choice' => 'required|string',
    ]);

    $portfolio->update($request->all());

    return redirect()->route('education.index', $portfolio->id)
                 ->with('success', 'Personal info saved! Now add your education.');

}

}
