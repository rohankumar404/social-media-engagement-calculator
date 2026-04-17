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
        Schema::create('industry_benchmarks', function (Blueprint $table) {
            $table->id();
            $table->string('industry');
            $table->string('platform');
            $table->decimal('avg_engagement_rate', 8, 2);
            $table->decimal('high_threshold', 8, 2);
            $table->decimal('viral_threshold', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industry_benchmarks');
    }
};
