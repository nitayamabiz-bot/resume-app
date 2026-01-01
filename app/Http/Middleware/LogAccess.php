<?php

namespace App\Http\Middleware;

use App\Models\AccessLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // 管理画面へのアクセスは除外
        if (! str_starts_with($request->path(), 'admin')) {
            try {
                AccessLog::logAccess(
                    $request->fullUrl(),
                    $request->method()
                );
            } catch (\Exception $e) {
                // ログ記録に失敗しても処理は続行
                \Log::error('Failed to log access: '.$e->getMessage());
            }
        }

        return $response;
    }
}
