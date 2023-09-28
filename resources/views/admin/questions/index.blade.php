@extends('admin.layouts_admin.master')

@section('title')
    بنك الاسئلة
@endsection
@section('page_name')
    سؤال
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <div class="">
                        <label><strong>فلتر :</strong></label>
                        <select id='type' class="form-control" style="width: 200px">
                            @foreach(DB::table('seasons')->get() as $season)
                                <option value="{{ $season->id }}">{{ $season->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="">
                        <button class="btn btn-secondary btn-icon text-white addBtn">
									<span>
										<i class="fe fe-plus"></i>
									</span> أضافة
                        </button>
                        <button class="btn btn-success btn-icon text-white exportExel">
									<span>
										<i class="fa fa-file-pdf"></i>
									</span> تصدير ملف اكسيل
                        </button>
                        <button class="btn btn-info btn-icon text-white importExel"
                                data-toggle="modal" data-target="#importExel">
									<span>
										<i class="fa fa-file-pdf"></i>
									</span> استيراد ملف اكسيل
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
                                <th class="min-w-50px">السؤال</th>
                                <th class="min-w-50px">الفصل</th>
                                <th class="min-w-50px">الترم</th>
                                <th class="min-w-50px">الصعوبة</th>
                                <th class="min-w-50px">مخصص لـ</th>
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
                                id="delete_btn">حذف
                        </button>
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
                        <h5 class="modal-title" id="example-Modal3">السؤال</h5>
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

        <!-- Create Or Edit Modal -->
        <div class="modal fade bd-example-modal-lg" id="answerModal" data-backdrop="static" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">جواب</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="answerModal-body">

                    </div>
                </div>
            </div>
        </div>
        <!-- Create Or Edit Modal -->

        <!-- Import Modal -->
        <div class="modal fade" id="importExel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">استيراد ملف اكسيل</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <form method="post" id="importExelForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <label class="form-label" for="exelFile">ملف الاسئلة</label>
                                    <input class="form-control form-control-file dropify" type="file" name="exelFile">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary importBtn">رفع</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Import Modal -->
        </div>
    </div>

    @include('admin.layouts_admin.myAjaxHelper')
@endsection
@section('ajaxCalls')
    <script>

        function showEdit(routeOfEdit) {
            $(document).on('click', '.editBtnAnswer', function () {
                var id = $(this).data('id')
                var url = routeOfEdit;
                url = url.replace(':id', id)
                $('#answerModal-body').html(loader)
                $('#answerModal').modal('show')

                setTimeout(function () {
                    $('#answerModal-body').load(url)
                }, 500)
            })
        }

        var columns = [
            {data: 'id', name: 'id'},
            {data: 'question', name: 'question'},
            {data: 'season_id', name: 'season_id'},
            {data: 'term_id', name: 'term_id'},
            {data: 'difficulty', name: 'difficulty'},
            {data: 'type', name: 'type'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]

        var ajax = {
            url: "{{ route('questions.index') }}",
            data: function (d) {
                d.type = $('#type').val()
                // d.search = $('input[type="search"]').val()
            }
        };


        showData(ajax, columns);
        // Delete Using Ajax
        destroyScript('{{route('questions.destroy',':id')}}');
        // Add Using Ajax
        showAddModal('{{route('questions.create')}}');
        addScript();
        // Add Using Ajax
        showEditModal('{{route('questions.edit',':id')}}');
        editScript();

        showEdit('{{ route('answer',':id') }}');
    //     function addAnswer() {
    //     $(document).on('buttonAnswer', 'Form#addForm', function(e) {
    //         e.preventDefault();
    //         var formData = new FormData(this);
    //         var url = $('#addForm').attr('action');
    //         $.ajax({
    //             url: url,
    //             type: 'POST',
    //             data: formData,
    //             beforeSend: function() {
    //                 $('#addButton').html('<span class="spinner-border spinner-border-sm mr-2" ' +
    //                     ' ></span> <span style="margin-left: 4px;">انتظر ..</span>').attr(
    //                     'disabled', true);
    //             },
    //             success: function(data) {
    //                 if (data.status == 200) {
    //                     $('#dataTable').DataTable().ajax.reload();
    //                     toastr.success('1تم الاضافة بنجاح');
    //                 } else if (data.status == 407) {
    //                     toastr.error('يجب ان تضيف اربعة اجوبة فقط');
    //                 }
    //                  else if (data.status == 405) {
    //                     toastr.error(data.mymessage);
    //                 } else
    //                     toastr.error('هناك خطأ ما ..');
    //                 $('#addButton').html(`اضافة`).attr('disabled', false);
    //                 $('#editOrCreate').modal('hide')
    //             },
    //             error: function(data) {
    //                 if (data.status === 500) {
    //                     toastr.error('هناك خطأ ما ..');
    //                 } else if (data.status === 422) {
    //                     var errors = $.parseJSON(data.responseText);
    //                     $.each(errors, function(key, value) {
    //                         if ($.isPlainObject(value)) {
    //                             $.each(value, function(key, value) {
    //                                 toastr.error(value, 'خطأ');
    //                             });
    //                         }
    //                     });
    //                 } else
    //                     toastr.error('هناك خطأ ما ..');
    //                 $('#addButton').html(`اضافة`).attr('disabled', false);
    //             }, //end error method

    //             cache: false,
    //             contentType: false,
    //             processData: false
    //         });
    //     });
    // }

        $(document).ready(function () {
            $('.exportExel').on('click', function () {
                window.location.href = '{{ route('questionExport')}}'
            })
        })

        $('.dropify').dropify();

        $(document).on("submit", "#importExelForm", function (event) {
            event.preventDefault();
            event.stopImmediatePropagation();

            var formData = new FormData(this);

            $.ajax({
                url: '{{ route('questionImport') }}',
                type: 'POST',
                data: formData,
                success: function (data) {
                    if (data.status === 200) {
                        toastr.success('تم استيراد الملف بنجاح')
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000)

                    } else if (data.status === 500) {
                        toastr.error('فشل في استيراد الملف')
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000)
                    }
                },
                error: function (data) {
                    toastr.error('فشل في استيراد الملف')
                    setTimeout(function () {
                        // window.location.reload();
                    }, 2000)
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>
@endsection

<!-- fix -->

