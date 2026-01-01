@extends('layouts.main')

@section('title', 'トップページ - 就労支援サービス')

@section('content')
<style>
    .main-content {
        position: relative;
    }
    
    .main-content::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset('images/backimage.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        filter: blur(5px);
        opacity: 0.3;
        z-index: -1;
        pointer-events: none;
    }
    
    .center-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 1000px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
        background-color: transparent;
        pointer-events: auto;
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
    
    /* ニュースセクションのスタイル */
    .news-category {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 16px;
        background-color: #ffffff;
    }
    
    .news-category-title {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #1e40af;
        padding: 12px 20px;
        border-radius: 6px;
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 16px;
        box-shadow: 0 2px 4px rgba(17, 96, 230, 0.1);
    }
    
    .news-category-title .flag-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 20px;
        flex-shrink: 0;
    }
    
    .news-category-title .flag-icon svg {
        width: 100%;
        height: 100%;
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
        .news-category {
            margin-bottom: 20px;
        }
        .news-category-title {
            font-size: 1rem;
            padding: 10px 16px;
        }
        .news-category-title .flag-icon {
            width: 24px;
            height: 18px;
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
            <div class="news-category">
                <h3 class="news-category-title">
                    <span class="flag-icon">
                        <svg viewBox="0 0 3 2" xmlns="http://www.w3.org/2000/svg">
                            <rect width="3" height="2" fill="#ffffff"/>
                            <circle cx="1.5" cy="1" r="0.6" fill="#bc002d"/>
                        </svg>
                    </span>
                    <span>国内ニュース / घरेलु समाचार</span>
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
            <div class="news-category">
                <h3 class="news-category-title">
                    <span class="flag-icon">
                        <svg viewBox="0 0 3 2" xmlns="http://www.w3.org/2000/svg">
                            <rect width="3" height="2" fill="#dc143c"/>
                            <polygon points="0,0 0,2 1.2,1" fill="#0000ff"/>
                            <circle cx="0.3" cy="0.3" r="0.15" fill="#ffffff"/>
                            <circle cx="0.3" cy="1.7" r="0.15" fill="#ffffff"/>
                        </svg>
        </span>
                    <span>国外ニュース / अन्तर्राष्ट्रिय समाचार</span>
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
    </div>
    @endif

    <!-- お知らせエリア -->
    @if($announcements->count() > 0)
    <div class="announcements-section" style="width: 100%; max-width: 1000px; margin: 40px auto; border: 2px solid #e5e7eb; border-radius: 8px; background-color: #ffffff; padding: 16px 24px 24px 24px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); box-sizing: border-box;">
        <h2 class="text-xl font-bold text-center mb-2" style="color: #3E5387; margin: 0 0 12px 0;">
            お知らせ / सूचना
        </h2>
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

