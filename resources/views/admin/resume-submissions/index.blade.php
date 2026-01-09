@extends('admin.layout')

@section('content')
<div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
    <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6">履歴書提出一覧</h2>

    <!-- 検索フォーム -->
    <div class="mb-4 bg-gray-50 rounded-lg p-2">
        <form method="GET" action="{{ route('admin.resume-submissions.index') }}" class="space-y-1.5">
            <div class="flex flex-wrap gap-2 items-end">
                <div class="min-w-[120px]">
                    <label class="block text-xs font-medium text-gray-700 mb-0.5">名前</label>
                    <input type="text" name="search_name" value="{{ request('search_name') }}" 
                           class="w-full border rounded px-1 py-0.5 text-xs" placeholder="検索" style="max-width: 120px;">
                </div>
                <div class="min-w-[140px]">
                    <label class="block text-xs font-medium text-gray-700 mb-0.5">メール</label>
                    <input type="text" name="search_email" value="{{ request('search_email') }}" 
                           class="w-full border rounded px-1 py-0.5 text-xs" placeholder="検索" style="max-width: 140px;">
                </div>
                <div class="min-w-[110px]">
                    <label class="block text-xs font-medium text-gray-700 mb-0.5">電話</label>
                    <input type="text" name="search_phone" value="{{ request('search_phone') }}" 
                           class="w-full border rounded px-1 py-0.5 text-xs" placeholder="検索" style="max-width: 110px;">
                </div>
                <div class="min-w-[120px]">
                    <label class="block text-xs font-medium text-gray-700 mb-0.5">開始日</label>
                    <input type="date" name="search_date_from" value="{{ request('search_date_from') }}" 
                           class="w-full border rounded px-1 py-0.5 text-xs" style="max-width: 120px;">
                </div>
                <div class="min-w-[120px]">
                    <label class="block text-xs font-medium text-gray-700 mb-0.5">終了日</label>
                    <input type="date" name="search_date_to" value="{{ request('search_date_to') }}" 
                           class="w-full border rounded px-1 py-0.5 text-xs" style="max-width: 120px;">
                </div>
                <div class="min-w-[80px]">
                    <label class="block text-xs font-medium text-gray-700 mb-0.5">表示</label>
                    <select name="per_page" class="w-full border rounded px-1 py-0.5 text-xs" style="max-width: 80px;">
                        <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
                <div class="flex gap-1.5 items-end">
                    <button type="submit" class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs whitespace-nowrap">
                        検索
                    </button>
                    @if(request()->hasAny(['search_name', 'search_email', 'search_phone', 'search_date_from', 'search_date_to']))
                        <a href="{{ route('admin.resume-submissions.index') }}" 
                           class="px-2 py-1 text-blue-600 hover:text-blue-800 text-xs whitespace-nowrap">
                            クリア
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- 一覧テーブル -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse admin-table">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-3 text-left">
                        <a href="{{ route('admin.resume-submissions.index', array_merge(request()->all(), ['sort_by' => 'created_at', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}" 
                           class="hover:text-blue-600">
                            提出日時
                            @if(request('sort_by') == 'created_at')
                                {{ request('sort_order') == 'asc' ? '▲' : '▼' }}
                            @endif
                        </a>
                    </th>
                    <th class="border p-3 text-left">名前</th>
                    <th class="border p-3 text-left">メールアドレス</th>
                    <th class="border p-3 text-left">電話番号</th>
                    <th class="border p-3 text-left">操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submissions as $submission)
                    <tr class="hover:bg-gray-50">
                        <td class="border p-3">{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                        <td class="border p-3">
                            {{ $submission->last_name_roman }} {{ $submission->first_name_roman }}<br>
                            <span class="text-sm text-gray-500">{{ $submission->last_name_kana }} {{ $submission->first_name_kana }}</span>
                        </td>
                        <td class="border p-3">{{ $submission->email }}</td>
                        <td class="border p-3">{{ $submission->phone }}</td>
                        <td class="border p-3">
                            <a href="{{ route('admin.resume-submissions.show', $submission) }}" 
                               class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
                                詳細
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border p-3 text-center text-gray-500">
                            履歴書提出がありません
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ページネーション -->
    @if($submissions->hasPages())
        <div class="mt-6">
            {{ $submissions->links() }}
        </div>
    @endif

    <div class="mt-4 text-sm text-gray-600">
        全{{ $submissions->total() }}件中 {{ $submissions->firstItem() ?? 0 }}-{{ $submissions->lastItem() ?? 0 }}件を表示 / 
        कुल {{ $submissions->total() }} मध्ये {{ $submissions->firstItem() ?? 0 }}-{{ $submissions->lastItem() ?? 0 }} देखाउनुहोस्
    </div>
</div>
@endsection

