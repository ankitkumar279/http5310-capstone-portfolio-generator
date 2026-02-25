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
    Schema::create('educations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
        $table->string('institution_name');
        $table->string('degree');
        $table->date('start_date');
        $table->date('end_date')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
