<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="<?php echo e(route('lessons.update', $lesson->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden" value="<?php echo e($lesson->id); ?>" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الاسم باللغة العربية</label>
                    <input type="text" class="form-control" value="<?php echo e($lesson->name_ar); ?>" name="name_ar">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">الاسم باللغة الانجليزية</label>
                    <input type="text" class="form-control" value="<?php echo e($lesson->name_ar); ?>" name="name_en">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="name_ar" class="form-control-label">فصل</label>
                    <Select name="subject_class_id" class="form-control">
                        <option selected disabled style="text-align: center">اختار فصل</option>
                        <?php $__currentLoopData = $subjects_classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject_class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($subject_class->id); ?>"
                                    <?php echo e($lesson->subject_class_id == $subject_class->id? 'selected' : ''); ?>

                                    style="text-align: center"><?php echo e($subject_class->name_en); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="note" class="form-control-label">ملاحظة</label>
                    <textarea class="form-control" name="note" rows="10"><?php echo e($lesson->note); ?></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-success" id="updateButton">تحديث</button>
        </div>
    </form>
</div>
<script>
    $('.dropify').dropify()
</script>
<?php /**PATH C:\laragon\www\students\resources\views/admin/lessons/parts/edit.blade.php ENDPATH**/ ?>