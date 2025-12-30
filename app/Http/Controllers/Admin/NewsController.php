<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NewsController extends Controller
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
     * ニュース一覧を表示
     */
    public function index(): View|RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $news = News::orderBy('display_order')
            ->orderBy('published_date', 'desc')
            ->get();

        return view('admin.news.index', compact('news'));
    }

    /**
     * ニュース作成フォームを表示
     */
    public function create(): View|RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        return view('admin.news.create');
    }

    /**
     * ニュースを保存
     */
    public function store(Request $request): RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image_url' => 'nullable|url|max:500',
            'external_url' => 'required|url|max:500',
            'category' => 'required|in:domestic,international',
            'is_published' => 'boolean',
            'display_order' => 'integer|min:0',
            'published_date' => 'required|date',
        ]);

        News::create([
            'title' => $validated['title'],
            'image_url' => $validated['image_url'] ?? null,
            'external_url' => $validated['external_url'],
            'category' => $validated['category'],
            'is_published' => $request->has('is_published'),
            'display_order' => $validated['display_order'] ?? 0,
            'published_date' => $validated['published_date'],
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'ニュースを作成しました。');
    }

    /**
     * ニュース編集フォームを表示
     */
    public function edit(News $news): View|RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        return view('admin.news.edit', compact('news'));
    }

    /**
     * ニュースを更新
     */
    public function update(Request $request, News $news): RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image_url' => 'nullable|url|max:500',
            'external_url' => 'required|url|max:500',
            'category' => 'required|in:domestic,international',
            'is_published' => 'boolean',
            'display_order' => 'integer|min:0',
            'published_date' => 'required|date',
        ]);

        $news->update([
            'title' => $validated['title'],
            'image_url' => $validated['image_url'] ?? null,
            'external_url' => $validated['external_url'],
            'category' => $validated['category'],
            'is_published' => $request->has('is_published'),
            'display_order' => $validated['display_order'] ?? 0,
            'published_date' => $validated['published_date'],
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'ニュースを更新しました。');
    }

    /**
     * ニュースを削除
     */
    public function destroy(News $news): RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'ニュースを削除しました。');
    }
}
