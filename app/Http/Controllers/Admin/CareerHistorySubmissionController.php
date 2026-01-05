<?php

namespace App\Http\Controllers\Admin;

use App\Models\CareerHistorySubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CareerHistorySubmissionController extends BaseAdminController
{
    /**
     * 職務経歴書提出一覧を表示
     */
    public function index(Request $request): View|RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $query = CareerHistorySubmission::query();

        // 検索条件
        if ($request->filled('search_name')) {
            $searchName = $request->search_name;
            $query->where(function ($q) use ($searchName) {
                $q->where('first_name_roman', 'like', "%{$searchName}%")
                    ->orWhere('last_name_roman', 'like', "%{$searchName}%");
            });
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

        return view('admin.career-history-submissions.index', $data);
    }

    /**
     * 職務経歴書提出詳細を表示
     */
    public function show(CareerHistorySubmission $careerHistorySubmission): View|RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $careerHistorySubmission->load('user');

        $data = $this->getAdminData();
        $data['careerHistorySubmission'] = $careerHistorySubmission;

        return view('admin.career-history-submissions.show', $data);
    }
}
