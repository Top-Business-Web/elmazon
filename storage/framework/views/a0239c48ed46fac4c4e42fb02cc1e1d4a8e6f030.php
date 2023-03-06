<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="<?php echo e(route('phoneCommunications.update', $phoneCommunication->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden" value="<?php echo e($phoneCommunication->id); ?>" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label for="phone" class="form-control-label">ألهاتف</label>
                    <input type="number" class="form-control" value="<?php echo e($phoneCommunication->phone); ?>" name="phone">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="name_en" class="form-control-label">ملاحظة</label>
                    <textarea class="form-control" rows="10" name="note"><?php echo e($phoneCommunication->note); ?></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(trans('admin.close')); ?></button>
            <button type="submit" class="btn btn-success" id="updateButton"><?php echo e(trans('admin.update')); ?></button>
        </div>
    </form>
</div>
<?php /**PATH C:\laragon\www\students\resources\views/admin/phone_communications/parts/edit.blade.php ENDPATH**/ ?>