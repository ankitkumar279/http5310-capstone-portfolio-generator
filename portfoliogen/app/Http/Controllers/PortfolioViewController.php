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

        $portfolio->load(['educations','experiences','skills','projects']);

        $key = $portfolio->template_key;
        if (!in_array($key, ['minimal','developer','designer','business'])) {
            $key = 'minimal';
        }

        return view("templates.$key", compact('portfolio'));
    }

    public function publicShow(string $username, Portfolio $portfolio)
    {
        $user = User::where('username', $username)->firstOrFail();
        abort_unless($portfolio->user_id === $user->id, 404);

        $portfolio->load(['educations','experiences','skills','projects']);

        $key = $portfolio->template_key;
        if (!in_array($key, ['minimal','developer','designer','business'])) {
            $key = 'minimal';
        }

        return view("templates.$key", compact('portfolio'));
    }
}