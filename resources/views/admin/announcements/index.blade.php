@extends('layouts.main')

@section('title', 'お知らせ管理 - 就労支援サービス')

@section('content')
<div class="main-content" style="max-width: 1000px; margin: 0 auto; padding: 40px 20px;">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">お知らせ管理 / सूचना व्यवस्थापन</h1>
            <a href="{{ route('admin.announcements.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                新規作成 / नयाँ सिर्जना
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if($announcements->count() >= 20)
            <div class="mb-4 p-4 bg-yellow-100 text-yellow-700 rounded">
                お知らせは最大20件まで登録できます。削除してから新しいお知らせを作成してください。
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-3 text-left">表示順 / प्रदर्शन क्रम</th>
                        <th class="border p-3 text-left">タイトル / शीर्षक</th>
                        <th class="border p-3 text-left">公開状態 / सार्वजनिक स्थिति</th>
                        <th class="border p-3 text-left">作成日時 / सिर्जना मिति</th>
                        <th class="border p-3 text-left">操作 / कार्य</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($announcements as $announcement)
                        <tr>
                            <td class="border p-3">{{ $announcement->display_order }}</td>
                            <td class="border p-3">{{ $announcement->title }}</td>
                            <td class="border p-3">
                                @if($announcement->is_published)
                                    <span class="text-green-600">公開中 / सार्वजनिक</span>
                                @else
                                    <span class="text-gray-500">非公開 / निजी</span>
                                @endif
                            </td>
                            <td class="border p-3">{{ $announcement->created_at->format('Y-m-d H:i') }}</td>
                            <td class="border p-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
                                        編集 / सम्पादन
                                    </a>
                                    <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('削除してもよろしいですか？ / के तपाईं मेटाउन चाहनुहुन्छ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600">
                                            削除 / मेटाउनुहोस्
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border p-3 text-center text-gray-500">
                                お知らせがありません / कुनै सूचना छैन
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-sm text-gray-600">
            登録件数: {{ $announcements->count() }} / 20件 / दर्ता संख्या: {{ $announcements->count() }} / २०
        </div>
    </div>
</div>
@endsection

