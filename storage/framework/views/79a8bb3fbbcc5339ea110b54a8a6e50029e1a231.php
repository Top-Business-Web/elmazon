<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="<?php echo e(route('pdf.update', $pdf->id)); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden" value="<?php echo e($pdf->id); ?>" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="pdf" class="form-control-label">الاسم</label>
                    <input type="file" class="form-control" value="<?php echo e($pdf->pdf); ?>" name="pdf">
                </div>
                <div class="col-md-6">
                    <label for="lesson" class="form-control-label">الدرس</label>
                    <Select name="lesson_id" class="form-control user_choose">
                        <option selected disabled style="text-align: center">اختار درس</option>
                        <?php $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($lesson->id); ?>"
                                    <?php echo e($pdf->lesson_id == $lesson->id? 'selected' : ''); ?>

                                    style="text-align: center"><?php echo e($lesson->name_ar); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </Select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(trans('admin.close')); ?></button>
            <button type="submit" class="btn btn-success" id="updateButton"><?php echo e(trans('admin.update')); ?></button>
        </div>
    </form>
</div>
<script>
    $('.dropify').dropify()
</script>
<?php /**PATH C:\laragon\www\students\resources\views/admin/pdf_file_uploads/parts/edit.blade.php ENDPATH**/ ?>