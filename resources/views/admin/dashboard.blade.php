@extends('admin.layout')

@section('content')
<div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
    <h2 class="text-xl font-bold mb-6">ダッシュボード</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-2">本日のアクセス数</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $todayAccessCount }}</p>
        </div>
        
        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-green-900 mb-2">総アクセス数</h3>
            <p class="text-3xl font-bold text-green-600">{{ $totalAccessCount }}</p>
        </div>
    </div>

    <div class="bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-4">クイックアクセス</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.announcements.create') }}" 
               class="block p-4 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <span class="font-medium">お知らせを新規作成</span>
            </a>
            <a href="{{ route('admin.news.create') }}" 
               class="block p-4 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <span class="font-medium">ニュースを新規作成</span>
            </a>
            <a href="{{ route('admin.resume-submissions.index') }}" 
               class="block p-4 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <span class="font-medium">履歴書一覧を表示</span>
            </a>
        </div>
    </div>
</div>
@endsection

