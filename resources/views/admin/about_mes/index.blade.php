@extends('admin.layouts_admin.master')
@section('title')
    {{$setting->title ?? ''}} الاساتذة
@endsection

@section('page_name')
    الاساتذة
@endsection
@section('content')
    @foreach($about_me as $about)
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
                                                <td class="text-capitalize"><strong>الاسم :</strong>{{ $about->teacher_name }}</td>
                                            </tr>
                                            </tbody>
                                            <tbody class="col-lg-12 col-xl-4 p-0">
                                            <tr>
                                                <td><strong>القسم :</strong>{{ $about->department }}</td>
                                            </tr>
                                            </tbody>
                                            <tbody class="col-lg-12 col-xl-4 p-0">
                                            <tr>
                                                <td><strong>تاريخ الانضمام :</strong>{{ $about->created_at->diffForHumans() }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <a href="{{ route('aboutMes.show', $about->id) }}"><button class="btn btn-purple-gradient">تفاصيل</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- COL-END -->
        </div>
    @endforeach

@endsection


