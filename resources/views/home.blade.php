@extends('layouts.main')

@section('title', 'トップページ - 就労支援サービス')

@section('content')
<style>
    .center-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 1000px;
        margin: 0 auto;
    }
    .main-heading {
        font-size: 2rem;
        font-weight: 500;
        margin-bottom: 0.35em;
        text-align: center;
        line-height: 1.22;
    }
    .heading-nepali {
        font-size: 1.05rem;
        color: #3E5387;
        margin-bottom: 2em;
        display: block;
        text-align: center;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
    }
    .welcome-text {
        text-align: center;
        color: #4b5563;
        line-height: 1.8;
        max-width: 800px;
        margin: 0 auto 40px;
    }
    .welcome-text-nepali {
        display: block;
        margin-top: 12px;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        color: #6b7280;
        font-size: 0.95rem;
    }
    .announcements-section {
        width: 100%;
        max-width: 800px;
        margin: 40px auto;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        background-color: #ffffff;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
    }
    .announcements-list {
        max-height: 600px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 0;
    }
    .announcement-item {
        border: 1px solid #d1d5db;
        border-radius: 6px;
        padding: 16px;
        background-color: #f9fafb;
    }
    .announcements-section .flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .admin-button {
        padding: 8px 16px;
        background-color: #2563eb;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.875rem;
        white-space: nowrap;
        margin-left: 16px;
        transition: background-color 0.2s;
    }
    .admin-button:hover {
        background-color: #1d4ed8;
    }
    @media (max-width: 700px) {
        .main-heading {
            font-size: 1.5rem;
        }
        .welcome-text {
            font-size: 0.95rem;
            padding: 0 16px;
        }
        .center-content {
            padding: 0 16px;
        }
        .announcements-section {
            margin: 20px 16px;
            padding: 16px;
            border-width: 1px;
            width: calc(100% - 32px);
            max-width: none;
        }
        .announcements-section .flex {
            flex-direction: column;
            align-items: stretch;
        }
        .announcements-section h2 {
            margin-bottom: 12px;
        }
        .admin-button {
            margin-left: 0;
            margin-top: 8px;
            text-align: center;
        }
        .announcements-list {
            max-height: 400px;
        }
        .announcement-item {
            padding: 12px;
        }
        .announcement-item h3 {
            font-size: 1rem;
        }
        .announcement-item .text-xs {
            font-size: 0.7rem;
        }
    }
</style>
<div class="center-content">
    <h1 class="main-heading">
        就労支援サービスへようこそ
        <span class="heading-nepali">रोजगार सहायता सेवामा स्वागत छ</span>
    </h1>
    <div class="welcome-text">
        日本での生活をサポートする各種サービスをご案内しています。
        賃貸物件の検索、アルバイト・就職情報、銀行口座開設、インターネット回線・SIMカードの手続きなど、
        あなたの生活に必要な情報をまとめて提供しています。
        <span class="welcome-text-nepali">
            जापानमा बस्नका लागि विभिन्न सेवाहरू प्रदान गर्दछौं।
            भाडाको खोज, अंशकालिक र रोजगार जानकारी, बैंक खाता खोल्ने, इन्टरनेट र SIM कार्डको प्रक्रिया लगायत,
            तपाईंको जीवनको लागि आवश्यक जानकारीहरू यहाँ उपलब्ध छन्।
        </span>
    </div>

    <!-- お知らせエリア -->
    @if($announcements->count() > 0)
    <div class="announcements-section">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-center" style="color: #3E5387; flex: 1;">
                お知らせ / सूचना
            </h2>
            @if($isAdmin)
                <a href="{{ route('admin.announcements.index') }}" class="admin-button">
                    管理 / व्यवस्थापन
                </a>
            @endif
        </div>
        <div class="announcements-list">
            @foreach($announcements as $index => $announcement)
                <div class="announcement-item" style="margin-bottom: {{ $index < $announcements->count() - 1 ? '16px' : '0' }};">
                    <div class="text-xs text-gray-500 mb-2">
                        {{ $announcement->created_at->format('Y年m月d日 H:i') }} / {{ $announcement->created_at->format('Y मा m d H:i') }}
                    </div>
                    <h3 class="font-semibold text-lg mb-2" style="color: #1160E6;">
                        {{ $announcement->title }}
                    </h3>
                    <div class="text-gray-700 whitespace-pre-wrap" style="line-height: 1.6;">
                        {{ $announcement->content }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

