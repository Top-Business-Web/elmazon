@extends('admin.layouts_admin.master')

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
            <div class="col-12">
                <div class="card" style="padding: 13px">
                    <div class="card-header">
                        <h3 class="card-title">قائمة السوشيال ميديا </h3>
                    </div>

                    <div class="card" style="padding: 13px">
                        <!-- Start Row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="facebook">فيسبوك :</label>
                                    <input type="text" name="facebook_link" value="{{ $settings->facebook_link }}"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">يوتيوب :</label>
                                    <input type="text" name="youtube_link" value="{{ $settings->youtube_link }}"
                                        value="" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="twitter">تويتر :</label>
                                    <input type="text" name="twitter_link" value="{{ $settings->twitter_link }}"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">انستجرام :</label>
                                    <input type="text" name="instagram_link" value="{{ $settings->instagram_link }}"
                                        value="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">لينك الموقع :</label>
                                    <input type="text" name="website_link" value="{{ $settings->website_link }}"
                                        value="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for=""> تفعيل اللغة الاجنبية :</label>
                                    <select name="is_lang" class="form-control">
                                        <option value="1" {{ $settings->is_lang == '1' ? 'selected' : '' }}>تفعيل
                                        </option>
                                        <option value="0" {{ $settings->is_lang == '0' ? 'selected' : '' }}> عدم تفعيل
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for=""> تفعيل فيدوهات المراجع :</label>

                                    <select name="videos_resource_active" class="form-control">
                                        <option value="active"
                                            {{ $settings->videos_resource_active == 'active' ? 'selected' : '' }}>تفعيل
                                        </option>
                                        <option value="un_active"
                                            {{ $settings->videos_resource_active == 'un_active' ? 'selected' : '' }}> عدم
                                            تفعيل</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary" id="updateButton">تحديث</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- End Form -->
    @include('admin.layouts_admin.myAjaxHelper')
    <script>
        editScript();
    </script>
@endsection
