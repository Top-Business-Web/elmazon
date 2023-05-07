@extends('admin.layouts_admin.master')
@section('title')
    {{ $setting->title ?? '' }} معلومات عن الاستاذ
@endsection

@section('page_name')
    معلومات عن الاستاذ
@endsection
@section('content')
    @foreach ($about_me as $teacher)
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="wideget-user text-center">
                            <div class="wideget-user-desc">
                                <div class="wideget-user-img">
                                    <img class="" src="" alt="img">
                                </div>
                                <div class="user-wrap">
                                    <h4 class="mb-1 text-capitalize"></h4>
                                    <h6 class="badge badge-primary-gradient"></h6>
                                    <h6 class="text-muted mb-4"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-8">
                <div class="card">
                    <div class="wideget-user-tab">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu1">
                                <ul class="nav">
                                    <li class=""><a href="#tab-51" class="active show" data-toggle="tab">معلومات</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab-51">
                        <div class="card">
                            <div class="card-body">
                                <div id="profile-log-switch">
                                    <div class="media-heading">
                                        <h5><strong>معلومات الاستاذ</strong></h5>
                                    </div>
                                    <div class="table-responsive ">
                                        <table class="table row table-borderless">

                                            <tbody class="col-lg-12 col-xl-4 p-0">
                                                <tr>
                                                    <td class="text-capitalize"><strong>الاسم بالعربي
                                                            :</strong> {{ $teacher->teacher_name_ar }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-capitalize"><strong>الاسم بالانجليزي
                                                            :</strong> {{ $teacher->teacher_name_en }}</td>
                                                </tr>
                                            </tbody>
                                            <tbody class="col-lg-12 col-xl-4 p-0">
                                                <tr>
                                                    <td><strong>القسم بالعربي :</strong> {{ $teacher->department_ar }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>القسم بالانجليزي :</strong> {{ $teacher->department_en }}
                                                    </td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                    <button class="btn btn-purple-gradient" data-toggle="modal"
                                        data-target="#editAbout">تعديل
                                    </button>
                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editAbout" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel bd-example-modal-lg" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">تعديل</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" id="modal-body">
                                                    <form class="updateForm" id="updateForm"
                                                        action="{{ route('aboutMes.update', $teacher->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" value="{{ $teacher->id }}" name="id">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="teacher_name_ar">الاسم بالعربي</label>
                                                                    <input class="form-control"
                                                                        value="{{ $teacher->teacher_name_ar }}"
                                                                        name="teacher_name_ar" />
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="teacher_name_en">الاسم بالانجليزي</label>
                                                                    <input class="form-control"
                                                                        value="{{ $teacher->teacher_name_en }}"
                                                                        name="teacher_name_en" />
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="department_ar">القسم بالعربي</label>
                                                                    <input class="form-control"
                                                                        value=" {{ $teacher->department_ar }}"
                                                                        name="department_ar" />
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="department_en">القسم بالانجليزي</label>
                                                                    <input class="form-control"
                                                                        value=" {{ $teacher->department_en }}"
                                                                        name="department_en" />
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="control-label"> مؤهلات</label>
                                                                    <div class="form-group itemItems1">
                                                                        {{-- @foreach ($teacher->qualifications_ar as $key => $value) --}}
                                                                        {{-- <div class="col-md-6">
                                                                            <label for="">عنوان</label>
                                                                            <input type="text"
                                                                                name="qualifications_ar[value][title]"
                                                                                class="form-control InputItemExtra1"
                                                                                value="{{ $teacher->qualifications_ar[value] }}">
                                                                        </div> --}}
                                                                        {{-- <div class="col-md-6">
                                                                                <label for="">وصف</label>
                                                                                <input type="text"
                                                                                    name="qualifications_ar[{{ strval($key) }}][desc]"
                                                                                    class="form-control InputItemExtra1"
                                                                                    value="{{ strval($value['desc']) }}">
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label for="">سنة</label>
                                                                                <input type="text"
                                                                                    name="qualifications_ar[{{ strval($key) }}][year]"
                                                                                    class="form-control InputItemExtra1"
                                                                                    value="{{ strval($value['year']) }}">
                                                                            </div> --}}
                                                                        {{-- @endforeach --}}
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label class="control-label"> Qualifications</label>
                                                                    <div class="form-group itemItems1">
                                                                        @foreach ($teacher->qualifications_en as $key => $value)
                                                                            <div class="col-md-6">
                                                                                <label for="">Title</label>
                                                                                <input type="text"
                                                                                    name="qualifications_en[{{ strval($key) }}][title]"
                                                                                    class="form-control InputItemExtra1"
                                                                                    value="{{ strval($value['title']) }}">
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label for="">Desc</label>
                                                                                <input type="text"
                                                                                    name="qualifications_en[{{ strval($key) }}][desc]"
                                                                                    class="form-control InputItemExtra1"
                                                                                    value="{{ strval($value['desc']) }}">
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label for="">Year</label>
                                                                                <input type="text"
                                                                                    name="qualifications_en[{{ strval($key) }}][year]"
                                                                                    class="form-control InputItemExtra1"
                                                                                    value="{{ strval($value['year']) }}">
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <button type="button"
                                                                        class=" mt-5 btn btn-primary qualifications">
                                                                        المزيد
                                                                    </button>
                                                                    <button type="button"
                                                                        class=" mt-5 btn btn-danger delItem1">
                                                                        حذف
                                                                    </button>
                                                                </div>
                                                                <span class="badge Issue1 badge-danger"></span>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="control-label"> الخبرة</label>
                                                                    <div class="form-group itemItems2">
                                                                        @foreach ($teacher->experience_ar as $key => $value)
                                                                            <input type="text" name="experience_ar[]"
                                                                                class="form-control InputItemExtra2"
                                                                                value="{{ $key }}">
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label"> Experience</label>
                                                                    <div class="form-group itemItems2">
                                                                        @foreach ($teacher->experience_en as $key => $value)
                                                                            <input type="text" name="experience_en[]"
                                                                                class="form-control InputItemExtra2"
                                                                                value="{{ $key }}">
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <button type="button"
                                                                        class=" mt-5 btn btn-primary experience">
                                                                        المزيد
                                                                    </button>
                                                                    <button type="button"
                                                                        class=" mt-5 btn btn-danger delItem2">
                                                                        حذف
                                                                    </button>
                                                                </div>
                                                                <span class="badge Issue2 badge-danger"></span>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="control-label"> المهارات</label>
                                                                    <div class="form-group itemItems3">
                                                                        @foreach ($teacher->skills_ar as $key => $value)
                                                                            <input type="text" name="skills_ar[]"
                                                                                class="form-control InputItemExtra3"
                                                                                value="{{ $key }}">
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label"> skill</label>
                                                                    <div class="form-group itemItems3">
                                                                        @foreach ($teacher->skills_en as $key => $value)
                                                                            <input type="text" name="skills_en[]"
                                                                                class="form-control InputItemExtra3"
                                                                                value="{{ $key }}">
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <button type="button"
                                                                        class=" mt-5 btn btn-primary skills">المزيد
                                                                    </button>
                                                                    <button type="button"
                                                                        class=" mt-5 btn btn-danger delItem3">
                                                                        حذف
                                                                    </button>
                                                                </div>
                                                                <span class="badge Issue3 badge-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal" id="dismiss_delete_modal">
                                                                اغلاق
                                                            </button>
                                                            <button type="submit" class="btn btn-success"
                                                                id="updateButton">تعديل
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Edit Modal -->
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- COL-END -->

                <div class="col-lg-12">
                    <div class="card">
                        <div class="wideget-user-tab">
                            <div class="tab-menu-heading">
                                <div class="tabs-menu1">
                                    <ul class="nav">
                                        <li class=""><a href="#tab-51" class="active show"
                                                data-toggle="tab">مؤهلات</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tab-51">
                            <div class="card">
                                <div class="card-body">
                                    <div id="profile-log-switch">
                                        <div class="table-responsive ">
                                            <table class="table row table-borderless">
                                                <tbody class="col-lg-12 col-xl-4 p-0">
                                                    <tr>
                                                        <td class="text-capitalize"><strong>مؤهلات
                                                                :</strong>
                                                            <ul>
                                                                @foreach ($teacher->qualifications_ar as $key => $value)
                                                                    <li>العنوان : {{ $value['title'] }}</li>
                                                                    <li> الوصف : {{ $value['desc'] }}</li>
                                                                    <li> السنة : {{ $value['year'] }}</li>
                                                                    <hr>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                        <td class="text-capitalize"><strong> : Qualifications
                                                            </strong>
                                                            <ul>
                                                                @foreach ($teacher->qualifications_en as $title => $value)
                                                                    <li>Title : {{ $value['title'] }}</li>
                                                                    <li>Desc : {{ $value['desc'] }}</li>
                                                                    <li>Year : {{ $value['year'] }}</li>
                                                                    <hr>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- COL-END -->

                <div class="col-lg-12">
                    <div class="card">
                        <div class="wideget-user-tab">
                            <div class="tab-menu-heading">
                                <div class="tabs-menu1">
                                    <ul class="nav">
                                        <li class=""><a href="#tab-51" class="active show"
                                                data-toggle="tab">الخبرة</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tab-51">
                            <div class="card">
                                <div class="card-body">
                                    <div id="profile-log-switch">
                                        <div class="table-responsive ">
                                            <table class="table row table-borderless">
                                                <tbody class="col-lg-12 col-xl-4 p-0">
                                                    <tr>
                                                        <td class="text-capitalize"><strong>خبرة
                                                                :</strong>
                                                            <ol>
                                                                @foreach ($teacher->experience_ar as $key => $value)
                                                                    <li>{{ $value }}</li>
                                                                @endforeach
                                                            </ol>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- COL-END -->

                <div class="col-lg-12">
                    <div class="card">
                        <div class="wideget-user-tab">
                            <div class="tab-menu-heading">
                                <div class="tabs-menu1">
                                    <ul class="nav">
                                        <li class=""><a href="#tab-51" class="active show"
                                                data-toggle="tab">المهارات</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tab-51">
                            <div class="card">
                                <div class="card-body">
                                    <div id="profile-log-switch">
                                        <div class="table-responsive ">
                                            <table class="table row table-borderless">
                                                <tbody class="col-lg-12 col-xl-4 p-0">
                                                    <tr>
                                                        <td class="text-capitalize"><strong>مهارات
                                                                :</strong>
                                                            <ol>
                                                                @foreach ($teacher->skills_ar as $key => $value)
                                                                    <li>{{ $value }}</li>
                                                                @endforeach
                                                            </ol>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- COL-END -->
            </div>
    @endforeach
    <script>
        // Qualifications

        $(document).on('click', '.delItem1', function() {
            var Item = $('.InputItemExtra1').last();
            let issue = $('.Issue1');
            if (Item.val() === '' && $('.InputItemExtra1').length > 1) {
                Item.fadeOut();
                Item.remove();
                issue.addClass('badge-success');
                issue.text('The element deleted');
                setTimeout(function() {
                    $('.Issue1').html('');
                }, 3000)
            } else {
                console.log('error')
            }
        })

        $(document).on('click', '.qualifications', function() {
            var Item = $('.InputItemExtra1').last();
            if (Item.val() !== '') {
                $('.itemItems1').append(
                    '<input type="text" name="qualifications[title]" class="form-control InputItemExtra1 mt-3">'
                )
                $('.itemItems1').append(
                    '<input type="text" name="qualifications[des]" class="form-control InputItemExtra1 mt-3">')
                $('.itemItems1').append(
                    '<input type="text" name="qualifications[year]" class="form-control InputItemExtra1 mt-3">')
            }
        })

        // Qualifications

        // Experience

        $(document).on('click', '.delItem2', function() {
            var Item = $('.InputItemExtra2').last();
            let issue = $('.Issue2');
            if (Item.val() === '' && $('.InputItemExtra2').length > 1) {
                Item.fadeOut();
                Item.remove();
                issue.addClass('badge-success');
                issue.text('The element deleted');
                setTimeout(function() {
                    $('.Issue2').html('');
                }, 3000)
            } else {
                console.log('error')
            }
        })

        $(document).on('click', '.experience', function() {
            var Item = $('.InputItemExtra2').last();
            if (Item.val() !== '') {
                $('.itemItems2').append(
                    '<input type="text" name="experience[]" class="form-control InputItemExtra2 mt-3">')
            }
        })

        // Experience

        // Skills

        $(document).on('click', '.delItem3', function() {
            var Item = $('.InputItemExtra3').last();
            let issue = $('.Issue3');
            if (Item.val() === '' && $('.InputItemExtra3').length > 1) {
                Item.fadeOut();
                Item.remove();
                issue.addClass('badge-success');
                issue.text('The element deleted');
                setTimeout(function() {
                    $('.Issue3').html('');
                }, 3000)
            } else {
                console.log('error')
            }
        })

        $(document).on('click', '.skills', function() {
            var Item = $('.InputItemExtra3').last();
            if (Item.val() !== '') {
                $('.itemItems3').append(
                    '<input type="text" name="skills[]" class="form-control InputItemExtra3 mt-3">')
            }
        })

        // Skills



        $(document).on('submit', 'Form#updateForm', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var url = $('#updateForm').attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#updateButton').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                        ' ></span> <span style="margin-left: 4px;">انتظر ..</span>').attr(
                        'disabled', true);
                },
                success: function(data) {
                    $('#updateButton').html(`تعديل`).attr('disabled', false);
                    if (data.status == 200) {
                        $('#dataTable').DataTable().ajax.reload();
                        toastr.success('تم التعديل بنجاح');
                    } else
                        toastr.error('هناك خطأ ما ..');

                    $('#editOrCreate').modal('hide')
                },
                error: function(data) {
                    if (data.status === 500) {
                        toastr.error('هناك خطأ ما ..');
                    } else if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function(key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function(key, value) {
                                    toastr.error(value, 'خطأ');
                                });
                            }
                        });
                    } else
                        toastr.error('هناك خطأ ما ..');
                    $('#updateButton').html(`تعديل`).attr('disabled', false);
                }, //end error method

                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>
@endsection
