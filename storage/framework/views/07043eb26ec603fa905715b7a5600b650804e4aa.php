<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST"
        action="<?php echo e(route('subjectsClasses.update', $subjectsClass->id)); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden" value="<?php echo e($subjectsClass->id); ?>" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الاسم بالعربية</label>
                    <input type="text" class="form-control" value="<?php echo e($subjectsClass->name_ar); ?>" name="name_ar">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">الاسم بالانجليزية</label>
                    <input type="text" class="form-control" value="<?php echo e($subjectsClass->name_en); ?>" name="name_en">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الترم</label>
                    <Select name="term_id" class="form-control">
                        <option selected disabled style="text-align: center">اختار الترم</option>
                        <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($term->id); ?>"
                                <?php echo e($subjectsClass->term_id == $term->id ? 'selected' : ''); ?> style="text-align: center">
                                <?php echo e($term->name_en); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الصف</label>
                    <Select name="season_id" class="form-control">
                        <option selected disabled style="text-align: center">اختار الصف</option>
                        <?php $__currentLoopData = $seasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $season): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($season->id); ?>"
                                <?php echo e($subjectsClass->season_id == $season->id ? 'selected' : ''); ?>

                                style="text-align: center"><?php echo e($season->name_en); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="note" class="form-control-label">ملاحظة</label>
                    <textarea class="form-control" name="note" rows="8"><?php echo e($subjectsClass->note); ?></textarea>
                </div>
                <div class="col-md-6">
                        <label for="">الصورة :</label>
                        <input type="file" name="image" class="dropify"
                            data-default-file="<?php echo e($subjectsClass->image); ?>" />

                    <span class="form-text text-danger text-center"> Recomended : 2048 X 1200 to up Px <br> Extension :
                        png, gif, jpeg,
                        jpg,webp</span>

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-success" id="updateButton">تحديث</button>
        </div </form>
</div>
<script>
    $('.dropify').dropify()
</script>
<?php /**PATH C:\laragon\www\elmazon\resources\views/admin/subject_classes/parts/edit.blade.php ENDPATH**/ ?>