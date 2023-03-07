<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="<?php echo e(route('terms.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label"><?php echo e(trans('admin.name_ar')); ?></label>
                    <input type="text" class="form-control" name="name_ar">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label"><?php echo e(trans('admin.name_en')); ?></label>
                    <input type="text" class="form-control" name="name_en">
                </div>
                <div class="col-md-12">
                    <label for="note" class="form-control-label"><?php echo e(trans('admin.note')); ?></label>
                    <textarea class="form-control" name="note" rows="10"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(trans('admin.close')); ?></button>
            <button type="submit" class="btn btn-primary" id="addButton"><?php echo e(trans('admin.add')); ?></button>
        </div>
    </form>
</div>

<script>
    $('.dropify').dropify()
</script>
<?php /**PATH C:\laragon\www\elmazon\resources\views/admin/terms/parts/create.blade.php ENDPATH**/ ?>