@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">
        Add Work Experience - {{ $portfolio->title ?? 'Untitled Portfolio' }}
    </h1>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Work Experience Form -->
    <form action="{{ route('experience.store', $portfolio->id) }}" method="POST">
        @csrf

        <div class="mb-4">
            <label>Company Name</label>
            <input type="text" name="company_name" class="border p-2 w-full"
                   value="{{ old('company_name') }}">
            @error('company_name') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label>Job Title / Position</label>
            <input type="text" name="position" class="border p-2 w-full"
                   value="{{ old('position') }}">
            @error('position') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label>Start Date</label>
            <input type="date" name="start_date" class="border p-2 w-full"
                   value="{{ old('start_date') }}">
            @error('start_date') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label>End Date (optional)</label>
            <input type="date" name="end_date" class="border p-2 w-full"
                   value="{{ old('end_date') }}">
            @error('end_date') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label>Responsibilities / Description</label>
            <textarea name="description" class="border p-2 w-full">{{ old('description') }}</textarea>
            @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Buttons -->
        <div class="flex gap-2">
            <!-- Save button -->
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                Add Work Experience
            </button>

            <!-- Next button (Skills page – just navigation) -->
            <!--  -->
        </div>
    </form>

    <!-- Existing Work Experience -->
    <h2 class="text-xl font-semibold mt-6">Existing Work Experience</h2>
    <ul>
        @forelse($experiences as $exp)
            <li class="border p-2 my-2">
                <strong>{{ $exp->position }}</strong> at {{ $exp->company_name }}
                <br>
                ({{ $exp->start_date }} - {{ $exp->end_date ?? 'Present' }})
                @if($exp->description)
                    <p class="text-sm text-gray-600 mt-1">{{ $exp->description }}</p>
                @endif
            </li>
        @empty
            <li>No work experience added yet.</li>
        @endforelse
    </ul>
</div>
@endsection
