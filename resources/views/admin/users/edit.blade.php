@extends('admin.layout')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">会員情報編集 / सदस्य जानकारी सम्पादन</h2>
        <a href="{{ route('admin.users.show', $user) }}" 
           class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            詳細に戻る / विवरणमा फर्कनुहोस्
        </a>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    名前 / नाम <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $user->name) }}" 
                       required 
                       maxlength="255"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    メールアドレス / इमेल ठेगाना <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $user->email) }}" 
                       required 
                       maxlength="255"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" 
                           name="is_blocked" 
                           value="1" 
                           {{ old('is_blocked', $user->is_blocked) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2">ブロック / अवरुद्ध</span>
                </label>
            </div>

            <div>
                <label for="block_reason" class="block text-sm font-medium text-gray-700 mb-1">
                    ブロック理由 / अवरुद्ध कारण
                </label>
                <textarea id="block_reason" 
                          name="block_reason" 
                          rows="3" 
                          maxlength="500"
                          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2">{{ old('block_reason', $user->block_reason) }}</textarea>
                @error('block_reason')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" 
                           name="is_suspended" 
                           value="1" 
                           {{ old('is_suspended', $user->is_suspended) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2">アカウント停止 / खाता निलम्बन</span>
                </label>
            </div>

            <div>
                <label for="suspended_until" class="block text-sm font-medium text-gray-700 mb-1">
                    停止期限 / निलम्बन म्याद
                </label>
                <input type="datetime-local" 
                       id="suspended_until" 
                       name="suspended_until" 
                       value="{{ old('suspended_until', $user->suspended_until ? $user->suspended_until->format('Y-m-d\TH:i') : '') }}" 
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2">
                @error('suspended_until')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    更新 / अपडेट गर्नुहोस्
                </button>
                <a href="{{ route('admin.users.show', $user) }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    キャンセル / रद्द गर्नुहोस्
                </a>
            </div>
        </div>
    </form>
</div>
@endsection

