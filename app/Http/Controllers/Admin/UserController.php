<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends BaseAdminController
{
    /**
     * 会員情報一覧を表示
     */
    public function index(Request $request): View|RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $query = User::query();

        // 検索条件
        if ($request->filled('search_name')) {
            $searchName = $request->search_name;
            $query->where('name', 'like', "%{$searchName}%");
        }

        if ($request->filled('search_email')) {
            $query->where('email', 'like', "%{$request->search_email}%");
        }

        if ($request->filled('status')) {
            switch ($request->status) {
                case 'blocked':
                    $query->where('is_blocked', true);
                    break;
                case 'suspended':
                    $query->where('is_suspended', true);
                    break;
                case 'active':
                    $query->where('is_blocked', false)->where('is_suspended', false);
                    break;
            }
        }

        if ($request->filled('search_date_from')) {
            $query->whereDate('created_at', '>=', $request->search_date_from);
        }

        if ($request->filled('search_date_to')) {
            $query->whereDate('created_at', '<=', $request->search_date_to);
        }

        // 並び順
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // ページネーション
        $perPage = $request->get('per_page', 20);
        $users = $query->paginate($perPage)->withQueryString();

        $data = $this->getAdminData();
        $data['users'] = $users;

        return view('admin.users.index', $data);
    }

    /**
     * 会員情報詳細を表示
     */
    public function show(User $user): View|RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $data = $this->getAdminData();
        $data['user'] = $user;
        $data['resumes'] = $user->resumes()->orderBy('created_at', 'desc')->get();

        return view('admin.users.show', $data);
    }

    /**
     * 会員情報編集フォームを表示
     */
    public function edit(User $user): View|RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $data = $this->getAdminData();
        $data['user'] = $user;

        return view('admin.users.edit', $data);
    }

    /**
     * 会員情報を更新
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'is_blocked' => 'boolean',
            'is_suspended' => 'boolean',
            'suspended_until' => 'nullable|date',
            'block_reason' => 'nullable|string|max:500',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'is_blocked' => $request->has('is_blocked'),
            'is_suspended' => $request->has('is_suspended'),
            'suspended_until' => $validated['suspended_until'] ?? null,
            'block_reason' => $validated['block_reason'] ?? null,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', '会員情報を更新しました。');
    }

    /**
     * 会員をブロック
     */
    public function block(Request $request, User $user): RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $user->update([
            'is_blocked' => true,
            'block_reason' => $request->input('block_reason'),
        ]);

        return redirect()->back()->with('success', '会員をブロックしました。');
    }

    /**
     * 会員のブロックを解除
     */
    public function unblock(User $user): RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $user->update([
            'is_blocked' => false,
            'block_reason' => null,
        ]);

        return redirect()->back()->with('success', 'ブロックを解除しました。');
    }

    /**
     * 会員をアカウント停止
     */
    public function suspend(Request $request, User $user): RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $user->update([
            'is_suspended' => true,
            'suspended_until' => $request->input('suspended_until'),
        ]);

        return redirect()->back()->with('success', 'アカウントを停止しました。');
    }

    /**
     * アカウント停止を解除
     */
    public function unsuspend(User $user): RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $user->update([
            'is_suspended' => false,
            'suspended_until' => null,
        ]);

        return redirect()->back()->with('success', 'アカウント停止を解除しました。');
    }

    /**
     * 会員を削除
     */
    public function destroy(User $user): RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', '会員を削除しました。');
    }
}
