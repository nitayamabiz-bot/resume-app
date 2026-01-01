@extends('admin.layout')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6">会員情報一覧 / सदस्य जानकारी सूची</h2>

    <!-- 検索フォーム -->
    <div class="mb-4 bg-gray-50 rounded-lg p-2">
        <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-1.5">
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
                <div class="min-w-[100px]">
                    <label class="block text-xs font-medium text-gray-700 mb-0.5">ステータス</label>
                    <select name="status" class="w-full border rounded px-1 py-0.5 text-xs" style="max-width: 100px;">
                        <option value="">すべて</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>アクティブ</option>
                        <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>ブロック</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>停止中</option>
                    </select>
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
                    @if(request()->hasAny(['search_name', 'search_email', 'status', 'search_date_from', 'search_date_to']))
                        <a href="{{ route('admin.users.index') }}" 
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
                    <th class="border p-3 text-left">ID</th>
                    <th class="border p-3 text-left">名前 / नाम</th>
                    <th class="border p-3 text-left">メールアドレス / इमेल</th>
                    <th class="border p-3 text-left">ステータス / स्थिति</th>
                    <th class="border p-3 text-left">登録日 / दर्ता मिति</th>
                    <th class="border p-3 text-left">操作 / कार्य</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="border p-3">{{ $user->id }}</td>
                        <td class="border p-3">{{ $user->name }}</td>
                        <td class="border p-3">{{ $user->email }}</td>
                        <td class="border p-3">
                            @if($user->is_blocked)
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-sm">ブロック / अवरुद्ध</span>
                            @elseif($user->is_suspended)
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-sm">停止中 / निलम्बित</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-sm">アクティブ / सक्रिय</span>
                            @endif
                        </td>
                        <td class="border p-3">{{ $user->created_at->format('Y-m-d H:i') }}</td>
                        <td class="border p-3">
                            <div class="flex gap-2 flex-wrap">
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="inline-block px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600 whitespace-nowrap">
                                    詳細 / विवरण
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="inline-block px-3 py-1 bg-green-500 text-white rounded text-sm hover:bg-green-600 whitespace-nowrap">
                                    編集 / सम्पादन
                                </a>
                                @if($user->is_blocked)
                                    <form action="{{ route('admin.users.unblock', $user) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-yellow-500 text-white rounded text-sm hover:bg-yellow-600 whitespace-nowrap">
                                            ブロック解除 / अवरुद्ध हटाउनुहोस्
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.users.block', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('ブロックしますか？ / अवरुद्ध गर्नुहुन्छ?');">
                                        @csrf
                                        <input type="hidden" name="block_reason" value="">
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600 whitespace-nowrap">
                                            ブロック / अवरुद्ध
                                        </button>
                                    </form>
                                @endif
                                @if($user->is_suspended)
                                    <form action="{{ route('admin.users.unsuspend', $user) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-yellow-500 text-white rounded text-sm hover:bg-yellow-600 whitespace-nowrap">
                                            停止解除 / निलम्बन हटाउनुहोस्
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.users.suspend', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('アカウントを停止しますか？ / खाता निलम्बन गर्नुहुन्छ?');">
                                        @csrf
                                        <input type="hidden" name="suspended_until" value="">
                                        <button type="submit" class="px-3 py-1 bg-orange-500 text-white rounded text-sm hover:bg-orange-600 whitespace-nowrap">
                                            停止 / निलम्बन
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('削除してもよろしいですか？ / के तपाईं मेटाउन चाहनुहुन्छ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-gray-500 text-white rounded text-sm hover:bg-gray-600 whitespace-nowrap">
                                        削除 / मेटाउनुहोस्
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="border p-3 text-center text-gray-500">
                            会員がありません / कुनै सदस्य छैन
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ページネーション -->
    @if($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif

    <div class="mt-4 text-sm text-gray-600">
        全{{ $users->total() }}件中 {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }}件を表示 / 
        कुल {{ $users->total() }} मध्ये {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} देखाउनुहोस्
    </div>
</div>
@endsection

