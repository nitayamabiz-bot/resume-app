@extends('admin.layout')

@section('content')
<div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">会員情報詳細</h2>
        <a href="{{ route('admin.users.index') }}" 
           class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            一覧に戻る
        </a>
    </div>

    <div class="space-y-6">
        <!-- 基本情報 -->
        <div class="border rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">基本情報</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">ID</label>
                    <p class="mt-1">{{ $user->id }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">名前</label>
                    <p class="mt-1">{{ $user->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">メールアドレス</label>
                    <p class="mt-1">{{ $user->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">ステータス</label>
                    <p class="mt-1">
                        @if($user->is_blocked)
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-sm">ブロック</span>
                        @elseif($user->is_suspended)
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-sm">停止中</span>
                        @else
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-sm">アクティブ</span>
                        @endif
                    </p>
                </div>
                @if($user->is_blocked && $user->block_reason)
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">ブロック理由</label>
                        <p class="mt-1">{{ $user->block_reason }}</p>
                    </div>
                @endif
                @if($user->is_suspended && $user->suspended_until)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">停止期限</label>
                        <p class="mt-1">{{ $user->suspended_until->format('Y-m-d H:i') }}</p>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700">登録日時</label>
                    <p class="mt-1">{{ $user->created_at->format('Y-m-d H:i:s') }}</p>
                </div>
            </div>
        </div>

        <!-- 履歴書情報 -->
        @if($resumes->count() > 0)
            <div class="border rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">履歴書情報</h3>
                <div class="space-y-2">
                    @foreach($resumes as $resume)
                        <div class="border rounded p-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium">{{ $resume->last_name_roman }} {{ $resume->first_name_roman }}</p>
                                    <p class="text-sm text-gray-600">作成日: {{ $resume->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 操作ボタン -->
        <div class="border rounded-lg p-4 bg-gray-50">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">操作</h3>
            <div class="flex gap-2 flex-wrap">
                <a href="{{ route('admin.users.edit', $user) }}" 
                   class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    編集
                </a>
                @if($user->is_blocked)
                    <form action="{{ route('admin.users.unblock', $user) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            ブロック解除
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.users.block', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('ブロックしますか？');">
                        @csrf
                        <input type="hidden" name="block_reason" value="">
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            ブロック
                        </button>
                    </form>
                @endif
                @if($user->is_suspended)
                    <form action="{{ route('admin.users.unsuspend', $user) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            停止解除
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.users.suspend', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('アカウントを停止しますか？');">
                        @csrf
                        <input type="hidden" name="suspended_until" value="">
                        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600">
                            停止
                        </button>
                    </form>
                @endif
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('削除してもよろしいですか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        削除
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

