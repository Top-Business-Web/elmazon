<div class="modal-body">
    <form id="update_renwal" class="update_renwal" method="POST" action="<?php echo e(route('subscr_renew',$user->id)); ?>">
        <?php echo csrf_field(); ?>

        <input type="hidden" name="id" value="<?php echo e($user->id); ?>">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="date_start_code" class="form-control-label">تاريخ بداية الاشتراك</label>
                    <input type="date" class="form-control" value="<?php echo e($user->date_start_code); ?>" name="date_start_code" placeholder="تاريخ بداية الاشتراك"
                           required="required">
                </div>
                <div class="col-md-6">
                    <label for="date_end_code" class="form-control-label">تاريخ نهاية الاشتراك</label>
                    <input type="date" class="form-control" value="<?php echo e($user->date_end_code); ?>" name="date_end_code" placeholder="تاريخ نهاية الاشتراك"
                           required="required">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-primary" id="update2">تحديث</button>
        </div>
    </form>
</div>


<?php /**PATH C:\laragon\www\students\resources\views/admin/users/parts/subscription_renewal.blade.php ENDPATH**/ ?>