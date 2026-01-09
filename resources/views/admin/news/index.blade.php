@extends('admin.layout')

@section('content')
<div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
        <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h1 class="text-xl sm:text-2xl font-bold">ニュース管理</h1>
            <a href="{{ route('admin.news.create') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm whitespace-nowrap">
                新規作成
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

        <div class="overflow-x-auto">
            <table class="w-full border-collapse admin-table">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-3 text-left">表示順</th>
                        <th class="border p-3 text-left">タイトル</th>
                        <th class="border p-3 text-left">カテゴリ</th>
                        <th class="border p-3 text-left">公開状態</th>
                        <th class="border p-3 text-left">投稿日</th>
                        <th class="border p-3 text-left">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $item)
                        <tr>
                            <td class="border p-3">{{ $item->display_order }}</td>
                            <td class="border p-3">{{ $item->title }}</td>
                            <td class="border p-3">
                                {{ $item->category === 'domestic' ? '国内' : '国外' }}
                            </td>
                            <td class="border p-3">
                                @if($item->is_published)
                                    <span class="text-green-600">公開中</span>
                                @else
                                    <span class="text-gray-500">非公開</span>
                                @endif
                            </td>
                            <td class="border p-3">{{ $item->published_date->format('Y-m-d') }}</td>
                            <td class="border p-3">
                                <div class="flex gap-2 flex-wrap">
                                    <a href="{{ route('admin.news.edit', $item) }}" class="inline-block px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600 whitespace-nowrap">
                                        編集
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $item) }}" method="POST" onsubmit="return confirm('削除してもよろしいですか？');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600 whitespace-nowrap">
                                            削除
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="border p-3 text-center text-gray-500">
                                ニュースがありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

