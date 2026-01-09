@extends('admin.layout')

@section('content')
<div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
        <h1 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6">ニュース作成</h1>

        <form action="{{ route('admin.news.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium mb-2">
                    タイトル<span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}" 
                       required 
                       maxlength="255"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image_url" class="block text-sm font-medium mb-2">
                    画像URL
                </label>
                <input type="url" 
                       id="image_url" 
                       name="image_url" 
                       value="{{ old('image_url') }}" 
                       maxlength="500"
                       placeholder="https://example.com/image.jpg"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2">
                <p class="text-xs text-gray-500 mt-1">画像URLが未指定の場合は、デフォルト画像が表示されます</p>
                @error('image_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="external_url" class="block text-sm font-medium mb-2">
                    外部リンクURL<span class="text-red-500">*</span>
                </label>
                <input type="url" 
                       id="external_url" 
                       name="external_url" 
                       value="{{ old('external_url') }}" 
                       required 
                       maxlength="500"
                       placeholder="https://example.com/article"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2">
                @error('external_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="category" class="block text-sm font-medium mb-2">
                    カテゴリ<span class="text-red-500">*</span>
                </label>
                <select id="category" 
                        name="category" 
                        required
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2">
                    <option value="domestic" {{ old('category') === 'domestic' ? 'selected' : '' }}>国内</option>
                    <option value="international" {{ old('category') === 'international' ? 'selected' : '' }}>国外</option>
                </select>
                @error('category')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="published_date" class="block text-sm font-medium mb-2">
                    投稿日<span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       id="published_date" 
                       name="published_date" 
                       value="{{ old('published_date', date('Y-m-d')) }}" 
                       required
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2">
                @error('published_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="display_order" class="block text-sm font-medium mb-2">
                    表示順
                </label>
                <input type="number" 
                       id="display_order" 
                       name="display_order" 
                       value="{{ old('display_order', 0) }}" 
                       min="0"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2">
                <p class="text-xs text-gray-500 mt-1">数値が小さいほど上に表示されます</p>
                @error('display_order')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" 
                           name="is_published" 
                           value="1" 
                           {{ old('is_published') ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2">公開する</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    作成
                </button>
                <a href="{{ route('admin.news.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    キャンセル
                </a>
            </div>
        </form>
    </div>
@endsection

