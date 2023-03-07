

<?php $__env->startSection('title'); ?>
     الاعدادات
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page_name'); ?>
     الاعدادات
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<form method="POST" id="updateForm" class="updateForm" action="<?php echo e(route('setting.update', $settings->id)); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <input type="hidden" name="id" value="<?php echo e($settings->id); ?>">
    <div class="row mt-4">
        <div class="col-4">
            <div class="card" style="padding: 13px">
                <!-- Start Row -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="facebook_link">Facebook :</label>
                            <input type="text" name="facebook_link" value="<?php echo e($settings->facebook_link); ?>" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Youtube :</label>
                            <input type="text" name="youtube_link" value="<?php echo e($settings->youtube_link); ?>" value=""
                                class="form-control" />
                        </div>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" id="updateButton">تحديث</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Form -->
    <?php echo $__env->make('Admin/layouts_admin/myAjaxHelper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>






<?php echo $__env->make('Admin/layouts_admin/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\elmazon\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>