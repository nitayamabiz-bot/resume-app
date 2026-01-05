<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerHistorySubmission extends Model
{
    protected $fillable = [
        'user_id',
        'last_name_roman',
        'first_name_roman',
        'job_summary',
        'self_pr',
        'career_histories',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'career_histories' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
