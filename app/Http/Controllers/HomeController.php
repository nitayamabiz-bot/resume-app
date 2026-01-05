<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * トップページを表示
     */
    public function index(): View
    {
        // 公開中のお知らせを最大20件取得（表示順でソート）
        $announcements = Announcement::where('is_published', true)
            ->orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // 公開中のニュースを取得（国内・国外別、最大20件）
        $domesticNews = News::where('is_published', true)
            ->where('category', 'domestic')
            ->orderBy('display_order')
            ->orderBy('published_date', 'desc')
            ->limit(20)
            ->get();

        $internationalNews = News::where('is_published', true)
            ->where('category', 'international')
            ->orderBy('display_order')
            ->orderBy('published_date', 'desc')
            ->limit(20)
            ->get();

        // 管理者チェック
        $isAdmin = Auth::check() && Auth::user()->email === 'info@hamro-life-japan.com';

        return view('home', compact('announcements', 'domesticNews', 'internationalNews', 'isAdmin'));
    }
}
