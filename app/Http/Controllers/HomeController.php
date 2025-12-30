<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
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

        return view('home', compact('announcements'));
    }
}
