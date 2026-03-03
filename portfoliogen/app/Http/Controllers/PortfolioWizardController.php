<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Project;

class PortfolioWizardController extends Controller
{
    public function chooseTemplate(string $username)
    {
        return view('portfolio.choose-template');
    }

    public function storeTemplate(Request $request, string $username)
    {
        $request->validate([
            'template_key' => 'required|in:minimal,developer,designer,business',
        ]);

        $portfolio = Portfolio::create([
            'user_id'       => Auth::id(),
            'template_key'  => $request->template_key,
            'status'        => 'draft',
            'current_step'  => 1,
        ]);

        return redirect()->route('portfolio.step', [
            'username'  => $this->u(),
            'portfolio' => $portfolio->id,
            'step'      => 1,
        ]);
    }

    public function showStep(Request $request, string $username, Portfolio $portfolio, int $step)
    {
        $this->authorizeOwner($portfolio);

        if ($step > $portfolio->current_step) {
            return redirect()->route('portfolio.step', [
                'username'  => $this->u(),
                'portfolio' => $portfolio->id,
                'step'      => $portfolio->current_step,
            ])->with('error', 'Please complete previous steps first.');
        }

        return view("portfolio.steps.step{$step}", [
            'portfolio' => $portfolio->load(['educations', 'experiences', 'skills', 'projects']),
            'step'      => $step,
            'maxStep'   => $portfolio->current_step,
        ]);
    }

    // ----------------------------
    // DELETE ITEMS
    // ----------------------------

    public function deleteEducation(string $username, Portfolio $portfolio, Education $education)
    {
        $this->authorizeOwner($portfolio);
        if ((string) $education->portfolio_id !== (string) $portfolio->id) abort(403);

        $education->delete();
        return back()->with('success', 'Education deleted.');
    }

    public function deleteExperience(string $username, Portfolio $portfolio, Experience $experience)
    {
        $this->authorizeOwner($portfolio);
        if ((string) $experience->portfolio_id !== (string) $portfolio->id) abort(403);

        $experience->delete();
        return back()->with('success', 'Experience deleted.');
    }

    public function deleteSkill(string $username, Portfolio $portfolio, Skill $skill)
    {
        $this->authorizeOwner($portfolio);
        if ((string) $skill->portfolio_id !== (string) $portfolio->id) abort(403);

        $skill->delete();
        return back()->with('success', 'Skill deleted.');
    }

    public function deleteProject(string $username, Portfolio $portfolio, Project $project)
    {
        $this->authorizeOwner($portfolio);
        if ((string) $project->portfolio_id !== (string) $portfolio->id) abort(403);

        // NOTE:
        // Projects image_path can now be Cloudinary URLs, so do NOT delete from Storage disk here.
        // (If you later want to delete from Cloudinary by public_id, we can add that.)
        $project->delete();

        return back()->with('success', 'Project deleted.');
    }

    // ----------------------------
    // UPDATE ITEMS
    // ----------------------------

    public function updateEducation(Request $request, string $username, Portfolio $portfolio, Education $education)
    {
        $this->authorizeOwner($portfolio);
        if ((string) $education->portfolio_id !== (string) $portfolio->id) abort(403);

        $data = $request->validate([
            'institution_name' => ['required', 'string', 'max:255'],
            'degree'           => ['required', 'string', 'max:255'],
            'start_date'       => ['nullable', 'date'],
            'end_date'         => ['nullable', 'date'],
        ]);

        $education->update($data);
        return back()->with('success', 'Education updated.');
    }

