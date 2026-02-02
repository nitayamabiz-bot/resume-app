<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\LogAccess::class,
            \App\Http\Middleware\ForceCanonicalUrl::class, // Search Console: 正規URLへ301リダイレクト
        ]);

        // セキュリティ強化: すべてのリクエストにセキュリティヘッダーを追加
        $middleware->web(append: [
            \Illuminate\Http\Middleware\FrameGuard::class, // X-Frame-Options
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // CSRFトークンエラー（419）の処理
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            // ログインページまたは会員登録ページで419エラーが発生した場合
            if ($request->is('login') || $request->is('register')) {
                return redirect()->back()
                    ->withInput($request->except(['password', '_token']))
                    ->withErrors(['email' => 'セッションの有効期限が切れました。再度お試しください。']);
            }
        });
    })->create();
