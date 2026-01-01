@extends('admin.layout')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">お知らせ作成 / सूचना सिर्जना</h1>

        <form action="{{ route('admin.announcements.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium mb-2">
                    タイトル / शीर्षक <span class="text-red-500">*</span>
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
                <label for="content" class="block text-sm font-medium mb-2">
                    内容 / सामग्री <span class="text-red-500">*</span>
                </label>
                <textarea id="content" 
                          name="content" 
                          rows="8" 
                          required
                          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="display_order" class="block text-sm font-medium mb-2">
                    表示順 / प्रदर्शन क्रम
                </label>
                <input type="number" 
                       id="display_order" 
                       name="display_order" 
                       value="{{ old('display_order', 0) }}" 
                       min="0"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2">
                <p class="text-xs text-gray-500 mt-1">数値が小さいほど上に表示されます / सानो संख्या माथि प्रदर्शन हुन्छ</p>
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
                    <span class="ml-2">公開する / सार्वजनिक गर्नुहोस्</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    作成 / सिर्जना गर्नुहोस्
                </button>
                <a href="{{ route('admin.announcements.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    キャンセル / रद्द गर्नुहोस्
                </a>
            </div>
        </form>
    </div>
@endsection

