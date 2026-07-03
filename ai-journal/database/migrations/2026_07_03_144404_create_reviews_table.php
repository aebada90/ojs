<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('pending');
            $table->string('recommendation')->nullable();
            $table->decimal('overall_score', 5, 2)->nullable();
            $table->json('criteria_scores')->nullable();
            $table->json('feedback')->nullable();
            $table->json('flags')->nullable();
            $table->text('summary')->nullable();
            $table->text('editor_notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
