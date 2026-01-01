@extends('admin.layout')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">履歴書詳細 / रिजुमे विवरण</h2>
        <a href="{{ route('admin.resume-submissions.index') }}" 
           class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            一覧に戻る / सूचीमा फर्कनुहोस्
        </a>
    </div>

    <div class="space-y-6">
        <!-- 基本情報 -->
        <div class="border rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">基本情報 / मौलिक जानकारी</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">名前（ローマ字）/ नाम (रोमन)</label>
                    <p class="mt-1">{{ $resumeSubmission->last_name_roman }} {{ $resumeSubmission->first_name_roman }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">名前（ふりがな）/ नाम (काना)</label>
                    <p class="mt-1">{{ $resumeSubmission->last_name_kana }} {{ $resumeSubmission->first_name_kana }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">生年月日 / जन्म मिति</label>
                    <p class="mt-1">{{ $resumeSubmission->birthday?->format('Y年n月j日') ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">性別 / लिङ्ग</label>
                    <p class="mt-1">{{ $resumeSubmission->gender }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">電話番号 / फोन नम्बर</label>
                    <p class="mt-1">{{ $resumeSubmission->phone }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">メールアドレス / इमेल ठेगाना</label>
                    <p class="mt-1">{{ $resumeSubmission->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">郵便番号 / डाक कोड</label>
                    <p class="mt-1">{{ $resumeSubmission->postal_code }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">住所（ふりがな）/ ठेगाना (काना)</label>
                    <p class="mt-1">{{ $resumeSubmission->address_kana }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">住所 / ठेगाना</label>
                    <p class="mt-1">{{ $resumeSubmission->address }}</p>
                </div>
            </div>
        </div>

        <!-- 学歴 -->
        <div class="border rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">学歴 / शैक्षिक योग्यता</h3>
            @if(!empty($resumeSubmission->education) && count($resumeSubmission->education) > 0)
                <div class="space-y-3">
                    @foreach($resumeSubmission->education as $index => $edu)
                        <div class="border rounded p-3 bg-gray-50">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">年月 / वर्ष महिना</label>
                                    <p class="text-sm">{{ $edu['date'] ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">学校名 / स्कूलको नाम</label>
                                    <p class="text-sm">{{ $edu['school_name'] ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">区分 / प्रकार</label>
                                    <p class="text-sm">{{ $edu['event_type'] ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">学歴情報がありません / कुनै शैक्षिक जानकारी छैन</p>
            @endif
        </div>

        <!-- 職歴 -->
        <div class="border rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">職歴 / कामको अनुभव</h3>
            @if(!empty($resumeSubmission->work_history) && count($resumeSubmission->work_history) > 0)
                <div class="space-y-3">
                    @foreach($resumeSubmission->work_history as $index => $work)
                        <div class="border rounded p-3 bg-gray-50">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">年月 / वर्ष महिना</label>
                                    <p class="text-sm">{{ $work['date'] ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">会社名 / कम्पनीको नाम</label>
                                    <p class="text-sm">{{ $work['company_name'] ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">区分 / प्रकार</label>
                                    <p class="text-sm">{{ $work['event_type'] ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">職歴情報がありません / कुनै कामको अनुभव छैन</p>
            @endif
        </div>

        <!-- 免許・資格 -->
        <div class="border rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">免許・資格 / लाइसेन्स र योग्यता</h3>
            @if(!empty($resumeSubmission->licenses) && count($resumeSubmission->licenses) > 0)
                <div class="space-y-3">
                    @foreach($resumeSubmission->licenses as $index => $license)
                        <div class="border rounded p-3 bg-gray-50">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">年月 / वर्ष महिना</label>
                                    <p class="text-sm">{{ $license['date'] ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">名称 / नाम</label>
                                    <p class="text-sm">{{ $license['name'] ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">区分 / प्रकार</label>
                                    <p class="text-sm">{{ $license['event_type'] ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">免許・資格情報がありません / कुनै लाइसेन्स वा योग्यता छैन</p>
            @endif
        </div>

        <!-- 志望動機 -->
        @if($resumeSubmission->appeal_points)
            <div class="border rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">志望動機・特技・アピールポイント / आफ्नो तयारी, रुचि, विशेषता</h3>
                <p class="whitespace-pre-wrap">{{ $resumeSubmission->appeal_points }}</p>
            </div>
        @endif

        <!-- 本人希望欄 -->
        @if($resumeSubmission->self_request)
            <div class="border rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">本人希望欄 / आफ्नो चाहना</h3>
                <p class="whitespace-pre-wrap">{{ $resumeSubmission->self_request }}</p>
            </div>
        @endif

        <!-- システム情報 -->
        <div class="border rounded-lg p-4 bg-gray-50">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">システム情報 / प्रणाली जानकारी</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <label class="block text-sm font-medium text-gray-700">提出日時 / सबमिट मिति</label>
                    <p class="mt-1">{{ $resumeSubmission->created_at->format('Y-m-d H:i:s') }}</p>
                </div>
                @if($resumeSubmission->user_id)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ユーザーID / प्रयोगकर्ता ID</label>
                        <p class="mt-1">{{ $resumeSubmission->user_id }}</p>
                    </div>
                @endif
                @if($resumeSubmission->ip_address)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">IPアドレス / IP ठेगाना</label>
                        <p class="mt-1">{{ $resumeSubmission->ip_address }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