    public function updateExperience(Request $request, string $username, Portfolio $portfolio, Experience $experience)
    {
        $this->authorizeOwner($portfolio);
        if ((string) $experience->portfolio_id !== (string) $portfolio->id) abort(403);

        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'role'         => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:2000'],
            'start_date'   => ['nullable', 'date'],
            'end_date'     => ['nullable', 'date'],
        ]);

        $experience->update($data);
        return back()->with('success', 'Experience updated.');
    }

    public function updateSkill(Request $request, string $username, Portfolio $portfolio, Skill $skill)
    {
        $this->authorizeOwner($portfolio);
        if ((string) $skill->portfolio_id !== (string) $portfolio->id) abort(403);

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'level' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $skill->update($data);
        return back()->with('success', 'Skill updated.');
    }

    public function updateProject(Request $request, string $username, Portfolio $portfolio, Project $project)
    {
        $this->authorizeOwner($portfolio);
        if ((string) $project->portfolio_id !== (string) $portfolio->id) abort(403);

        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'live_url'    => ['nullable', 'url', 'max:255'],
            'github_url'  => ['nullable', 'url', 'max:255'],
            'image'       => ['nullable', 'image', 'max:4096'],
        ]);

        // ✅ Cloudinary upload (helper)
        $imageUrl = $this->uploadProjectImageToCloudinary($request, $username, $portfolio);
        if ($imageUrl) {
            $data['image_path'] = $imageUrl;
        }

        $project->update($data);
        return back()->with('success', 'Project updated.');
    }

    // ----------------------------
    // PORTFOLIO ACTIONS
    // ----------------------------

    public function saveDraft(string $username, Portfolio $portfolio)
    {
        $this->authorizeOwner($portfolio);

        $portfolio->update([
            'status'       => 'draft',
            'published_at' => null,
        ]);

        return redirect()->route('dashboard', [
            'username' => $this->u(),
        ])->with('success', 'Portfolio saved as draft.');
    }

    public function publish(string $username, Portfolio $portfolio)
    {
        $this->authorizeOwner($portfolio);

        if (empty($portfolio->public_id)) {
            $portfolio->public_id = Str::random(16);
            while (Portfolio::where('public_id', $portfolio->public_id)->exists()) {
                $portfolio->public_id = Str::random(16);
            }
        }

        $portfolio->status = 'published';
        $portfolio->published_at = now();
        $portfolio->save();

        // If your templates show session('public_url'), you can also set it here if you want:
        // $publicUrl = route('portfolio.public.view', ['username' => $this->u(), 'public_id' => $portfolio->public_id]);
        // return redirect()->route('dashboard.published', ['username' => $this->u()])->with('success', 'Portfolio published!')->with('public_url', $publicUrl);

        return redirect()->route('dashboard.published', [
            'username' => $this->u(),
        ])->with('success', 'Portfolio published! Your public link is now live.');
    }

    public function unpublish(string $username, Portfolio $portfolio)
    {
        $this->authorizeOwner($portfolio);

        $portfolio->update([
            'status'       => 'draft',
            'published_at' => null,
        ]);

        return back()->with('success', 'Portfolio moved to draft.');
    }

    public function destroy(string $username, Portfolio $portfolio)
    {
        $this->authorizeOwner($portfolio);

        $portfolio->load(['projects']);

        DB::transaction(function () use ($portfolio) {

            // ✅ photo_path is local in your app (public disk)
            if ($portfolio->photo_path) {
                Storage::disk('public')->delete($portfolio->photo_path);
            }

            // ✅ projects images might be Cloudinary URLs, so no local delete
            $portfolio->educations()->delete();
            $portfolio->experiences()->delete();
            $portfolio->skills()->delete();
            $portfolio->projects()->delete();

            $portfolio->delete();
        });

        return redirect()->route('dashboard', [
            'username' => $this->u(),
        ])->with('success', 'Portfolio deleted.');
    }

    public function duplicate(string $username, Portfolio $portfolio)
    {
        $this->authorizeOwner($portfolio);

        $portfolio->load(['educations', 'experiences', 'skills', 'projects']);

        $new = DB::transaction(function () use ($portfolio) {

            $copy = Portfolio::create([
                'user_id'       => auth()->id(),
                'template_key'  => $portfolio->template_key,
                'status'        => 'draft',
                'current_step'  => $portfolio->current_step,

                'full_name'     => $portfolio->full_name,
                'job_title'     => $portfolio->job_title,
                'short_bio'     => $portfolio->short_bio,
                'location'      => $portfolio->location,

                'github_url'    => $portfolio->github_url,
                'linkedin_url'  => $portfolio->linkedin_url,
                'twitter_url'   => $portfolio->twitter_url,
                'photo_path'    => null,

                'public_id'     => null,
                'published_at'  => null,
            ]);

            foreach ($portfolio->educations as $e) {
                $copy->educations()->create($e->only([
                    'institution_name', 'degree', 'start_date', 'end_date'
                ]));
            }

            foreach ($portfolio->experiences as $x) {
                $copy->experiences()->create($x->only([
                    'company_name', 'role', 'description', 'start_date', 'end_date'
                ]));
            }

            foreach ($portfolio->skills as $s) {
                $copy->skills()->create($s->only(['name', 'level']));
            }

            foreach ($portfolio->projects as $p) {
                $copy->projects()->create([
                    'title'       => $p->title,
                    'description' => $p->description,
                    'live_url'    => $p->live_url,
                    'github_url'  => $p->github_url,
                    'image_path'  => null, // ✅ keep null for copy
                ]);
            }

            return $copy;
        });

        return redirect()->route('portfolio.step', [
            'username'  => $this->u(),
            'portfolio' => $new->id,
            'step'      => $new->current_step,
        ])->with('success', 'Portfolio duplicated (saved as draft).');
    }

    public function editTemplate(string $username, Portfolio $portfolio)
    {
        $this->authorizeOwner($portfolio);

        return view('portfolio.change-template', [
            'portfolio' => $portfolio
        ]);
    }

    public function updateTemplate(Request $request, string $username, Portfolio $portfolio)
    {
        $this->authorizeOwner($portfolio);

        $data = $request->validate([
            'template_key' => 'required|in:minimal,developer,designer,business'
        ]);

        $portfolio->update([
            'template_key' => $data['template_key']
        ]);

        return redirect()->route('portfolio.owner.view', [
            'username'  => $this->u(),
            'portfolio' => $portfolio->id,
        ])->with('success', 'Template updated.');
    }

    // ----------------------------
    // WIZARD SAVE STEP
    // ----------------------------

    public function saveStep(Request $request, string $username, Portfolio $portfolio, int $step)
    {
        $this->authorizeOwner($portfolio);

        if ($step > $portfolio->current_step) {
            return redirect()->route('portfolio.step', [
                'username'  => $this->u(),
                'portfolio' => $portfolio->id,
                'step'      => $portfolio->current_step,
            ]);
        }

        $isAutosave = $request->boolean('autosave') || $request->query('autosave') == 1;

        // STEP 1
        if ($step === 1) {
            $data = $request->validate([
                'full_name'     => 'required|string|max:120',
                'job_title'     => 'required|string|max:120',
                'short_bio'     => 'required|string|max:1200',
                'location'      => 'required|string|max:120',
                'github_url'    => 'nullable|url|max:255',
                'linkedin_url'  => 'nullable|url|max:255',
                'twitter_url'   => 'nullable|url|max:255',
                'photo'         => 'nullable|image|max:2048',
            ]);

            // NOTE: your profile photo still uses local storage.
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('photos', 'public');
                $data['photo_path'] = $path;
            }

            $portfolio->update($data);

            if ($isAutosave) return response()->json(['ok' => true]);

            $this->advanceStep($portfolio, 2);

            return redirect()->route('portfolio.step', [
                'username'  => $this->u(),
                'portfolio' => $portfolio->id,
                'step'      => 2,
            ]);
        }

        // STEP 2
        if ($step === 2) {
            $action = $request->input('action', 'add');

            if ($action === 'add') {
                $request->validate([
                    'institution_name' => 'required|string|max:180',
                    'degree'           => 'required|string|max:180',
                    'start_date'       => 'required|date',
                    'end_date'         => 'nullable|date',
                ]);

                $portfolio->educations()->create($request->only([
                    'institution_name', 'degree', 'start_date', 'end_date'
                ]));

                if ($isAutosave) return response()->json(['ok' => true]);

                return back()->with('success', 'Education added.');
            }

            if ($portfolio->educations()->count() < 1) {
                return back()->with('error', 'At least one education is required.');
            }

            if ($isAutosave) return response()->json(['ok' => true]);

            $this->advanceStep($portfolio, 3);

            return redirect()->route('portfolio.step', [
                'username'  => $this->u(),
                'portfolio' => $portfolio->id,
                'step'      => 3,
            ]);
        }

        // STEP 3
        if ($step === 3) {
            $action = $request->input('action', 'next');

            if ($action === 'add') {
                $request->validate([
                    'company_name' => 'required|string|max:180',
                    'role'         => 'required|string|max:180',
                    'description'  => 'nullable|string|max:2000',
                    'start_date'   => 'nullable|date',
                    'end_date'     => 'nullable|date',
                ]);

                $portfolio->experiences()->create($request->only([
                    'company_name', 'role', 'description', 'start_date', 'end_date'
                ]));

                if ($isAutosave) return response()->json(['ok' => true]);

                return back()->with('success', 'Experience added.');
            }

            if ($isAutosave) return response()->json(['ok' => true]);

            $this->advanceStep($portfolio, 4);

            return redirect()->route('portfolio.step', [
                'username'  => $this->u(),
                'portfolio' => $portfolio->id,
                'step'      => 4,
            ]);
        }

        // STEP 4
        if ($step === 4) {
            $action = $request->input('action', 'next');

            if ($action === 'add') {
                $request->validate([
                    'name'  => 'required|string|max:80',
                    'level' => 'required|integer|min:0|max:100',
                ]);

                $portfolio->skills()->create($request->only(['name', 'level']));

                if ($isAutosave) return response()->json(['ok' => true]);

                return back()->with('success', 'Skill added.');
            }

            if ($portfolio->skills()->count() < 1) {
                return back()->with('error', 'At least one skill is required.');
            }

            if ($isAutosave) return response()->json(['ok' => true]);

            $this->advanceStep($portfolio, 5);

            return redirect()->route('portfolio.step', [
                'username'  => $this->u(),
                'portfolio' => $portfolio->id,
                'step'      => 5,
            ]);
        }

        // STEP 5 (PROJECTS) ✅ Cloudinary upload here too
        if ($step === 5) {
            $action = $request->input('action', 'next');

            if ($action === 'add') {
                $request->validate([
                    'title'       => 'required|string|max:180',
                    'description' => 'required|string|max:1200',
                    'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
                    'live_url'    => 'nullable|url|max:255',
                    'github_url'  => 'nullable|url|max:255',
                ]);

                $payload = $request->only(['title', 'description', 'live_url', 'github_url']);

                // ✅ Cloudinary upload (helper)
                $imageUrl = $this->uploadProjectImageToCloudinary($request, $username, $portfolio);
                if ($imageUrl) {
                    $payload['image_path'] = $imageUrl;
                }

                $portfolio->projects()->create($payload);

                if ($isAutosave) return response()->json(['ok' => true]);

                return back()->with('success', 'Project added.');
            }

            if ($isAutosave) return response()->json(['ok' => true]);

            $this->advanceStep($portfolio, 6);

            return redirect()->route('portfolio.step', [
                'username'  => $this->u(),
                'portfolio' => $portfolio->id,
                'step'      => 6,
            ]);
        }

        // STEP 6
        if ($step === 6) {
            $portfolio->update(['status' => 'draft']);

            if ($isAutosave) return response()->json(['ok' => true]);

            return redirect()->route('portfolio.owner.view', [
                'username'  => $this->u(),
                'portfolio' => $portfolio->id,
            ]);
        }

        if ($isAutosave) return response()->json(['ok' => true]);

        return back();
    }


    private function uploadProjectImageToCloudinary(Request $request, string $username, Portfolio $portfolio): ?string
{
    if (!$request->hasFile('image')) return null;

    $file = $request->file('image');

    try {
        $result = cloudinary()->uploadApi()->upload(
            $file->getRealPath(),
            [
                'folder'        => "projects/{$username}/{$portfolio->id}",
                'resource_type' => 'image',
            ]
        );

        // Cloudinary SDK returns an array-like response in v3
        return $result['secure_url'] ?? null;

    } catch (\Throwable $e) {
        // Optional: log it and continue without image
        \Log::error('Cloudinary upload failed: '.$e->getMessage());
        return null;
    }
}

    private function advanceStep(Portfolio $portfolio, int $nextStep)
    {
        if ($portfolio->current_step < $nextStep) {
            $portfolio->update(['current_step' => $nextStep]);
        }
    }

    private function authorizeOwner(Portfolio $portfolio)
    {
        if ($portfolio->user_id !== Auth::id()) {
            abort(403);
        }
    }

    private function u(): string
    {
        return (string) auth()->user()->username;
    }
}