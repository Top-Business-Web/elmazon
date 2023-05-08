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
                                    <select name="lang" class="form-control">
                                        <option value="active" {{ $settings->is_lang == 'active' ? 'selected' : '' }}>تفعيل
                                        </option>
                                        <option value="not_active"
                                            {{ $settings->is_lang == 'not_active' ? 'selected' : '' }}>
                                            عدم تفعيل
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
                                        <option value="not_active"
                                            {{ $settings->videos_resource_active == 'not_active' ? 'selected' : '' }}> عدم
                                            تفعيل</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <label class="control-label">عبارات دعوة الاصدقاء</label>
                                    <div class="form-group itemItems">
                                        {{-- @dd($share) --}}
                                        @foreach ($settings->share_ar as $share)
                                            <input type="text" name="share_ar[]" class="form-control InputItemExtra"
                                                value="{{ $share }}">
                                            <br>
                                        @endforeach
                                    </div>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <button type="button" class=" mt-5 btn btn-primary MoreItem">المزيد</button>
                                    <button type="button" class=" mt-5 btn btn-danger delItem">حذف</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <label class="control-label">Friends invitation phrases</label>
                                    <div class="form-group itemItems1">
                                        @foreach ($settings->share_en as $share)
                                            {{-- @dd($share) --}}
                                            <input type="text" name="share_en[]" class="form-control InputItemExtra1"
                                                value="{{ $share }}">
                                            <br>
                                        @endforeach
                                    </div>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <button type="button" class=" mt-5 btn btn-primary MoreItem1">المزيد</button>
                                    <button type="button" class=" mt-5 btn btn-danger delItem1">حذف</button>
                                </div>
                                <span class="badge Issue1 badge-danger"></span>
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

        $(document).on('click', '.delItem', function() {
            var Item = $('.InputItemExtra').last();
            if (Item.val() == '') {
                Item.fadeOut();
                Item.remove();
                $('.Issue').removeClass('badge-danger').addClass('badge-success');
                $('.Issue').html('The element deleted');
                setTimeout(function() {
                    $('.Issue').html('');
                }, 3000)
            } else {
                $('.Issue').html('The element must be empty');
                setTimeout(function() {
                    $('.Issue').html('');
                }, 3000)

            }
        })

        $(document).on('click', '.MoreItem', function() {
            var Item = $('.InputItemExtra').last();
            if (Item.val() !== '') {
                $('.itemItems').append(
                    '<input type="text" name="share_ar[]" class="form-control InputItemExtra mt-3">')
            }
        })


        $(document).on('click', '.delItem1', function() {
            var Item = $('.InputItemExtra1').last();
            if (Item.val() == '') {
                Item.fadeOut();
                Item.remove();
                $('.Issue1').removeClass('badge-danger').addClass('badge-success');
                $('.Issue1').html('The element deleted');
                setTimeout(function() {
                    $('.Issue1').html('');
                }, 3000)
            } else {
                $('.Issue1').html('The element must be empty');
                setTimeout(function() {
                    $('.Issue').html('');
                }, 3000)

            }
        })

        $(document).on('click', '.MoreItem1', function() {
            var Item = $('.InputItemExtra1').last();
            if (Item.val() !== '') {
                $('.itemItems1').append(
                    '<input type="text" name="share_en[]" class="form-control InputItemExtra1 mt-3">')
            }
        })
    </script>
@endsection
