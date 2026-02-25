<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::table('portfolios', function (Blueprint $table) {
    $table->string('profile_photo')->nullable();
    $table->string('full_name')->nullable();
    $table->text('short_bio')->nullable();
    $table->string('location')->nullable();
    $table->string('github_link')->nullable();
    $table->string('linkedin_link')->nullable();
    $table->string('twitter_link')->nullable();
    $table->string('template_choice')->nullable();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            //
        });
    }
};
