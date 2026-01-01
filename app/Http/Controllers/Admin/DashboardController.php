<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends BaseAdminController
{
    /**
     * 管理画面ダッシュボードを表示
     */
    public function index(): View|RedirectResponse
    {
        $redirect = $this->checkAdmin();
        if ($redirect) {
            return $redirect;
        }

        $data = $this->getAdminData();

        return view('admin.dashboard', $data);
    }
}
