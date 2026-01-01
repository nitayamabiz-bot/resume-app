<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class BaseAdminController extends Controller
{
    /**
     * 管理者チェック
     */
    protected function checkAdmin(): ?RedirectResponse
    {
        if (! Auth::check() || Auth::user()->email !== 'info@hamro-life-japan.com') {
            return redirect()->route('home')->with('error', '管理者権限が必要です。');
        }

        return null;
    }

    /**
     * 管理画面用の共通データを取得
     */
    protected function getAdminData(): array
    {
        return [
            'todayAccessCount' => AccessLog::getTodayCount(),
            'totalAccessCount' => AccessLog::getTotalCount(),
        ];
    }
}
