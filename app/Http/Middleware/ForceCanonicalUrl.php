<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceCanonicalUrl
{
    /**
     * 正規URLへ強制リダイレクト（Search Console の重複・正規ページエラー対策）
     * https・末尾スラッシュなし・正規ホスト に統一。
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
            return $next($request);
        }

        // ローカルでは一切リダイレクトしない（.env や config に依存しない）
        $host = $request->getHost();
        if (str_ends_with($host, '.test') || str_contains($host, 'localhost')) {
            return $next($request);
        }

        $baseUrl = rtrim((string) config('sitemap.base_url'), '/');
        if ($baseUrl === '' || str_contains($baseUrl, 'localhost')) {
            return $next($request);
        }

        $path = $request->getPathInfo();
        $path = $path === '' ? '/' : rtrim($path, '/');
        $canonical = $baseUrl.$path;
        $query = $request->getQueryString();
        if ($query !== null && $query !== '') {
            $canonical .= '?'.$query;
        }

        $current = $request->url();
        if ($query) {
            $current .= '?'.$query;
        }

        if ($current === $canonical) {
            return $next($request);
        }

        return redirect()->to($canonical, 301);
    }
}
