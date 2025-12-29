<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable = [
        'service_name',
        'representative_name',
        'phone',
        'email',
        'site_url',
    ];

    protected $casts = [
        'ctime' => 'datetime',
    ];
}
