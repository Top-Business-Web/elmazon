<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="<?php echo e(route('seasons.update', $season->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden" value="<?php echo e($season->id); ?>" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label"><?php echo e(trans('admin.name_ar')); ?></label>
                    <input type="text" class="form-control" value="<?php echo e($season->name_ar); ?>" name="name_ar">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label"><?php echo e(trans('admin.name_en')); ?></label>
                    <input type="text" class="form-control" value="<?php echo e($season->name_en); ?>" name="name_en">
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
<?php /**PATH C:\laragon\www\students\resources\views/admin/seasons/parts/edit.blade.php ENDPATH**/ ?>