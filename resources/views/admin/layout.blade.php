<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>管理画面 - {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* 編集ボタンなどを確実に表示 */
        .admin-table {
            table-layout: auto !important;
        }
        .admin-table td {
            overflow: visible !important;
            white-space: normal !important;
            position: relative !important;
            vertical-align: middle !important;
        }
        .admin-table td:last-child {
            min-width: 200px !important;
        }
        .admin-table td .flex {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 0.5rem !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            z-index: 10 !important;
            align-items: center !important;
        }
        /* ボタンとリンクの背景色を強制的に設定 */
        .admin-table td a.bg-blue-500,
        .admin-table td a.bg-green-500,
        .admin-table td a.bg-red-500,
        .admin-table td a.bg-yellow-500,
        .admin-table td a.bg-orange-500,
        .admin-table td a.bg-gray-500 {
            background-color: rgb(59 130 246) !important; /* blue-500 */
            color: white !important;
            text-decoration: none !important;
        }
        .admin-table td a.bg-green-500 {
            background-color: rgb(34 197 94) !important; /* green-500 */
        }
        .admin-table td a.bg-red-500 {
            background-color: rgb(239 68 68) !important; /* red-500 */
        }
        .admin-table td a.bg-yellow-500 {
            background-color: rgb(234 179 8) !important; /* yellow-500 */
        }
        .admin-table td a.bg-orange-500 {
            background-color: rgb(249 115 22) !important; /* orange-500 */
        }
        .admin-table td a.bg-gray-500 {
            background-color: rgb(107 114 128) !important; /* gray-500 */
        }
        .admin-table td button.bg-blue-500,
        .admin-table td button.bg-green-500,
        .admin-table td button.bg-red-500,
        .admin-table td button.bg-yellow-500,
        .admin-table td button.bg-orange-500,
        .admin-table td button.bg-gray-500 {
            background-color: rgb(59 130 246) !important; /* blue-500 */
            color: white !important;
            border: none !important;
        }
        .admin-table td button.bg-green-500 {
            background-color: rgb(34 197 94) !important; /* green-500 */
        }
        .admin-table td button.bg-red-500 {
            background-color: rgb(239 68 68) !important; /* red-500 */
        }
        .admin-table td button.bg-yellow-500 {
            background-color: rgb(234 179 8) !important; /* yellow-500 */
        }
        .admin-table td button.bg-orange-500 {
            background-color: rgb(249 115 22) !important; /* orange-500 */
        }
        .admin-table td button.bg-gray-500 {
            background-color: rgb(107 114 128) !important; /* gray-500 */
        }
        .admin-table td a,
        .admin-table td button {
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            z-index: 10 !important;
            white-space: nowrap !important;
            flex-shrink: 0 !important;
            cursor: pointer !important;
            padding: 0.25rem 0.75rem !important;
            border-radius: 0.25rem !important;
            font-size: 0.875rem !important;
        }
        .admin-table td a:hover,
        .admin-table td button:hover {
            opacity: 0.9 !important;
        }
        .admin-table td form {
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            z-index: 10 !important;
            margin: 0 !important;
        }
        .admin-table tbody tr {
            position: relative !important;
        }
        /* overflow-x-autoの親要素も確認 */
        .overflow-x-auto {
            overflow-x: auto !important;
            overflow-y: visible !important;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- 管理画面ヘッダー -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">管理画面 / व्यवस्थापन प्यानल</h1>
                    <div class="flex items-center gap-4">
                        <div class="text-sm text-gray-600">
                            <div>本日のアクセス数: <span class="font-bold text-blue-600">{{ $todayAccessCount ?? \App\Models\AccessLog::getTodayCount() }}</span></div>
                            <div>総アクセス数: <span class="font-bold text-blue-600">{{ $totalAccessCount ?? \App\Models\AccessLog::getTotalCount() }}</span></div>
                        </div>
                        <a href="{{ route('home') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            サイトに戻る / साइटमा फर्कनुहोस्
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- タブナビゲーション -->
        <nav class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex space-x-1">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700 hover:border-b-2 hover:border-gray-300' }}">
                        ダッシュボード / ड्यासबोर्ड
                    </a>
                    <a href="{{ route('admin.announcements.index') }}" 
                       class="px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.announcements.*') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700 hover:border-b-2 hover:border-gray-300' }}">
                        お知らせ / सूचना
                    </a>
                    <a href="{{ route('admin.news.index') }}" 
                       class="px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.news.*') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700 hover:border-b-2 hover:border-gray-300' }}">
                        ニュース / समाचार
                    </a>
                    <a href="{{ route('admin.resume-submissions.index') }}" 
                       class="px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.resume-submissions.*') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700 hover:border-b-2 hover:border-gray-300' }}">
                        履歴書 / रिजुमे
                    </a>
                    <a href="{{ route('admin.career-history-submissions.index') }}" 
                       class="px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.career-history-submissions.*') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700 hover:border-b-2 hover:border-gray-300' }}">
                        職務経歴書 / कार्य अनुभव
                    </a>
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700 hover:border-b-2 hover:border-gray-300' }}">
                        会員情報 / सदस्य जानकारी
                    </a>
                </div>
            </div>
        </nav>

        <!-- メインコンテンツ -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>

