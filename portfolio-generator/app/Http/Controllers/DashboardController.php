<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch user's portfolios
        $drafts = Portfolio::where('user_id', $user->id)->where('status', 'draft')->get();
        $online = Portfolio::where('user_id', $user->id)->where('status', 'online')->get();

        return view('dashboard', compact('drafts', 'online'));
    }
}
