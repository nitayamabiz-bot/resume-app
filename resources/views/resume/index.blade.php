@extends('layouts.main')

@section('title', '履歴書作成 - 就労支援サービス')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<style>
    /* 入力画面のコンテンツのみ1000pxに制限 */
    .main-content .resume-container {
        max-width: 1000px;
        margin: 0 auto;
    }
</style>

<!-- コンテンツ部分 -->
<div class="resume-container">
    @if(isset($showConfirm) && $showConfirm)
        @include('resume.confirm')
    @else
        @include('resume._create_form', ['resumeData' => $resumeData ?? null])
    @endif
</div>

<script>
    // グローバル関数として定義（_create_form.blade.phpで使用される可能性があるため）
    window.showConfirm = function() {
        // 内容確認画面に遷移する処理は必要に応じて実装
        window.location.href = '{{ route("resume.index") }}?showConfirm=1';
    };
    
    window.backToForm = function() {
        window.location.href = '{{ route("resume.index") }}';
    };
</script>
@endsection
