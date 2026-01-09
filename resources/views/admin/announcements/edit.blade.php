@extends('admin.layout')

@section('content')
<div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
        <h1 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6">お知らせ編集</h1>

        <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium mb-2">
                    タイトル<span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $announcement->title) }}" 
                       required 
                       maxlength="255"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="content" class="block text-sm font-medium mb-2">
                    内容<span class="text-red-500">*</span>
                </label>
                <textarea id="content" 
                          name="content" 
                          rows="8" 
                          required
                          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2">{{ old('content', $announcement->content) }}</textarea>
                @error('content')
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
                       value="{{ old('display_order', $announcement->display_order) }}" 
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
                           {{ old('is_published', $announcement->is_published) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2">公開する</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    更新
                </button>
                <a href="{{ route('admin.announcements.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    キャンセル
                </a>
            </div>
        </form>
    </div>
@endsection

