@extends('admin.layouts_admin.master')

    @section('title')
        الطلاب
    @endsection
    @section('page_name')
        الطلاب
    @endsection
    @section('content')
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                        {{-- <div class="">
                            <label><strong>فلتر :</strong></label>
                            <select id='type' class="form-control" style="width: 200px">
                                <option value="all">كل الطلاب</option>
                                <option value="unavailable">الطلاب الغائبين</option>
                            </select>
                        </div> --}}
                        <div class="">
                            <button class="btn btn-secondary btn-icon text-white addBtn">
                                <span>
                                    <i class="fe fe-plus"></i>
                                </span> اضافة طالب
                            </button>
                            <button class="btn btn-danger btn-icon text-white userUnvilable">
                                <span>
                                    <i class="fe fe-user"></i>
                                </span> الطلاب الغائبين
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
                                        <th class="min-w-50px">الاسم</th>
                                        <th class="min-w-50px">الكود</th>
                                        <th class="min-w-50px">الهاتف</th>
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
                            <h5 class="modal-title" id="exampleModalLabel">حذف طالب</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input id="delete_id" name="id" type="hidden">
                            <p>هل متاكد من حذف<span id="title" class="text-danger"></span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="dismiss_delete_modal">
                                اغلاق
                            </button>
                            <button type="button" class="btn btn-danger" id="delete_btn">حذف</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- MODAL CLOSED -->

            <!-- Create Or Edit Modal -->
            <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">الطلاب</h5>
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

            <!-- Show User Unvilable -->
            <div class="modal fade" id="showUserUnvilable" data-backdrop="static" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">الطلاب</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body-unvilable" id="modal-body-unvilable">

                        </div>
                    </div>
                </div>
            </div>
            <!-- Show User Unvilable -->

            <!-- Renew Subscribe -->
            <div class="modal fade" id="renew" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">تجديد الاشتراك</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-renew" id="modal-renew">

                        </div>
                    </div>
                </div>
            </div>
            <!-- Renew Subscribe -->
        </div>
        @include('admin.layouts_admin.myAjaxHelper')
    @endsection
    @section('ajaxCalls')
        <script>
            var columns = [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]


            // var ajax = {
            //     url: "{{ route('users.index') }}",
            //     data: function(d) {
            //         d.type = $('#type').val()
            //         // d.search = $('input[type="search"]').val()
            //     }
            // };

            showUserModal('{{ route('userUnvilable') }}')

            showData('{{ route('users.index') }}', columns);

            // Delete Using Ajax
            destroyScript('{{ route('users.destroy', ':id') }}');

            // Add Using Ajax
            showAddModal('{{ route('users.create') }}');
            addScript();
            // Add Using Ajax
            showEditModal('{{ route('users.edit', ':id') }}');
            editScript();

            showEdit1('{{ route('subscrView', ':id') }}')
        </script>
    @endsection
