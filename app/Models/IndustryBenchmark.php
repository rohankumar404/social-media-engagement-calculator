<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustryBenchmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'industry',
        'platform',
        'avg_engagement_rate',
        'high_threshold',
        'viral_threshold',
    ];

    protected $casts = [
        'avg_engagement_rate' => 'decimal:2',
        'high_threshold' => 'decimal:2',
        'viral_threshold' => 'decimal:2',
    ];

    public $timestamps = false; // Add this if there are no timestamps required, but let's leave it using std timestamps if migration has it. Wait, I will keep standard timestamps in migration.
}
