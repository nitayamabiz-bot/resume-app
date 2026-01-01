<?php

namespace App\Http\Controllers\Admin;

use App\Models\ResumeSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResumeSubmissionController extends BaseAdminController
{
    /**
     * 履歴書提出一覧を表示
     */
    public function index(Request $request): View|RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $query = ResumeSubmission::query();

        // 検索条件
        if ($request->filled('search_name')) {
            $searchName = $request->search_name;
            $query->where(function ($q) use ($searchName) {
                $q->where('first_name_roman', 'like', "%{$searchName}%")
                    ->orWhere('last_name_roman', 'like', "%{$searchName}%")
                    ->orWhere('first_name_kana', 'like', "%{$searchName}%")
                    ->orWhere('last_name_kana', 'like', "%{$searchName}%");
            });
        }

        if ($request->filled('search_email')) {
            $query->where('email', 'like', "%{$request->search_email}%");
        }

        if ($request->filled('search_phone')) {
            $query->where('phone', 'like', "%{$request->search_phone}%");
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
        $submissions = $query->with('user')->paginate($perPage)->withQueryString();

        $data = $this->getAdminData();
        $data['submissions'] = $submissions;

        return view('admin.resume-submissions.index', $data);
    }

    /**
     * 履歴書提出詳細を表示
     */
    public function show(ResumeSubmission $resumeSubmission): View|RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $resumeSubmission->load('user');

        $data = $this->getAdminData();
        $data['resumeSubmission'] = $resumeSubmission;

        return view('admin.resume-submissions.show', $data);
    }
}
