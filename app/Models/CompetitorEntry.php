<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitorEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'competitor_name',
        'competitor_followers',
        'competitor_engagement_rate',
    ];

    protected $casts = [
        'competitor_followers' => 'integer',
        'competitor_engagement_rate' => 'decimal:2',
    ];

    /**
     * Relationship with the Engagement Report.
     */
    public function engagementReport()
    {
        return $this->belongsTo(EngagementReport::class, 'report_id');
    }
}
