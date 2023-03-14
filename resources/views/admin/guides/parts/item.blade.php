@extends('Admin/layouts_admin/master')

@section('title')
    عناصر
@endsection
@section('page_name')
    عنصر
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <div class="">
                        <button class="btn btn-secondary btn-icon text-white " data-target="#create"
                                data-toggle="modal">
                            <span>
                                <i class="fe fe-plus"></i>
                            </span> اضافة
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-striped table-bordered text-nowrap w-100" id="dataTable">
                            <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="min-w-25px">#</th>
                                <th class="min-w-50px">العنوان</th>
                                <th class="min-w-50px">الوصف</th>
                                <th class="min-w-50px">من</th>
                                <th class="min-w-50px">ملف</th>
                                <th class="min-w-50px">أيقونة</th>
                                <th class="min-w-50px rounded-end">العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($guide as $item)
                                <tr>
                                    <td class="min-w-25px">{{ $item->id }}</td>
                                    <td class="min-w-25px">{{ $item->title_ar }}</td>
                                    <td class="min-w-25px">{{ $item->description_ar }}</td>
                                    <td class="min-w-25px">{{ $item->from_id }}</td>
                                    <td class="min-w-25px">{{ $item->file }}<button class="btn btn-pill btn-warning-light"><li class="fas fa-eye"></li></button></td>
                                    <td class="min-w-25px">{{ $item->icon }}</td>
                                    <td>
                                        <button type="button" data-target="#editOrCreate{{ $item->id }}"
                                                data-toggle="modal" class="btn btn-pill btn-info-light editBtn"><i
                                                class="fa fa-edit"></i></button>
                                        <button class="btn btn-pill btn-danger-light" data-toggle="modal"
                                                data-target="#delete_modal{{ $item->id }}"
                                                data-id="" data-title="">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!--Delete MODAL -->
        @foreach($guide as $item)
        <div class="modal fade" id="delete_modal{{ $item->id }}" tabindex="-1" role="dialog"

             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">حذف</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addForm" class="addForm" method="POST" action="{{ route('destroyItem', $item->id) }}">
                            @csrf
                            <input id="delete_id" name="id" type="hidden">
                            <p>حذف<span id="title" class="text-danger">{{ $item->title_ar }}</span></p>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"
                                        id="dismiss_delete_modal">
                                    اغلاق
                                </button>
                                <button type="submit" class="btn btn-danger">حذف</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <!-- MODAL CLOSED -->

        <!-- Edit Modal -->
        @foreach($guide as $item)
            <div class="modal fade bd-example-modal-lg" id="editOrCreate{{ $item->id }}" data-backdrop="static"
                 tabindex="-1" role="dialog"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">القسم</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="modal-body">
                            <form id="addForm" class="addForm" method="POST"
                                  action="{{ route('updateItem', $item->id) }}">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" name="from_id" value="{{ $item->from_id }}"/>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="section_name_ar" class="form-control-label">العنوان
                                                بالعربية</label>
                                            <input type="text" class="form-control" value="{{ $item->title_ar }}"
                                                   name="title_ar" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="section_name_en" class="form-control-label">العنوان
                                                بالانجليزية</label>
                                            <input type="text" class="form-control" value="{{ $item->title_en }}"
                                                   name="title_en" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="file">File</label>
                                            <input type="file" class="form-control" value="{{ asset($item->file) }}"
                                                   name="file" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="file">icon</label>
                                            <input type="file" class="form-control" value="{{ asset($item->icon) }}"
                                                   name="icon">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="section_name_ar" class="form-control-label">الوصف
                                                بالعربية</label>
                                            <textarea class="form-control" name="description_ar" rows="8"
                                                      required>{{ $item->description_ar }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="section_name_en" class="form-control-label">الوصف
                                                بالانجليزية</label>
                                            <textarea class="form-control" name="description_en" rows="8"
                                                      required>{{ $item->description_en }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                    <button type="submit" class="btn btn-primary" id="addButton">تحديث</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Edit Modal -->
        @endforeach
        <!-- Create Modal -->
        <div class="modal fade bd-example-modal-lg" id="create" data-backdrop="static" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">القسم</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body">
                        <form id="addForm" class="addForm" method="POST" action="{{ route('addItem') }}">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="from_id" value="{{ $id }}"/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="section_name_ar" class="form-control-label">العنوان بالعربية</label>
                                        <input type="text" class="form-control" name="title_ar" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="section_name_en" class="form-control-label">العنوان
                                            بالانجليزية</label>
                                        <input type="text" class="form-control" name="title_en" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="file">File</label>
                                        <input type="file" class="form-control" name="file" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="file">icon</label>
                                        <input type="file" class="form-control" name="icon">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="section_name_ar" class="form-control-label">الوصف بالعربية</label>
                                        <textarea class="form-control" name="description_ar" rows="8"
                                                  required></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="section_name_en" class="form-control-label">الوصف
                                            بالانجليزية</label>
                                        <textarea class="form-control" name="description_en" rows="8"
                                                  required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Create Modal -->
    </div>
    @include('Admin/layouts_admin/myAjaxHelper')
@endsection

