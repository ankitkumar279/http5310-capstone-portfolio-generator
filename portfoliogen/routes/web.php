<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PublicPagesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortfolioWizardController;
use App\Http\Controllers\PortfolioViewController;
use App\Http\Controllers\TemplatePreviewController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\Api\AiSuggestController;

/*
|--------------------------------------------------------------------------
| Public Pages (no auth)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicPagesController::class, 'home'])->name('home');
Route::get('/how-it-works', [PublicPagesController::class, 'how'])->name('how');
Route::get('/templates', [PublicPagesController::class, 'templates'])->name('templates');

/*
|--------------------------------------------------------------------------
| Template Preview (no auth)
|--------------------------------------------------------------------------
*/
Route::get('/templates/preview/{key}', [TemplatePreviewController::class, 'show'])
  ->name('templates.preview');

/*
|--------------------------------------------------------------------------
| Social Login (no auth)
|--------------------------------------------------------------------------
*/
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback']);

/*
|--------------------------------------------------------------------------
| AI Suggest (no auth OR protect if you want)
|--------------------------------------------------------------------------
*/
Route::post('/ai/suggest', [AiSuggestController::class, 'suggest'])->name('ai.suggest');

/*
|--------------------------------------------------------------------------
| Authenticated Routes under username prefix
| /{username}/dashboard, /{username}/portfolio/...
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'username.match'])
  ->prefix('{username}')
  ->where(['username' => '[A-Za-z0-9_]+' ])
  ->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Create portfolio
    Route::get('/portfolio/create', [PortfolioWizardController::class, 'chooseTemplate'])
      ->name('portfolio.create');

    Route::post('/portfolio/create', [PortfolioWizardController::class, 'storeTemplate'])
      ->name('portfolio.storeTemplate');

    // Wizard steps
    Route::get('/portfolio/{portfolio}/step/{step}', [PortfolioWizardController::class, 'showStep'])
      ->whereNumber('step')
      ->name('portfolio.step');

    Route::post('/portfolio/{portfolio}/step/{step}', [PortfolioWizardController::class, 'saveStep'])
      ->whereNumber('step')
      ->name('portfolio.step.save');

    // Owner preview (private)
    Route::get('/p/{portfolio}', [PortfolioViewController::class, 'show'])
      ->name('portfolio.owner.view');

    // Portfolio actions
    Route::delete('/portfolio/{portfolio}', [PortfolioWizardController::class, 'destroy'])
      ->name('portfolio.destroy');

    Route::post('/portfolio/{portfolio}/duplicate', [PortfolioWizardController::class, 'duplicate'])
      ->name('portfolio.duplicate');

    // Template change
    Route::get('/portfolio/{portfolio}/template', [PortfolioWizardController::class, 'editTemplate'])
      ->name('portfolio.template.edit');

    Route::patch('/portfolio/{portfolio}/template', [PortfolioWizardController::class, 'updateTemplate'])
      ->name('portfolio.template.update');

    // Save draft
    Route::patch('/portfolio/{portfolio}/draft', [PortfolioWizardController::class, 'saveDraft'])
      ->name('portfolio.draft');

    // Delete items
    Route::delete('/portfolio/{portfolio}/education/{education}', [PortfolioWizardController::class, 'deleteEducation'])
      ->name('portfolio.education.delete');

    Route::delete('/portfolio/{portfolio}/experience/{experience}', [PortfolioWizardController::class, 'deleteExperience'])
      ->name('portfolio.experience.delete');

    Route::delete('/portfolio/{portfolio}/skill/{skill}', [PortfolioWizardController::class, 'deleteSkill'])
      ->name('portfolio.skill.delete');

    Route::delete('/portfolio/{portfolio}/project/{project}', [PortfolioWizardController::class, 'deleteProject'])
      ->name('portfolio.project.delete');

    // Update items
    Route::put('/portfolio/{portfolio}/education/{education}', [PortfolioWizardController::class, 'updateEducation'])
      ->name('portfolio.education.update');

    Route::put('/portfolio/{portfolio}/experience/{experience}', [PortfolioWizardController::class, 'updateExperience'])
      ->name('portfolio.experience.update');

    Route::put('/portfolio/{portfolio}/skill/{skill}', [PortfolioWizardController::class, 'updateSkill'])
      ->name('portfolio.skill.update');

    Route::put('/portfolio/{portfolio}/project/{project}', [PortfolioWizardController::class, 'updateProject'])
      ->name('portfolio.project.update');
  });

/*
|--------------------------------------------------------------------------
| Public Portfolio View (NO auth)
| /{username}/{portfolio}
|
| Important: portfolio must be numeric, so it will NOT conflict with:
| /{username}/dashboard, /{username}/portfolio/create, etc.
|--------------------------------------------------------------------------
*/
Route::get('/{username}/{portfolio}', [PortfolioViewController::class, 'publicShow'])
  ->where([
    'username'  => '[A-Za-z0-9_]+',
    'portfolio' => '[0-9]+',
  ])
  ->name('portfolio.public.view');

require __DIR__ . '/auth.php';