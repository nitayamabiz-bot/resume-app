@extends('admin.layout')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">職務経歴書詳細 / कार्य अनुभव विवरण</h2>
        <a href="{{ route('admin.career-history-submissions.index') }}" 
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
                    <p class="mt-1">{{ $careerHistorySubmission->last_name_roman }} {{ $careerHistorySubmission->first_name_roman }}</p>
                </div>
            </div>
        </div>

        <!-- 職務要約 -->
        @if($careerHistorySubmission->job_summary)
            <div class="border rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">職務要約 / कार्य सारांश</h3>
                <p class="whitespace-pre-wrap">{{ $careerHistorySubmission->job_summary }}</p>
            </div>
        @endif

        <!-- 職務経歴 -->
        <div class="border rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">職務経歴 / कार्य अनुभव</h3>
            @if(!empty($careerHistorySubmission->career_histories) && count($careerHistorySubmission->career_histories) > 0)
                <div class="space-y-3">
                    @foreach($careerHistorySubmission->career_histories as $index => $career)
                        <div class="border rounded p-3 bg-gray-50">
                            <div class="space-y-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">会社名 / कम्पनीको नाम</label>
                                    <p class="text-sm font-bold">{{ $career['company_name'] ?? '-' }}</p>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">期間 / अवधि</label>
                                        <p class="text-sm">
                                            @if(!empty($career['start_date']))
                                                @php
                                                    $startDate = $career['start_date'];
                                                    if (preg_match('/^(\d{4})-(\d{2})$/', $startDate, $matches)) {
                                                        echo $matches[1].'年'.(int)$matches[2].'月';
                                                    } else {
                                                        echo $startDate;
                                                    }
                                                @endphp
                                            @else
                                                -
                                            @endif
                                            ～
                                            @if(!empty($career['end_date']) && $career['end_date'] !== '現在')
                                                @php
                                                    $endDate = $career['end_date'];
                                                    if (preg_match('/^(\d{4})-(\d{2})$/', $endDate, $matches)) {
                                                        echo $matches[1].'年'.(int)$matches[2].'月';
                                                    } else {
                                                        echo $endDate;
                                                    }
                                                @endphp
                                            @else
                                                {{ $career['end_date'] ?? '-' }}
                                            @endif
                                        </p>
                                    </div>
                                    @if(!empty($career['business_content']))
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">事業内容 / व्यवसाय सामग्री</label>
                                            <p class="text-sm">{{ $career['business_content'] }}</p>
                                        </div>
                                    @endif
                                    @if(!empty($career['employee_count']))
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">従業員数 / कर्मचारी संख्या</label>
                                            <p class="text-sm">{{ $career['employee_count'] }}</p>
                                        </div>
                                    @endif
                                    @if(!empty($career['capital']))
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">資本金 / पूंजी</label>
                                            <p class="text-sm">{{ $career['capital'] }}</p>
                                        </div>
                                    @endif
                                </div>
                                @if(!empty($career['job_description']))
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">職務内容 / कार्य विवरण</label>
                                        <p class="text-sm whitespace-pre-wrap">{{ $career['job_description'] }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">職務経歴情報がありません / कुनै कार्य अनुभव जानकारी छैन</p>
            @endif
        </div>

        <!-- 自己PR -->
        @if($careerHistorySubmission->self_pr)
            <div class="border rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">自己PR / आफ्नो PR</h3>
                <p class="whitespace-pre-wrap">{{ $careerHistorySubmission->self_pr }}</p>
            </div>
        @endif

        <!-- システム情報 -->
        <div class="border rounded-lg p-4 bg-gray-50">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">システム情報 / प्रणाली जानकारी</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <label class="block text-sm font-medium text-gray-700">提出日時 / सबमिट मिति</label>
                    <p class="mt-1">{{ $careerHistorySubmission->created_at->format('Y-m-d H:i:s') }}</p>
                </div>
                @if($careerHistorySubmission->user_id)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ユーザーID / प्रयोगकर्ता ID</label>
                        <p class="mt-1">{{ $careerHistorySubmission->user_id }}</p>
                    </div>
                @endif
                @if($careerHistorySubmission->ip_address)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">IPアドレス / IP ठेगाना</label>
                        <p class="mt-1">{{ $careerHistorySubmission->ip_address }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

