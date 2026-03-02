<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $total = Portfolio::where('user_id', $userId)->count();
        $published = Portfolio::where('user_id', $userId)->where('status', 'published')->count();
        $draft = Portfolio::where('user_id', $userId)->where('status', 'draft')->count();

        $recent = Portfolio::where('user_id', $userId)->latest()->take(10)->get();

        return view('dashboard', compact('total', 'published', 'draft', 'recent'));
    }

    public function published(string $username)
    {
        $publishedList = Portfolio::query()
            ->where('user_id', Auth::id())
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->get();

        return view('dashboard.published', [
            'publishedList' => $publishedList,
        ]);
    }
}