@extends('layouts.main')

@section('title', '職務経歴書作成 - 就労支援サービス')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="career-history-container">
    @include('career-history._create_form')
</div>
@endsection

