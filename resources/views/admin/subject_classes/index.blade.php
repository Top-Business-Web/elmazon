@extends('admin.layouts_admin.master')

@section('title')
    الوحدات
@endsection
@section('page_name')
    الوحدة
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <form id="filter-form">
                        <div class="row">
                            <div class="col-md-5">
                                <label for="">الصف</label>
                                <select name="season_id" id="season_id" class="form-control">
                                    <option value="">اختر الصف</option>
                                    @foreach($seasons as $season)
                                        <option value="{{ $season->id }}">{{ $season->name_ar }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="">الترم</label>
                                <select name="term_id" id="term_id" class="form-control">
                                    <option value="">اختر الترم</option>
                                    @foreach($terms as $term)
                                        <option value="{{ $term->id }}">{{ $term->name_ar }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1 mt-6">
                                <button class="btn btn-success" type="submit">فلتر</button>
                            </div>
                        </div>
                    </form>

                    <div class="">
                        <button class="btn btn-secondary btn-icon text-white addBtn">
									<span>
										<i class="fe fe-plus"></i>
									</span> اضافة
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-striped table-bordered text-nowrap w-100" id="subject-class-table">
                            <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="min-w-25px">#</th>
                                <th class="min-w-50px">الاسم</th>
                                <th class="min-w-50px">الترم</th>
                                <th class="min-w-50px">الصف</th>
                                <th class="min-w-50px">الصورة</th>
                                <th class="min-w-50px rounded-end">العمليات</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!--Delete MODAL -->
        <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ trans('admin.delete') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="delete_id" name="id" type="hidden">
                        <p>هل انت متاكد من عملية الحذف<span id="title" class="text-danger"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="dismiss_delete_modal">
                            اغلاق
                        </button>
                        <button type="button" class="btn btn-danger" id="delete_btn">حدف</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL CLOSED -->

        <!-- Create Or Edit Modal -->
        <div class="modal fade bd-example-modal-lg" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">الوحدة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body">

                    </div>
                </div>
            </div>
        </div>
        <!-- Create Or Edit Modal -->
    </div>
    @include('admin.layouts_admin.myAjaxHelper')
@endsection
@section('ajaxCalls')
    <script>
        var columns = [
            {data: 'id', name: 'id'},
            {data: 'name_ar', name: 'name_ar'},
            {data: 'term_id', name: 'term_id'},
            {data: 'season_id', name: 'season_id'},
            {data: 'image', name: 'image'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('{{route('subjectsClasses.index')}}', columns);
        // Delete Using Ajax
        destroyScript('{{route('subjectsClasses.destroy', ':id')}}');
        // Add Using Ajax
        showAddModal('{{route('subjectsClasses.create')}}');
        addScript();
        // Add Using Ajax
        showEditModal('{{route('subjectsClasses.edit', ':id')}}');
        editScript();


        $(document).ready(function () {
            $('#subject-class-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("subject-class.filter") }}',
                    method: 'POST',
                    data: function (d) {
                        d.term_id = $('#term_id').val();
                        d.season_id = $('#season_id').val();
                        d._token = '{{ csrf_token() }}';
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name_ar', name: 'name_ar'},
                    {data: 'term_id', name: 'term_id'},
                    {data: 'season_id', name: 'season_id'},
                    {data: 'image', name: 'image'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#filter-form').on('submit', function (event) {
                event.preventDefault();
                $('#subject-class-table').DataTable().ajax.reload();
            });
        });
    </script>

@endsection

