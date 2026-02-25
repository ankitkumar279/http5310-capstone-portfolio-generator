<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicPagesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortfolioWizardController;
use App\Http\Controllers\PortfolioViewController;
use App\Http\Controllers\TemplatePreviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\Api\AiSuggestController;

Route::post('/ai/suggest', [AiSuggestController::class, 'suggest'])->name('ai.suggest');