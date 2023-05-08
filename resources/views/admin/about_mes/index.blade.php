@extends('admin.layouts_admin.master')
@section('title')
    {{ $setting->title ?? '' }} معلومات عن الاستاذ
@endsection

@section('page_name')
    معلومات عن الاستاذ
@endsection
@section('content')
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


        <div class="card">
            <div class="wideget-user-tab">
                <div class="tab-menu-heading">
                    <div class="tabs-menu1">
                        <ul class="nav">
                            <li><a href="#tab-1">معلومات</a></li>
                            </li>
                            <li><a href="#tab-2">مؤهلات</a></li>
                            </li>
                            <li><a href="#tab-3">خبرة</a></li>
                            </li>
                            <li><a href="#tab-4">مهارات</a></li>
                            </li>
                            <li><a href="#tab-5">موافع التواصل</a></li>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div id="tab-1" class="tab-content">
                <div class="card">
                    <div class="card-body">
                        <div id="profile-log-switch">
                            <div class="media-heading">
                                <h5><strong>معلومات</strong></h5>
                            </div>
                            <div class="table-responsive ">
                                <table class="table row table-borderless">


                                    <tbody class="col-lg-12 col-xl-4 p-0">
                                        <tr>
                                            <td class="text-capitalize"><strong>الاسم بالعربي
                                                    :</strong> {{ $about_me->teacher_name_ar }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-capitalize"><strong>الاسم بالانجليزي
                                                    :</strong> {{ $about_me->teacher_name_en }}</td>
                                        </tr>
                                    </tbody>
                                    <tbody class="col-lg-12 col-xl-4 p-0">
                                        <tr>
                                            <td><strong>القسم بالعربي :</strong> {{ $about_me->department_ar }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>القسم بالانجليزي :</strong> {{ $about_me->department_en }}
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                            <button class="btn btn-purple-gradient" data-toggle="modal" data-target="#editAbout">تعديل
                            </button>

                            <!-- Modal Information -->
                            <div class="modal fade" id="editAbout" data-backdrop="static" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="example-Modal3">تعديل المعلومات</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="modal-body">
                                            <form action="{{ route('aboutMes.update', $about_me->id) }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $about_me->id }}">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">الاسم بالعربي</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $about_me->teacher_name_ar }}"
                                                                name="teacher_name_ar">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">الاسم بالانجليزي</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $about_me->teacher_name_en }}"
                                                                name="teacher_name_en">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">الاسم القسم بالعربي</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $about_me->department_ar }}" name="department_ar">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">الاسم القسم بالانجليزي</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $about_me->department_en }}"
                                                                name="department_en">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">اغلاق</button>
                                                        <button type="submit" class="btn btn-success"
                                                            id="updateButton">تحديث</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div id="tab-2" class="tab-content">
                <div class="card">
                    <div class="card-body">
                        <div id="profile-log-switch">
                            <div class="media-heading">
                                <h5><strong>مؤهلات</strong></h5>
                            </div>
                            <div class="table-responsive ">
                                <table class="table row table-borderless">
                                    <tbody class="col-lg-12 col-xl-4 p-0">
                                        <tr>
                                            {{-- @dd($about_me->qualifications_ar) --}}
                                            @if (isset($about_me->qualifications_ar))
                                                @foreach ($about_me->qualifications_ar as $qualification_ar)
                                                    <li> العنوان : {{ $qualification_ar['title'] }}</li>
                                                    <li> الوصف : {{ $qualification_ar['desc'] }}</li>
                                                    <li> السنة: {{ $qualification_ar['year'] }}</li>
                                                    <hr>
                                                @endforeach
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="media-heading">
                                <h5><strong>Qualifications</strong></h5>
                            </div>
                            <div class="table-responsive ">
                                <table class="table row table-borderless">
                                    <tbody class="col-lg-12 col-xl-4 p-0">
                                        <tr>
                                        <tr>
                                            {{-- @dd($about_me->qualifications_ar) --}}
                                            @if (isset($about_me->qualifications_en))
                                                @foreach ($about_me->qualifications_en as $qualification_en)
                                                    <li> Title : {{ $qualification_en['title'] }}</li>
                                                    <li> Desc : {{ $qualification_en['desc'] }}</li>
                                                    <li> Year : {{ $qualification_en['year'] }}</li>
                                                    <hr>
                                                @endforeach
                                            @endif
                                        </tr>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-purple-gradient" data-toggle="modal"
                                data-target="#editQualifications">تعديل
                            </button>

                            <!-- Modal Information -->
                            <div class="modal fade bd-example-modal-lg" id="editQualifications" data-backdrop="static"
                                tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="example-Modal3">تعديل الخبرة</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="modal-body">
                                            <form action="{{ route('aboutMes.update', $about_me->id) }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $about_me->id }}">
                                                @foreach ($about_me->qualifications_ar as $qualification)
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="">العنوان بالعربي</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $qualification['title'] }}"
                                                                    name="teacher_name_ar">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for=""> السنة</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $qualification['year'] }}"
                                                                    name="qualification['year']">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="">وصف بالعربي</label>
                                                                <textarea class="form-control" rows="8" name="department_ar">{{ $qualification['desc'] }}</textarea>
                                                            </div>
                                                        </div>
                                                @endforeach
                                                @foreach ($about_me->qualifications_en as $qualification)
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="">Title</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $qualification['title'] }}"
                                                                    name="teacher_name_ar">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for=""> Year</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $qualification['year'] }}"
                                                                    name="qualification['year']">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for=""> Desc</label>
                                                                <textarea class="form-control" rows="8" name="department_ar">{{ $qualification['desc'] }}</textarea>
                                                            </div>
                                                        </div>
                                                @endforeach
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">اغلاق</button>
                                                    <button type="submit" class="btn btn-success"
                                                        id="updateButton">تحديث</button>
                                                </div>
                                        </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div id="tab-3" class="tab-content">
            <div class="card">
                <div class="card-body">
                    <div id="profile-log-switch">
                        <div class="media-heading">
                            <h5><strong>خبرة</strong></h5>
                        </div>
                        <div class="table-responsive ">
                            <table class="table row table-borderless">
                                <tbody class="col-lg-12 col-xl-4 p-0">
                                    <tr>
                                        @if (isset($about_me->experience_ar))
                                            @foreach ($about_me->experience_ar as $experience_ar)
                                                <li> العنوان : {{ $experience_ar['title'] }}</li>
                                                <li> الوصف : {{ $experience_ar['desc'] }}</li>
                                                <li> السنة: {{ $experience_ar['year'] }}</li>
                                                <hr>
                                            @endforeach
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="media-heading">
                            <h5><strong>Experience</strong></h5>
                        </div>
                        <div class="table-responsive ">
                            <table class="table row table-borderless">
                                <tbody class="col-lg-12 col-xl-4 p-0">
                                    <tr>
                                        @if (isset($about_me->experience_en))
                                            @foreach ($about_me->experience_en as $experience_en)
                                                <li> Title : {{ $experience_en['title'] }}</li>
                                                <li> Desc : {{ $experience_en['desc'] }}</li>
                                                <li> Year: {{ $experience_en['year'] }}</li>
                                                <hr>
                                            @endforeach
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-purple-gradient" data-toggle="modal" data-target="#editAbout">تعديل
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div id="tab-4" class="tab-content">
            <div class="card">
                <div class="card-body">
                    <div id="profile-log-switch">
                        <div class="media-heading">
                            <h5><strong>مهارات</strong></h5>
                        </div>
                        <div class="table-responsive ">
                            <table class="table row table-borderless">
                                <tbody class="col-lg-12 col-xl-4 p-0">
                                    <tr>
                                        @if (isset($about_me->skills_ar))
                                            @foreach ($about_me->skills_ar as $skill_ar)
                                                <li> العنوان : {{ $skill_ar['title'] }}</li>
                                                <li> الوصف : {{ $skill_ar['desc'] }}</li>
                                                <li> السنة: {{ $skill_ar['year'] }}</li>
                                                <hr>
                                            @endforeach
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="media-heading">
                            <h5><strong>Skills</strong></h5>
                        </div>
                        <div class="table-responsive ">
                            <table class="table row table-borderless">
                                <tbody class="col-lg-12 col-xl-4 p-0">
                                    <tr>
                                        @if (isset($about_me->skills_en))
                                            @foreach ($about_me->skills_en as $skill_en)
                                                <li> Title : {{ $skill_en['title'] }}</li>
                                                <li> Desc : {{ $skill_en['desc'] }}</li>
                                                <li> Year: {{ $skill_en['year'] }}</li>
                                                <hr>
                                            @endforeach
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-purple-gradient" data-toggle="modal"
                            data-target="#editAbout">تعديل</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div id="tab-5" class="tab-content">
            <div class="card">
                <div class="card-body">
                    <div id="profile-log-switch">
                        <div class="media-heading">
                            <h5><strong>مواقع التواصل</strong></h5>
                        </div>
                        <div class="table-responsive ">
                            <table class="table row table-borderless">
                                <tbody class="col-lg-12 col-xl-4 p-0">
                                    <tr>
                                        {{-- @dd($about_me->social) --}}
                                        @if (isset($about_me->social))
                                            @foreach ($about_me->social as $socials)
                                                <li> فيسبوك : {{ $socials['facebook'] }}</li>
                                                <li> انستجرام : {{ $socials['instagram'] }}</li>
                                                <li> يوتيوب: {{ $socials['youtube'] }}</li>
                                                <li> لينكد ان: {{ $socials['linkedin'] }}</li>
                                                <hr>
                                            @endforeach
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-purple-gradient" data-toggle="modal"
                            data-target="#editAbout">تعديل</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    @include('admin.layouts_admin.myAjaxHelper')
    <script>
        editScript();

        // get all buttons
        $(document).ready(function() {
            // Hide all tab contents except the first one
            $('.tab-content').not(':first').hide();

            // Listen for click events on the menu tabs
            $('.tabs-menu1 a').click(function(event) {
                event.preventDefault();
                var tab = $(this).attr('href');

                // Hide all tab contents and show the selected one
                $('.tab-content').hide();
                $(tab).show();
            });
        });

        // get all buttons
        $(document).ready(function() {
            // Hide all tab contents except the first one
            $('.tab-content').not(':second').hide();

            // Listen for click events on the menu tabs
            $('.tabs-menu2 a').click(function(event) {
                event.preventDefault();
                var tab = $(this).attr('href');

                // Hide all tab contents and show the selected one
                $('.tab-content').hide();
                $(tab).show();
            });
        });
    </script>
@endsection
