@extends('admin.layouts_admin.master')

@section('title')
    الاعدادات
@endsection
@section('page_name')
    الاعدادات
@endsection
@section('content')
    <form method="POST" id="updateForm" class="updateForm" action="{{ route('setting.update', $settings->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $settings->id }}">
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle mt-5" width="150px" src="{{ asset($settings->teacher_image) }}">
                        <span class="font-weight-bold">{{ $settings->teacher_name_ar }}</span>
                        <span class="text-black-50">{{ $settings->department_ar }}</span>
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">اعدادت حساب تعريفي</h4>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6"><label class="labels">الاسم بالعربي</label><input type="text"
                                    class="form-control" name="teacher_name_ar" placeholder="first name"
                                    value="{{ $settings->teacher_name_ar }}">
                            </div>
                            <div class="col-md-6"><label class="labels">الاسم بالانجليزي</label><input type="text"
                                    class="form-control" name="teacher_name_en" value="{{ $settings->teacher_name_en }}"
                                    placeholder="surname">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6"><label class="labels">الاسم القسم بالعربي</label><input type="text"
                                    class="form-control" name="department_ar" placeholder="first name"
                                    value="{{ $settings->department_ar }}">
                            </div>
                            <div class="col-md-6"><label class="labels">الاسم القسم بالانجليزي</label><input type="text"
                                    class="form-control" name="department_en" value="{{ $settings->department_en }}"
                                    placeholder="surname"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">الهاتف</label><input type="text"
                                    class="form-control" name="sms" placeholder="enter phone number"
                                    value="{{ $settings->sms }}">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">صورة الاستاذ</label>
                                <input class="form-control" name="teacher_image" type="file">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">تفعيل فيدوهات المراجع </label>
                                <select name="videos_resource_active" class="form-control" required>
                                    <option value="active"
                                        {{ $settings->videos_resource_active == 'active' ? 'selected' : '' }}>تفعيل
                                    </option>
                                    <option value="not_active"
                                        {{ $settings->videos_resource_active == 'not_active' ? 'selected' : '' }}> عدم
                                        تفعيل</option>
                                </select>
                            </div> <br>
                            <div class="col-md-12">
                                <label class="labels">تفعيل اللغة </label>
                                <select name="lang" class="form-control" required>
                                    <option value="active" {{ $settings->lang == 'active' ? 'selected' : '' }}>تفعيل
                                    </option>
                                    <option value="not_active" {{ $settings->lang == 'not_active' ? 'selected' : '' }}> عدم
                                        تفعيل</option>
                                </select>
                            </div> <br>
                            <div class="col-md-12">
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
                        </div>
                        <div class="mt-5 text-center">
                            <button type="submit" class="btn btn-primary" id="updateButton">تحديث</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 py-10">
                        <div class="d-flex justify-content-between align-items-center experience"><span>قائمة السوشيال
                                ميديا</span><span class="border px-3 p-1 add-experience"></div><br>
                        <div class="col-md-12">
                            <label class="labels">فيسبوك</label>
                            <input type="text"class="form-control" name="facebook_link" placeholder="experience"
                                value="{{ $settings->facebook_link }}">
                        </div> <br>
                        <div class="col-md-12">
                            <label class="labels">مسنجر</label>
                            <input type="text"class="form-control" name="messenger" placeholder="experience"
                                value="{{ $settings->messenger }}">
                        </div> <br>
                        <div class="col-md-12">
                            <label class="labels">واتساب</label>
                            <input type="text"class="form-control" name="whatsapp_link" placeholder="experience"
                                value="{{ $settings->whatsapp_link }}">
                        </div> <br>
                        <div class="col-md-12">
                            <label class="labels">يوتيوب</label>
                            <input type="text" class="form-control" name="youtube_link"
                                placeholder="additional details" value="{{ $settings->youtube_link }}">
                        </div> <br>
                        <div class="col-md-12">
                            <label class="labels">تويتر</label>
                            <input type="text" class="form-control" name="twitter_link"
                                placeholder="additional details" value="{{ $settings->twitter_link }}">
                        </div> <br>
                        <div class="col-md-12">
                            <label class="labels">انستجرام</label>
                            <input type="text" class="form-control" name="instagram_link"
                                placeholder="additional details" value="{{ $settings->instagram_link }}">
                        </div> <br>
                        <div class="col-md-12">
                            <label class="labels">الموقع</label>
                            <input type="text" class="form-control" name="website_link"
                                placeholder="additional details" value="{{ $settings->website_link }}">
                        </div>
                    </div>
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
