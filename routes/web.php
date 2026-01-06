<?php

use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\ResumeSubmissionController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\CareerHistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

// トップページ
Route::get('/', [HomeController::class, 'index'])->name('home');

// 各ページ
Route::get('/rental', function () {
    return view('pages.rental');
})->name('rental');

Route::get('/parttime', function () {
    return view('pages.parttime');
})->name('parttime');

Route::get('/job', function () {
    return view('pages.job');
})->name('job');

Route::get('/campaign', function () {
    return view('pages.campaign');
})->name('campaign');

Route::get('/internet', function () {
    return view('pages.internet');
})->name('internet');

Route::get('/sim', function () {
    return view('pages.sim');
})->name('sim');

// 履歴書関連のルート
Route::get('/resume', [ResumeController::class, 'index'])->name('resume.index');

Route::get('/create', [ResumeController::class, 'create'])->name('resume.create');
Route::post('/resume/confirm', [ResumeController::class, 'confirm'])->name('resume.confirm');
Route::post('/resume/save', [ResumeController::class, 'save'])->name('resume.save');
Route::get('/resume/choose-auth', [ResumeController::class, 'chooseAuth'])->name('resume.choose-auth');
Route::post('/resume-download', [ResumeController::class, 'download'])->name('resume.download');
Route::post('/resume/generate-motivation', [ResumeController::class, 'generateMotivation'])->name('resume.generate-motivation');
Route::post('/resume', [ResumeController::class, 'store'])->name('resume.store');

// 職務経歴書関連のルート
Route::get('/career-history', [CareerHistoryController::class, 'index'])->name('career-history.index');
Route::get('/career-history/create', [CareerHistoryController::class, 'create'])->name('career-history.create');
Route::post('/career-history/confirm', [CareerHistoryController::class, 'confirm'])->name('career-history.confirm');
Route::post('/career-history/save', [CareerHistoryController::class, 'save'])->name('career-history.save');
Route::post('/career-history/download', [CareerHistoryController::class, 'download'])->name('career-history.download');
Route::post('/career-history/generate-career-info', [CareerHistoryController::class, 'generateCareerInfo'])->name('career-history.generate-career-info');
Route::post('/career-history/generate-job-summary', [CareerHistoryController::class, 'generateJobSummary'])->name('career-history.generate-job-summary');
Route::post('/career-history/generate-self-pr', [CareerHistoryController::class, 'generateSelfPR'])->name('career-history.generate-self-pr');
Route::post('/career-history', [CareerHistoryController::class, 'store'])->name('career-history.store');

// プライバシーポリシー
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

// 広告募集関連のルート
Route::get('/advertisement', [AdvertisementController::class, 'create'])->name('advertisement.create');
Route::post('/advertisement', [AdvertisementController::class, 'store'])->name('advertisement.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 管理者画面
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('announcements', AdminAnnouncementController::class);
        Route::resource('news', AdminNewsController::class);
        Route::resource('resume-submissions', ResumeSubmissionController::class)->only(['index', 'show']);
        Route::resource('career-history-submissions', \App\Http\Controllers\Admin\CareerHistorySubmissionController::class)->only(['index', 'show']);
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::post('users/{user}/block', [\App\Http\Controllers\Admin\UserController::class, 'block'])->name('users.block');
        Route::post('users/{user}/unblock', [\App\Http\Controllers\Admin\UserController::class, 'unblock'])->name('users.unblock');
        Route::post('users/{user}/suspend', [\App\Http\Controllers\Admin\UserController::class, 'suspend'])->name('users.suspend');
        Route::post('users/{user}/unsuspend', [\App\Http\Controllers\Admin\UserController::class, 'unsuspend'])->name('users.unsuspend');
    });
});

require __DIR__.'/auth.php';
