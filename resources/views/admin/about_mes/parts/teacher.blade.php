@extends('admin.layouts_admin.master')
@section('title')
    {{$setting->title ?? ''}} معلومات عن الاستاذ
@endsection

@section('page_name')
    معلومات عن الاستاذ
@endsection
@section('content')
    @foreach($teachers as $teacher)
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
                                                <td class="text-capitalize"><strong>الاسم
                                                        :</strong> {{ $teacher->teacher_name }}</td>
                                            </tr>
                                            </tbody>
                                            <tbody class="col-lg-12 col-xl-4 p-0">
                                            <tr>
                                                <td><strong>القسم :</strong> {{ $teacher->department }}</td>
                                            </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                    <button class="btn btn-purple-gradient" data-toggle="modal"
                                            data-target="#editAbout">تعديل
                                    </button>
                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editAbout" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel bd-example-modal-lg"
                                         aria-hidden="true">
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
                                                                    <label for="teacher_name">الاسم</label>
                                                                    <input class="form-control"
                                                                           value="{{ $teacher->teacher_name }}"
                                                                           name="teacher_name"/>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="department">القسم</label>
                                                                    <input class="form-control"
                                                                           value=" {{ $teacher->department }}"
                                                                           name="department"/>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="control-label"> مؤهلات</label>
                                                                    <div class="form-group itemItems1">
                                                                        @foreach($teacher->qualifications as $qualification)

                                                                        <input type="text" name="qualifications[]"
                                                                               class="form-control InputItemExtra1"
                                                                               value="{{ $qualification }}">
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
                                                                        @foreach($teacher->experience as $experiences)
                                                                        <input type="text" name="experience[]"
                                                                               class="form-control InputItemExtra2"
                                                                               value="{{ $experiences }}">
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
                                                                        @foreach($teacher->skills as $skill)
                                                                        <input type="text" name="skills[]"
                                                                               class="form-control InputItemExtra3"
                                                                               value="{{ $skill }}">
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
                                                                    data-dismiss="modal"
                                                                    id="dismiss_delete_modal">
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
                                        <li class=""><a href="#tab-51" class="active show" data-toggle="tab">مؤهلات</a>
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
                                                        <ol>
                                                            @foreach($teacher->qualifications as $qualification)
                                                                <li>{{ $qualification }}</li>
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
                                        <li class=""><a href="#tab-51" class="active show" data-toggle="tab">الخبرة</a>
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
                                                            @foreach($teacher->experience as $experiences)
                                                                <li>{{ $experiences }}</li>
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
                                                            @foreach($teacher->skills as $skill)
                                                                <li>{{ $skill }}</li>
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

                $(document).on('click', '.delItem1', function () {
                    var Item = $('.InputItemExtra1').last();
                    let issue = $('.Issue1');
                    if (Item.val() === '' && $('.InputItemExtra1').length > 1) {
                        Item.fadeOut();
                        Item.remove();
                        issue.addClass('badge-success');
                        issue.text('The element deleted');
                        setTimeout(function () {
                            $('.Issue1').html('');
                        }, 3000)
                    } else {
                        console.log('error')
                    }
                })

                $(document).on('click', '.qualifications', function () {
                    var Item = $('.InputItemExtra1').last();
                    if (Item.val() !== '') {
                        $('.itemItems1').append('<input type="text" name="qualifications[]" class="form-control InputItemExtra1 mt-3">')
                    }
                })

                // Qualifications

                // Experience

                $(document).on('click', '.delItem2', function () {
                    var Item = $('.InputItemExtra2').last();
                    let issue = $('.Issue2');
                    if (Item.val() === '' && $('.InputItemExtra2').length > 1) {
                        Item.fadeOut();
                        Item.remove();
                        issue.addClass('badge-success');
                        issue.text('The element deleted');
                        setTimeout(function () {
                            $('.Issue2').html('');
                        }, 3000)
                    } else {
                        console.log('error')
                    }
                })

                $(document).on('click', '.experience', function () {
                    var Item = $('.InputItemExtra2').last();
                    if (Item.val() !== '') {
                        $('.itemItems2').append('<input type="text" name="experience[]" class="form-control InputItemExtra2 mt-3">')
                    }
                })

                // Experience

                // Skills

                $(document).on('click', '.delItem3', function () {
                    var Item = $('.InputItemExtra3').last();
                    let issue = $('.Issue3');
                    if (Item.val() === '' && $('.InputItemExtra3').length > 1) {
                        Item.fadeOut();
                        Item.remove();
                        issue.addClass('badge-success');
                        issue.text('The element deleted');
                        setTimeout(function () {
                            $('.Issue3').html('');
                        }, 3000)
                    } else {
                        console.log('error')
                    }
                })

                $(document).on('click', '.skills', function () {
                    var Item = $('.InputItemExtra3').last();
                    if (Item.val() !== '') {
                        $('.itemItems3').append('<input type="text" name="skills[]" class="form-control InputItemExtra3 mt-3">')
                    }
                })

                // Skills



                    $(document).on('submit', 'Form#updateForm', function (e) {
                        e.preventDefault();
                        var formData = new FormData(this);
                        var url = $('#updateForm').attr('action');
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: formData,
                            beforeSend: function () {
                                $('#updateButton').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                                    ' ></span> <span style="margin-left: 4px;">انتظر ..</span>').attr(
                                    'disabled', true);
                            },
                            success: function (data) {
                                $('#updateButton').html(`تعديل`).attr('disabled', false);
                                if (data.status == 200) {
                                    $('#dataTable').DataTable().ajax.reload();
                                    toastr.success('تم التعديل بنجاح');
                                } else
                                    toastr.error('هناك خطأ ما ..');

                                $('#editOrCreate').modal('hide')
                            },
                            error: function (data) {
                                if (data.status === 500) {
                                    toastr.error('هناك خطأ ما ..');
                                } else if (data.status === 422) {
                                    var errors = $.parseJSON(data.responseText);
                                    $.each(errors, function (key, value) {
                                        if ($.isPlainObject(value)) {
                                            $.each(value, function (key, value) {
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


