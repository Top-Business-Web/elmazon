<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="<?php echo e(route('slider.update', $slider->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden" value="<?php echo e($slider->id); ?>" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label for="image" class="form-control-label">الصورة</label>
                    <input type="file" class="form-control dropify" data-default-file="<?php echo e(asset($slider->image)); ?>" name="image">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-success" id="updateButton">تحديث</button>
        </div>
    </form>
</div>

<script>
    $('.dropify').dropify()
</script>
<?php /**PATH C:\laragon\www\students\resources\views/admin/sliders/parts/edit.blade.php ENDPATH**/ ?>