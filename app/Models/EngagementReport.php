<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngagementReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'platform',
        'followers',
        'likes',
        'comments',
        'shares',
        'saves',
        'views',
        'reach',
        'industry',
        'engagement_rate',
        'quality_score',
        'benchmark_difference',
        'fake_engagement_flag',
        'report_json',
    ];

    protected $casts = [
        'fake_engagement_flag' => 'boolean',
        'engagement_rate' => 'decimal:2',
        'quality_score' => 'decimal:2',
        'benchmark_difference' => 'decimal:2',
    ];

    /**
     * Relationship with the User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with Competitor Entries.
     */
    public function competitorEntries()
    {
        return $this->hasMany(CompetitorEntry::class, 'report_id');
    }
}
