<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="<?php echo e(route('monthlyPlans.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label for="name_ar" class="form-control-label">العنوان</label>
                    <input type="text" class="form-control" name="title" style="text-align: center">
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-control-label">من</label>
                    <input type="date" class="form-control" name="start">
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-control-label">الى</label>
                    <input type="date" class="form-control" name="end">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(trans('admin.close')); ?></button>
            <button type="submit" class="btn btn-primary" id="addButton"><?php echo e(trans('admin.add')); ?></button>
        </div>
    </form>
</div>
<?php /**PATH C:\laragon\www\students\resources\views/admin/monthly_plans/parts/create.blade.php ENDPATH**/ ?>