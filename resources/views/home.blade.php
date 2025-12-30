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
        font-size: 1.75rem;
        font-weight: 500;
        margin-bottom: 0.35em;
        text-align: center;
        line-height: 1.22;
    }
    .heading-nepali {
        font-size: 1.05rem;
        color: #3E5387;
        margin-bottom: 1em;
        display: block;
        text-align: center;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
    }
    .welcome-text {
        text-align: center;
        color: #4b5563;
        line-height: 1.8;
        max-width: 800px;
        margin: 0 auto 20px;
    }
    .welcome-text-nepali {
        display: block;
        margin-top: 12px;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        color: #6b7280;
        font-size: 0.95rem;
    }

    /* お知らせ・ニュース共通のセクション設定 */
    .announcements-section, .news-section {
        width: 100%;
        max-width: 1000px;
        margin: 40px auto;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        background-color: #ffffff;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
    }

    /* お知らせエリア：中身が少なければ縮み、多ければ500pxでスクロール */
    .announcements-list {
        max-height: 500px !important; /* height から max-height に変更 */
        overflow-y: auto !important;
        display: block !important;
        padding-right: 8px;
    }

    /* ニュースエリア：左右の高さが揃うよう、こちらは固定高を維持 */
    .news-list-container {
        height: 500px !important; 
        overflow-y: auto !important;
        display: block !important;
        padding-right: 8px;
    }

    .announcement-item, .news-item {
        margin-bottom: 8px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        padding: 12px;
        background-color: #f9fafb;
    }

    .admin-button {
        padding: 8px 16px;
        background-color: #2563eb;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.875rem;
        transition: background-color 0.2s;
    }

    /* スマホ表示（700px以下）の微調整 */
    @media (max-width: 700px) {
        .main-heading { font-size: 1.5rem; }
        .announcements-section, .news-section {
            margin: 20px 16px;
            padding: 16px;
            width: calc(100% - 32px);
        }
        .announcements-list {
            max-height: 350px !important; /* スマホでは少し短くする */
        }
        .news-list-container {
            height: 350px !important; /* スマホでは少し短くする */
        }
        /* ニュースの2段組みを1段にする */
        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
<div class="center-content">
    <h1 class="main-heading">
        就労支援サービスへようこそ
        <span class="heading-nepali">रोजगार सहायता सेवामा स्वागत छ</span>
    </h1>
            <div class="welcome-text">
                <span class="welcome-text-nepali">
                    रोजगार सहायता सेवाले जापानमा बसोबास गर्ने नेपालीहरूका लागि उपयोगी जानकारी प्रदान गर्दछ।

                    हामी रोजगारीको खोजी, नि:शुल्क बायोडाटा (Resume) बनाउने सेवा, लोकप्रिय तथा सस्तो इन्टरनेट र सिम कार्ड, साथै विदेशीहरूलाई स्वागत गर्ने घरजग्गा (Real Estate) कम्पनीहरू जस्ता विस्तृत विवरणहरू उपलब्ध गराउँछौँ।

                    यसका साथै, हामी जापान भित्रका र अन्तर्राष्ट्रिय नेपाली समाचारहरू पनि प्रसारण गर्दछौँ।
                </span>
            </div>

    <!-- ニュースエリア -->
    @if($domesticNews->count() > 0 || $internationalNews->count() > 0)
    <div class="news-section" style="width: 100%; max-width: 1000px; margin: 20px auto; border: 2px solid #e5e7eb; border-radius: 8px; background-color: #ffffff; padding: 16px 24px 24px 24px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); box-sizing: border-box;">
        <h2 class="text-xl font-bold mb-2 text-center" style="color: #3E5387; margin-top: 0;">
            ニュース / समाचार
        </h2>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <!-- 国内ニュース -->
            <div>
                <h3 class="text-lg font-semibold mb-3 text-center" style="color: #1160E6; border-bottom: 2px solid #1160E6; padding-bottom: 8px;">
                    国内ニュース / घरेलु समाचार
                </h3>
                <div class="news-list-container">
                    <div class="news-list" style="display: flex; flex-direction: column; gap: 4px;">
                        @forelse($domesticNews as $news)
                        <a href="{{ $news->external_url }}" target="_blank" rel="noopener noreferrer" class="news-item" style="display: flex; gap: 12px; padding: 8px; border: 1px solid #e5e7eb; border-radius: 6px; text-decoration: none; color: inherit; transition: background-color 0.2s;">
                            <div style="flex-shrink: 0; width: 80px; height: 60px; overflow: hidden; border-radius: 4px; background-color: #f3f4f6;">
                                <img src="{{ $news->image_url ?? 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4MCIgaGVpZ2h0PSI2MCI+PHJlY3Qgd2lkdGg9IjgwIiBoZWlnaHQ9IjYwIiBmaWxsPSIjZTdlOWViIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIiBmaWxsPSIjOTk5IiBmb250LXNpemU9IjEyIj5OZXdzPC90ZXh0Pjwvc3ZnPg==' }}" 
                                     alt="{{ $news->title }}" 
                                     style="width: 100%; height: 100%; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4MCIgaGVpZ2h0PSI2MCI+PHJlY3Qgd2lkdGg9IjgwIiBoZWlnaHQ9IjYwIiBmaWxsPSIjZTdlOWViIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIiBmaWxsPSIjOTk5IiBmb250LXNpemU9IjEyIj5OZXdzPC90ZXh0Pjwvc3ZnPg==';">
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div class="text-sm font-semibold mb-1" style="color: #1160E6; line-height: 1.4;">{{ $news->title }}</div>
                                <div class="text-xs text-gray-500">{{ $news->published_date->format('Y年m月d日') }}</div>
                            </div>
                        </a>
                        @empty
                            <div class="text-sm text-gray-500 text-center py-4">国内ニュースはありません / कुनै घरेलु समाचार छैन</div>
                        @endforelse
                    </div>
                </div>
            </div>
            <!-- 国外ニュース -->
            <div>
                <h3 class="text-lg font-semibold mb-3 text-center" style="color: #1160E6; border-bottom: 2px solid #1160E6; padding-bottom: 8px;">
                    国外ニュース / अन्तर्राष्ट्रिय समाचार
                </h3>
                <div class="news-list-container">
                    <div class="news-list" style="display: flex; flex-direction: column; gap: 4px;">
                        @forelse($internationalNews as $news)
                        <a href="{{ $news->external_url }}" target="_blank" rel="noopener noreferrer" class="news-item" style="display: flex; gap: 12px; padding: 8px; border: 1px solid #e5e7eb; border-radius: 6px; text-decoration: none; color: inherit; transition: background-color 0.2s;">
                            <div style="flex-shrink: 0; width: 80px; height: 60px; overflow: hidden; border-radius: 4px; background-color: #f3f4f6;">
                                <img src="{{ $news->image_url ?? 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4MCIgaGVpZ2h0PSI2MCI+PHJlY3Qgd2lkdGg9IjgwIiBoZWlnaHQ9IjYwIiBmaWxsPSIjZTdlOWViIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIiBmaWxsPSIjOTk5IiBmb250LXNpemU9IjEyIj5OZXdzPC90ZXh0Pjwvc3ZnPg==' }}" 
                                     alt="{{ $news->title }}" 
                                     style="width: 100%; height: 100%; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4MCIgaGVpZ2h0PSI2MCI+PHJlY3Qgd2lkdGg9IjgwIiBoZWlnaHQ9IjYwIiBmaWxsPSIjZTdlOWViIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIiBmaWxsPSIjOTk5IiBmb250LXNpemU9IjEyIj5OZXdzPC90ZXh0Pjwvc3ZnPg==';">
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div class="text-sm font-semibold mb-1" style="color: #1160E6; line-height: 1.4;">{{ $news->title }}</div>
                                <div class="text-xs text-gray-500">{{ $news->published_date->format('Y年m月d日') }}</div>
                            </div>
                        </a>
                        @empty
                            <div class="text-sm text-gray-500 text-center py-4">国外ニュースはありません / कुनै अन्तर्राष्ट्रिय समाचार छैन</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @if($isAdmin)
            <div class="text-center mt-4">
                <a href="{{ route('admin.news.index') }}" class="admin-button" style="display: inline-block;">
                    管理 / व्यवस्थापन
                </a>
            </div>
        @endif
    </div>
    @endif

    <!-- お知らせエリア -->
    @if($announcements->count() > 0)
    <div class="announcements-section" style="width: 100%; max-width: 1000px; margin: 40px auto; border: 2px solid #e5e7eb; border-radius: 8px; background-color: #ffffff; padding: 16px 24px 24px 24px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); box-sizing: border-box;">
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-xl font-bold text-center" style="color: #3E5387; flex: 1; margin: 0 0 12px 0;">
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
                <div class="announcement-item" style="margin-bottom: {{ $index < $announcements->count() - 1 ? '8px' : '0' }};">
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

