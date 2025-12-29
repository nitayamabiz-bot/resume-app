<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resume extends Model
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
        'postal_code',
        'address',
        'address_kana',
        'education',
        'work_history',
        'licenses',
        'appeal_points',
        'self_request',
        'photo_path',
        'status',
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
