@extends('admin.layouts_admin.master')

@section('title')
    مدير الملفات
@endsection
@section('page_name')
    مدير الملفات
@endsection
@section('content')
{{--    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">--}}
{{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">--}}
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
<style>
    .fm{
        height: 600px !important;
    }
</style>
    <div id="fm"></div>
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>

@endsection
@section('ajaxCalls')

@endsection

