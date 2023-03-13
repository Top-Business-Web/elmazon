

<?php $__env->startSection('title'); ?>
    بنك الاسئلة
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page_name'); ?>
    سؤال
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
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
                        <table class="table table-striped table-bordered text-nowrap w-100" id="dataTable">
                            <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="min-w-25px">#</th>
                                <th class="min-w-50px">السؤال</th>
                                <th class="min-w-50px">الملاحظة</th>
                                <th class="min-w-50px">الفصل</th>
                                <th class="min-w-50px">الترم</th>
                                <th class="min-w-50px">نوع المثال</th>
                                <th class="min-w-50px">المثال</th>
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
    </div>
    <?php echo $__env->make('Admin/layouts_admin/myAjaxHelper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('ajaxCalls'); ?>
    <script>

        function showEdit(routeOfEdit){
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
            {data: 'note', name: 'note'},
            {data: 'season_id', name: 'season_id'},
            {data: 'term_id', name: 'term_id'},
            {data: 'examable_type', name: 'examable_type'},
            {data: 'examable_id', name: 'examable_id'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('<?php echo e(route('questions.index')); ?>', columns);
        // Delete Using Ajax
        destroyScript('<?php echo e(route('questions.destroy',':id')); ?>');
        // Add Using Ajax
        showAddModal('<?php echo e(route('questions.create')); ?>');
        addScript();
        // Add Using Ajax
        showEditModal('<?php echo e(route('questions.edit',':id')); ?>');
        editScript();

        showEdit('<?php echo e(route('answer',':id')); ?>');
        addAnswer();

    </script>
<?php $__env->stopSection(); ?>

<!-- fix -->


<?php echo $__env->make('Admin/layouts_admin/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\elmazon\resources\views/admin/questions/index.blade.php ENDPATH**/ ?>