<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUsageLimit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'usage_count',
        'is_premium',
    ];

    protected $casts = [
        'is_premium' => 'boolean',
        'usage_count' => 'integer',
    ];

    /**
     * Relationship with the User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
