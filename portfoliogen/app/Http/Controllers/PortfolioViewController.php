<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PortfolioViewController extends Controller
{
    public function show(string $username, Portfolio $portfolio)
    {
        if ($portfolio->user_id !== Auth::id()) abort(403);

        $portfolio->load(['educations','experiences','skills','projects','user']);

        $key = $portfolio->template_key;
        if (!in_array($key, ['minimal','developer','designer','business'])) {
            $key = 'minimal';
        }

        return view("templates.$key", compact('portfolio'));
    }

    public function publicShow(string $username, string $public_id)
{
    $portfolio = Portfolio::query()
        ->whereHas('user', function ($q) use ($username) {
            $q->where('username', $username);
        })
        ->where('public_id', $public_id)
        ->where('status', 'published')
        ->whereNotNull('published_at')
        ->with(['educations','experiences','skills','projects','user'])
        ->firstOrFail();

    $key = $portfolio->template_key;
    if (!in_array($key, ['minimal','developer','designer','business'])) {
        $key = 'minimal';
    }

    return view("templates.$key", compact('portfolio'));
}
}