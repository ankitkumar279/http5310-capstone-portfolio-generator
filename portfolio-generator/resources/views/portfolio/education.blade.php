@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Add Education - {{ $portfolio->title ?? 'Untitled Portfolio' }}</h1>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Education Form -->
    <form action="{{ route('education.store', $portfolio->id) }}" method="POST">
        @csrf

        <div class="mb-4">
            <label>Institution Name</label>
            <input type="text" name="institution_name" class="border p-2 w-full" value="{{ old('institution_name') }}">
            @error('institution_name') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label>Degree / Program</label>
            <input type="text" name="degree" class="border p-2 w-full" value="{{ old('degree') }}">
            @error('degree') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label>Start Date</label>
            <input type="date" name="start_date" class="border p-2 w-full" value="{{ old('start_date') }}">
            @error('start_date') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label>End Date (optional)</label>
            <input type="date" name="end_date" class="border p-2 w-full" value="{{ old('end_date') }}">
            @error('end_date') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Buttons -->
        <div class="flex gap-2">
            <!-- Save button -->
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                Add Education
            </button>

            <!-- Next button -->
            <a href="{{ route('experience.index', $portfolio->id) }}" 
               class="bg-green-500 text-white px-4 py-2 rounded">
                Next: Add Work Experience
            </a>
        </div>
    </form>

    <!-- Existing Education Entries -->
    <h2 class="text-xl font-semibold mt-6">Existing Education Entries</h2>
    <ul>
        @forelse($educations as $edu)
            <li class="border p-2 my-2">
                {{ $edu->degree }} at {{ $edu->institution_name }} 
                ({{ $edu->start_date }} - {{ $edu->end_date ?? 'Present' }})
            </li>
        @empty
            <li>No education added yet.</li>
        @endforelse
    </ul>
</div>
@endsection
