<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="<?php echo e(route('users.update',$user->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>
        <input type="hidden" name="id" value="<?php echo e($user->id); ?>">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Image :</label>
                        <input type="file" name="image" class="dropify" value="<?php echo e(($user->image !== null) ? asset($user->image) : asset('users/default/avatar.jpg')); ?>"
                               data-default-file="<?php echo e(($user->image !== null) ? asset($user->image) : asset('users/default/avatar.jpg')); ?>"/>
                    </div>
                    <span class="form-text text-danger text-center">
                        Recomended : 2048 X 1200 to up Px <br>
                        Extension : png, gif, jpeg,jpg,webp
                    </span>
                </div>
                <div class="col-md-6 mt-8">
                    <label for="name" class="form-control-label">اسم الطالب</label>
                    <input type="text" class="form-control" placeholder="اسم الطالب" name="name"
                           required="required" value="<?php echo e($user->name); ?>">
                    <div class="row">
                        <div class="col-7">
                            <label for="code" class="form-control-label">كود الطالب</label>
                            <input type="text" class="form-control CodeStudent" placeholder="كود الطالب" name="code"
                                   disabled  required="required" value="<?php echo e($user->code); ?>">
                            <input type="hidden" class="form-control CodeStudent" placeholder="كود الطالب" name="code" value="<?php echo e($user->code); ?>">
                        </div>
                        <div class="col-5">
                            <button type="button" hidden
                                    class="btn btn-sm btn-primary form-control mt-5 GeneCode">
                                generate code
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <label for="phone" class="form-control-label">رقم الهاتف</label>
                    <input type="text" class="form-control phoneInput" value="<?php echo e($user->phone); ?>" name="phone" placeholder="201XXXXXXXXX"
                           required="required">
                </div>
                <div class="col-md-6">
                    <label for="father_phone" class="form-control-label">رقم هاتف ولي الامر</label>
                    <input type="text" class="form-control" value="<?php echo e($user->father_phone); ?>" name="father_phone" placeholder="201XXXXXXXXX"
                           required="required">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name" class="form-control-label">الصف الدراسي</label>
                    <select class="form-control SeasonSelect" name="season_id" required="required">
                        <option value="" data-name="" disabled>اختار الصف</option>
                        <?php $__currentLoopData = $seasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $season): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                <?php echo e(($user->season_id == $season->id) ? 'selected' : ''); ?>

                                value="<?php echo e($season->id); ?>">
                                <?php echo e($season->name_ar); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="country_id" class="form-control-label">المحافظة</label>
                    <select class="form-control" name="country_id" required="required">
                        <option value="" disabled>اختار المحافظة</option>
                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                <?php echo e(($user->country_id == $country->id) ? 'selected' : ''); ?>

                                value="<?php echo e($country->id); ?>">
                                <?php echo e($country->name_ar); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
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
            <button type="submit" class="btn btn-primary" id="addButton">تحديث</button>
        </div>
    </form>
</div>

<script>
    $('.dropify').dropify()

    $('.GeneCode').on('click', function () {
        // var data = $(this).val();
        // var phone = $('.phoneInput').val();
        var code = Math.floor(Math.random() * 9999999999999);
        var userCode = ''
        $('.CodeStudent').val(code);
    })
</script>
<?php /**PATH C:\laragon\www\students\resources\views/admin/users/parts/edit.blade.php ENDPATH**/ ?>