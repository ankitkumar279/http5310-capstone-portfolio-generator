@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Portfolio - {{ $portfolio->title ?? 'Untitled Portfolio' }}</h1>

    <form action="{{ route('portfolio.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Profile Photo -->
        <div class="mb-4">
            <label class="block mb-1">Profile Photo</label>
            <input type="file" name="profile_photo" accept="image/*" class="border p-2 w-full">
            @if($portfolio->profile_photo)
                <img src="{{ asset('storage/' . $portfolio->profile_photo) }}" alt="Profile Photo" class="w-20 h-20 mt-2">
            @endif
            @error('profile_photo') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Full Name -->
        <div class="mb-4">
            <label>Full Name</label>
            <input type="text" name="full_name" class="border p-2 w-full" value="{{ old('full_name', $portfolio->full_name) }}">
            @error('full_name') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Title -->
        <div class="mb-4">
            <label>Title / Designation</label>
            <input type="text" name="title" class="border p-2 w-full" value="{{ old('title', $portfolio->title) }}">
            @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Short Bio -->
        <div class="mb-4">
            <label>Short Bio</label>
            <textarea name="short_bio" class="border p-2 w-full">{{ old('short_bio', $portfolio->short_bio) }}</textarea>
            @error('short_bio') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Location -->
        <div class="mb-4">
            <label>Location</label>
            <input type="text" name="location" class="border p-2 w-full" value="{{ old('location', $portfolio->location) }}">
            @error('location') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Social Links -->
        <div class="mb-4">
            <label>GitHub Link</label>
            <input type="url" name="github_link" class="border p-2 w-full" value="{{ old('github_link', $portfolio->github_link) }}">
        </div>

        <div class="mb-4">
            <label>LinkedIn Link</label>
            <input type="url" name="linkedin_link" class="border p-2 w-full" value="{{ old('linkedin_link', $portfolio->linkedin_link) }}">
        </div>

        <div class="mb-4">
            <label>Twitter Link</label>
            <input type="url" name="twitter_link" class="border p-2 w-full" value="{{ old('twitter_link', $portfolio->twitter_link) }}">
        </div>

        <!-- Save & Next Buttons -->
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            Save Personal Info
        </button>

        <a href="{{ route('education.index', $portfolio->id) }}" 
           class="bg-green-500 text-white px-4 py-2 rounded ml-2">
            Next: Add Education
        </a>
    </form>
</div>
@endsection
