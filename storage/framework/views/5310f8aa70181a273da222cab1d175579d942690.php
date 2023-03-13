<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="<?php echo e(route('section.update', $section->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden" value="<?php echo e($section->id); ?>" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="section_name_ar" class="form-control-label">الاسم بالعربية</label>
                    <input type="text" class="form-control" value="<?php echo e($section->section_name_ar); ?>" name="section_name_ar">
                </div>
                <div class="col-md-6">
                    <label for="section_name_en" class="form-control-label">الاسم بالانجليزية</label>
                    <input type="text" class="form-control" value="<?php echo e($section->section_name_en); ?>" name="section_name_en">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="section_name_ar" class="form-control-label">العنوان</label>
                    <input type="text" class="form-control" value="<?php echo e($section->address); ?>" name="address">
                </div>
                <div class="col-md-6">
                    <label for="section_name_en" class="form-control-label">السعة</label>
                    <input type="number" class="form-control" value="<?php echo e($section->capacity); ?>" name="capacity">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(trans('admin.close')); ?></button>
            <button type="submit" class="btn btn-success" id="updateButton"><?php echo e(trans('admin.update')); ?></button>
        </div>
    </form>
</div>
<?php /**PATH C:\laragon\www\elmazon\resources\views/admin/sections/parts/edit.blade.php ENDPATH**/ ?>