<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('projects', function (Blueprint $table) {
      $table->id();
      $table->foreignId('portfolio_id')->constrained()->cascadeOnDelete();

      $table->string('title');
      $table->text('description');
      $table->string('image_path')->nullable();
      $table->string('live_url')->nullable();
      $table->string('github_url')->nullable();

      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('projects');
  }
};