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
        Schema::create('competitor_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('engagement_reports')->cascadeOnDelete();
            $table->string('competitor_name');
            $table->unsignedBigInteger('competitor_followers')->default(0);
            $table->decimal('competitor_engagement_rate', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitor_entries');
    }
};
