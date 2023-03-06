<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="<?php echo e(route('monthlyPlans.update', $monthlyPlan->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden" value="<?php echo e($monthlyPlan->id); ?>" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label for="name_ar" class="form-control-label">العنوان</label>
                    <input type="text" class="form-control" value="<?php echo e($monthlyPlan->title); ?>" name="title" style="text-align: center">
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-control-label">من</label>
                    <input type="date" class="form-control" value="<?php echo e($monthlyPlan->start); ?>" name="start">
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-control-label">الى</label>
                    <input type="date" class="form-control" value="<?php echo e($monthlyPlan->end); ?>" name="end">
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
<?php /**PATH C:\laragon\www\students\resources\views/admin/monthly_plans/parts/edit.blade.php ENDPATH**/ ?>