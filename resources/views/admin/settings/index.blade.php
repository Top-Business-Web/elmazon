@extends('Admin/layouts_admin/master')

@section('title')
     الاعدادات
@endsection
@section('page_name')
     الاعدادات
@endsection
@section('content')

<form method="POST" id="updateForm" class="updateForm" action="{{ route('setting.update', $settings->id) }}">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="{{ $settings->id }}">
    <div class="row mt-4">
        <div class="col-4">
            <div class="card" style="padding: 13px">
                <!-- Start Row -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="facebook_link">Facebook :</label>
                            <input type="text" name="facebook_link" value="{{ $settings->facebook_link }}" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Youtube :</label>
                            <input type="text" name="youtube_link" value="{{ $settings->youtube_link }}" value=""
                                class="form-control" />
                        </div>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" id="updateButton">تحديث</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Form -->
    @include('Admin/layouts_admin/myAjaxHelper')
@endsection





