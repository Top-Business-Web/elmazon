<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="<?php echo e(route('subjectsClasses.store')); ?>" enctype="multipart/form-data">
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
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label"><?php echo e(trans('admin.season')); ?></label>
                    <Select name="term_id" class="form-control">
                        <option selected disabled style="text-align: center">Select Season</option>
                        <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($term->id); ?>"
                                    style="text-align: center"><?php echo e($term->name_en); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-control-label"><?php echo e(trans('admin.note')); ?></label>
                    <input type="text" class="form-control" name="note">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Image :</label>
                        <input type="file" name="image" class="dropify"
                               data-default-file=""/>

                    </div>
                    <span class="form-text text-danger text-center"> Recomended : 2048 X 1200 to up Px <br> Extension : png, gif, jpeg,
                                        jpg,webp</span>

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
    $('.dropify').dropify();
</script>

<?php /**PATH C:\laragon\www\students\resources\views/admin/subject_classes/parts/create.blade.php ENDPATH**/ ?>