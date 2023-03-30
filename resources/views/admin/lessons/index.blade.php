@extends('admin.layouts_admin.master')

@section('title')
    دروس
@endsection
@section('page_name')
    درس
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <form id="filter-form">
                        <div class="row">
                            <div class="col-md-10">
                                <label for="">الوحدة</label>
                                <select name="subject_class_id" id="subject_class_id" class="form-control">
                                    <option value="">اختر الوحدة</option>
                                    @foreach($subjectClass as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name_ar }}</option>
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
									</span> أضافة
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-striped table-bordered text-nowrap w-100" id="lesson-table">
                            <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="min-w-25px">#</th>
                                <th class="min-w-50px">الأسم</th>
                                <th class="min-w-50px">الوحدة</th>
                                <th class="min-w-50px">ملاحظة</th>
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
                        <h5 class="modal-title" id="exampleModalLabel">حذف</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="delete_id" name="id" type="hidden">
                        <p>هل أنت متأكد من عملية الحذف<span id="title" class="text-danger"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="dismiss_delete_modal">
                            أغلاق
                        </button>
                        <button type="button" class="btn btn-danger"
                                id="delete_btn">حذف</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL CLOSED -->

        <!-- Create Or Edit Modal -->
        <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">درس</h5>
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
            {data: 'subject_class_id', name: 'subject_class_id'},
            {data: 'note', name: 'note'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('{{route('lessons.index')}}', columns);
        // Delete Using Ajax
        destroyScript('{{route('lessons.destroy',':id')}}');
        // Add Using Ajax
        showAddModal('{{route('lessons.create')}}');
        addScript();
        // Add Using Ajax
        showEditModal('{{route('lessons.edit',':id')}}');
        editScript();


        $(document).ready(function () {
            $('#lesson-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("lesson.filter") }}',
                    method: 'POST',
                    data: function (d) {
                        d.$subject_class_id = $('#subject_class_id').val();
                        d._token = '{{ csrf_token() }}';
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name_ar', name: 'name_ar'},
                    {data: 'subject_class_id', name: 'subject_class_id'},
                    {data: 'note', name: 'note'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#filter-form').on('submit', function (event) {
                event.preventDefault();
                $('#lesson-table').DataTable().ajax.reload();
            });
        });


    </script>
@endsection

