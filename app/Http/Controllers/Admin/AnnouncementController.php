<?php

namespace App\Http\Controllers\Admin;

use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends BaseAdminController
{
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

        $data = $this->getAdminData();
        $data['announcements'] = $announcements;

        return view('admin.announcements.index', $data);
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

        $data = $this->getAdminData();

        return view('admin.announcements.create', $data);
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

        $data = $this->getAdminData();
        $data['announcement'] = $announcement;

        return view('admin.announcements.edit', $data);
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
