<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'url',
        'method',
        'access_date',
    ];

    protected $casts = [
        'access_date' => 'date',
    ];

    public static function logAccess(string $url, string $method = 'GET'): void
    {
        self::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => $url,
            'method' => $method,
            'access_date' => Carbon::today(),
        ]);
    }

    public static function getTodayCount(): int
    {
        return self::where('access_date', Carbon::today())->count();
    }

    public static function getTotalCount(): int
    {
        return self::count();
    }
}
