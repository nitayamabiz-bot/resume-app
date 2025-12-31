<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
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

Route::get('/bank', function () {
    return view('pages.bank');
})->name('bank');

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
Route::post('/resume', [ResumeController::class, 'store'])->name('resume.store');
Route::post('/resume/save', [ResumeController::class, 'save'])->name('resume.save');
Route::get('/resume/choose-auth', [ResumeController::class, 'chooseAuth'])->name('resume.choose-auth');
Route::post('/resume-download', [ResumeController::class, 'download'])->name('resume.download');

// 職務経歴書関連のルート（仮）
Route::get('/career', function () {
    return view('career.index');
})->name('career.index');

// 広告募集関連のルート
Route::get('/advertisement', [AdvertisementController::class, 'create'])->name('advertisement.create');
Route::post('/advertisement', [AdvertisementController::class, 'store'])->name('advertisement.store');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // 管理者画面（お知らせ管理・ニュース管理）
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('announcements', AdminAnnouncementController::class);
        Route::resource('news', AdminNewsController::class);
    });
});

require __DIR__.'/auth.php';
