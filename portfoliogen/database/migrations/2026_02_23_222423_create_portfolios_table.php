<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('portfolios', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();

      $table->string('title')->nullable();
      $table->string('template_key')->default('minimal'); // minimal, developer, designer, business
      $table->string('status')->default('draft'); // draft, published (later)
      $table->unsignedTinyInteger('current_step')->default(1);

      $table->string('full_name')->nullable();
      $table->string('job_title')->nullable();
      $table->text('short_bio')->nullable();
      $table->string('location')->nullable();

      $table->string('github_url')->nullable();
      $table->string('linkedin_url')->nullable();
      $table->string('twitter_url')->nullable();
      $table->string('photo_path')->nullable();

      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('portfolios');
  }
};