

<?php $__env->startSection('title'); ?>
    اسئلة امتحان الاونلاين
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page_name'); ?>
    اسئلة امتحان الاونلاين
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <form method="POST" action="">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="online_exam_id" value="<?php echo e($exam->id); ?>">
        <input type="hidden" name="all_exam_id">
        <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-striped table-bordered text-nowrap w-100" id="dataTable">
                                <thead>
                                    <tr class="fw-bolder text-muted bg-light">
                                        <th class="min-w-25px">#</th>
                                        <th class="min-w-50px">السؤال</th>
                                        <th class="min-w-50px">ملاحظة</th>
                                        <th class="min-w-50px">فصل</th>
                                        <th class="min-w-50px">الترم</th>
                                        <th class="min-w-50px">نوع المثال</th>
                                        <th class="min-w-50px">المثال</th>
                                        <th class="min-w-50px rounded-end">العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($question->id); ?></td>
                                            <td><?php echo e($question->question); ?></td>
                                            <td><?php echo e($question->note); ?></td>
                                            <td><?php echo e($question->season_id); ?></td>
                                            <td><?php echo e($question->term_id); ?></td>
                                            <td><?php echo e($question->examable_type); ?></td>
                                            <td><?php echo e($question->examable_id); ?></td>
                                            <td><input type="checkbox"
                                                 class="form-control check1 check" name="question_id" 
                                                 <?php echo e((in_array($question->id,$online_questions_ids)? "checked":'')); ?>

                                                    value="<?php echo e($question->id); ?>"
                                                     id="check"></td>
                                                     

                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php echo $__env->make('Admin/layouts_admin/myAjaxHelper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('ajaxCalls'); ?>
    <script>
        $(".check").on('click', function() {
           
            var exam = $('input[name="online_exam_id"]').val();
            var question = $(this).val();
            
            if ($(this).is(':checked')) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo e(route('addQuestion')); ?>',
                    data: {
                       
                        online_exam_id: exam,
                        question_id: question,
                        "_token": $('#token').val()

                    },
                    success: function(data) {
                        toastr.success('تم الاضافة بنجاح');
                    },
                    error: function(data) {
                        toastr.error('هناك خطأ ما ..');
                    }

                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo e(route('deleteQuestion')); ?>',
                    data: {

                        online_exam_id: exam,
                        question_id: question,
                        "_token": $('#token').val()

                    },
                    success: function(data) {
                        toastr.success('تم الحذف بنحاح بنجاح');
                    },
                    error: function(data) {
                        toastr.error('هناك خطأ ما ..');
                    }
                })
            }
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Admin/layouts_admin/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\elmazon\resources\views/admin/online_exam/parts/questions.blade.php ENDPATH**/ ?>