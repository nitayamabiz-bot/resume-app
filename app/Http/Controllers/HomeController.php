<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * トップページを表示
     */
    public function index(): View
    {
        // 公開中のお知らせを最大5件取得（表示順でソート）
        $announcements = Announcement::where('is_published', true)
            ->orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // 管理者チェック
        $isAdmin = Auth::check() && Auth::user()->email === 'info@hamro-life-japan.com';

        return view('home', compact('announcements', 'isAdmin'));
    }
}
