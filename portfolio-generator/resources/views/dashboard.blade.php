@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Welcome Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Welcome, {{ Auth::user()->name }} 👋
            </h1>
            <p class="text-gray-500 mt-1">
                Manage and publish your portfolios from one place
            </p>
        </div>

        <a href="{{ route('portfolio.create') }}"
   class="mt-4 sm:mt-0 inline-flex items-center bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-5 py-2.5 rounded-lg shadow transition">
    + Create New Portfolio
</a>

    </div>

    {{-- Draft Portfolios --}}
    <div class="mb-10">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            Draft Portfolios
        </h2>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($drafts as $draft)
                <div class="bg-white rounded-xl shadow-sm border p-5 flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold text-gray-700">
                            {{ $draft->title ?? 'Untitled Portfolio' }}
                        </h3>
                        <span class="text-sm text-gray-500">Draft</span>
                    </div>

                    <a href="{{ route('portfolio.edit', $draft->id) }}"
                       class="text-blue-600 hover:text-blue-800 font-medium">
                        Edit →
                    </a>
                </div>
            @empty
                <div class="col-span-full text-gray-500">
                    No draft portfolios yet.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Online Portfolios --}}
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            Online Portfolios
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($online as $portfolio)
                <div class="bg-white rounded-xl shadow-sm border p-5 flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold text-gray-700">
                            {{ $portfolio->title ?? 'Untitled Portfolio' }}
                        </h3>
                        <span class="text-sm text-green-600">Published</span>
                    </div>

                    <a href="#"
                       class="text-green-600 hover:text-green-800 font-medium">
                        View →
                    </a>
                </div>
            @empty
                <div class="col-span-full text-gray-500">
                    No online portfolios yet.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
