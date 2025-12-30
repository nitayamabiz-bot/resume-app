<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    /**
     * 管理者チェック
     */
    private function checkAdmin(): ?RedirectResponse
    {
        if (!Auth::check() || Auth::user()->email !== 'info@hamro-life-japan.com') {
            return redirect()->route('home')->with('error', '管理者権限が必要です。');
        }
        return null;
    }

    /**
     * お知らせ一覧を表示
     */
    public function index(): View|RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $announcements = Announcement::orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * お知らせ作成フォームを表示
     */
    public function create(): View|RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        return view('admin.announcements.create');
    }

    /**
     * お知らせを保存
     */
    public function store(Request $request): RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_published' => 'boolean',
            'display_order' => 'integer|min:0',
        ]);

        // 最大20件の制限チェック
        $count = Announcement::count();
        if ($count >= 20) {
            return redirect()->route('admin.announcements.index')
                ->with('error', 'お知らせは最大20件まで登録できます。');
        }

        Announcement::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_published' => $request->has('is_published'),
            'display_order' => $validated['display_order'] ?? 0,
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'お知らせを作成しました。');
    }

    /**
     * お知らせ編集フォームを表示
     */
    public function edit(Announcement $announcement): View|RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * お知らせを更新
     */
    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_published' => 'boolean',
            'display_order' => 'integer|min:0',
        ]);

        $announcement->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_published' => $request->has('is_published'),
            'display_order' => $validated['display_order'] ?? 0,
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'お知らせを更新しました。');
    }

    /**
     * お知らせを削除
     */
    public function destroy(Announcement $announcement): RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'お知らせを削除しました。');
    }
}
