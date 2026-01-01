@extends('admin.layout')

@section('content')
<div class="main-content" style="max-width: 1000px; margin: 0 auto; padding: 40px 20px;">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">ニュース管理 / समाचार व्यवस्थापन</h1>
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
                        <th class="border p-3 text-left">表示順 / प्रदर्शन क्रम</th>
                        <th class="border p-3 text-left">タイトル / शीर्षक</th>
                        <th class="border p-3 text-left">カテゴリ / श्रेणी</th>
                        <th class="border p-3 text-left">公開状態 / सार्वजनिक स्थिति</th>
                        <th class="border p-3 text-left">投稿日 / प्रकाशन मिति</th>
                        <th class="border p-3 text-left">操作 / कार्य</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $item)
                        <tr>
                            <td class="border p-3">{{ $item->display_order }}</td>
                            <td class="border p-3">{{ $item->title }}</td>
                            <td class="border p-3">
                                {{ $item->category === 'domestic' ? '国内 / घरेलु' : '国外 / अन्तर्राष्ट्रिय' }}
                            </td>
                            <td class="border p-3">
                                @if($item->is_published)
                                    <span class="text-green-600">公開中 / सार्वजनिक</span>
                                @else
                                    <span class="text-gray-500">非公開 / निजी</span>
                                @endif
                            </td>
                            <td class="border p-3">{{ $item->published_date->format('Y-m-d') }}</td>
                            <td class="border p-3">
                                <div class="flex gap-2 flex-wrap">
                                    <a href="{{ route('admin.news.edit', $item) }}" class="inline-block px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600 whitespace-nowrap">
                                        編集 / सम्पादन
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $item) }}" method="POST" onsubmit="return confirm('削除してもよろしいですか？ / के तपाईं मेटाउन चाहनुहुन्छ?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600 whitespace-nowrap">
                                            削除 / मेटाउनुहोस्
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="border p-3 text-center text-gray-500">
                                ニュースがありません / कुनै समाचार छैन
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

