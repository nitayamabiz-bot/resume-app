<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeSubmission extends Model
{
    protected $fillable = [
        'user_id',
        'first_name_roman',
        'last_name_roman',
        'first_name_kana',
        'last_name_kana',
        'birthday',
        'gender',
        'phone',
        'email',
        'postal_code',
        'address',
        'address_kana',
        'education',
        'work_history',
        'licenses',
        'appeal_points',
        'self_request',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'education' => 'array',
        'work_history' => 'array',
        'licenses' => 'array',
        'birthday' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
