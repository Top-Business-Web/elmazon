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


                                <!-- Edit Modal Informatio -->
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
                                                    action="{{ route('aboutMes.update', $about_me->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" value="{{ $about_me->id }}" name="id">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="teacher_name_ar">الاسم بالعربي</label>
                                                                <input class="form-control"
                                                                    value="{{ $about_me->teacher_name_ar }}"
                                                                    name="teacher_name_ar" />
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="teacher_name_en">الاسم بالانجليزي</label>
                                                                <input class="form-control"
                                                                    value="{{ $about_me->teacher_name_en }}"
                                                                    name="teacher_name_en" />
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="department_ar">القسم بالعربي</label>
                                                                <input class="form-control"
                                                                    value="{{ $about_me->department_ar }}"
                                                                    name="department_ar" />
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="department_en">القسم بالانجليزي</label>
                                                                <input class="form-control"
                                                                    value="{{ $about_me->department_en }}"
                                                                    name="department_en" />
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
                                                            {{-- @foreach ($teacher->qualifications_ar as $key => $value) --}}
                                                            <li>العنوان : </li>
                                                            <li> الوصف : </li>
                                                            <li> السنة : </li>
                                                            <hr>
                                                            {{-- @endforeach --}}
                                                        </ul>
                                                        <button class="btn btn-purple-gradient" data-toggle="modal"
                                                            data-target="#edit">تعديل
                                                        </button>
                                                            <!-- Edit Modal Experience -->
                                <div class="modal fade bd-example-modal-lg" id="edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                      <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"> تعديل الخبرة</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" id="modal-body">
                                                <form class="updateForm" id="updateForm"
                                                    action="{{ route('aboutMes.update', $about_me->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" value="{{ $about_me->id }}" name="id">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="teacher_name_ar">الاسم بالعربي</label>
                                                                <input class="form-control"
                                                                    value="{{ $about_me->teacher_name_ar }}"
                                                                    name="teacher_name_ar" />
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="teacher_name_en">الاسم بالانجليزي</label>
                                                                <input class="form-control"
                                                                    value="{{ $about_me->teacher_name_en }}"
                                                                    name="teacher_name_en" />
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="department_ar">القسم بالعربي</label>
                                                                <input class="form-control"
                                                                    value="{{ $about_me->department_ar }}"
                                                                    name="department_ar" />
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="department_en">القسم بالانجليزي</label>
                                                                <input class="form-control"
                                                                    value="{{ $about_me->department_en }}"
                                                                    name="department_en" />
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
                                                    </td>
                                                    <td class="text-capitalize"><strong> : Qualifications
                                                        </strong>
                                                        <ul>
                                                            {{-- @foreach ($teacher->qualifications_en as $title => $value) --}}
                                                            <li>Title : </li>
                                                            <li>Desc : </li>
                                                            <li>Year : </li>
                                                            <hr>
                                                            {{-- @endforeach --}}
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
                                                            {{-- @foreach ($teacher->experience_ar as $key => $value) --}}
                                                            <li></li>
                                                            {{-- @endforeach --}}
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
                                                            {{-- @foreach ($teacher->skills_ar as $key => $value) --}}
                                                            <li></li>
                                                            {{-- @endforeach --}}
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
        @include('admin.layouts_admin.myAjaxHelper')
        <script>
            editScript();
        </script>
    @endsection
