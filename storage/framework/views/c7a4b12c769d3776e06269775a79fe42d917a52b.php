<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="<?php echo e(route('videosParts.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الاسم باللغة العربية</label>
                    <input type="text" class="form-control" name="name_ar">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">الاسم باللغة الانجليزية</label>
                    <input type="text" class="form-control" name="name_en">
                </div>
                <div class="col-md-12">
                    <label for="lesson_id" class="form-control-label">درس</label>
                    <Select name="lesson_id" class="form-control user_choose">
                        <option selected disabled style="text-align: center">اختار درس</option>
                        <option value="" style="text-align: center">فيديوهات عامة</option>
                        <?php $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($lesson->id); ?>"
                                    style="text-align: center"><?php echo e($lesson->name_ar); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 video_link">
                    <label for="video_link" class="form-control-label">لينك الفيديو</label>
                    <input type="file" name="video_link" class="form-control"
                           data-default-file=""/>
                </div>
                <div class="col-md-6 video_date">
                    <label for="video_date" class="form-control-label">وقت الفيديو</label>
                    <input type="text" class="form-control" name="video_time">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="name_en" class="form-control-label">ملاحظة</label>
                    <textarea class="form-control" name="note" rows="10"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
        </div>
    </form>
</div>
<script>
    $('.dropify').dropify();

    // $(".user_choose").on("change", function () {
    //     var getValue = $(this).find("option:selected").val();
    //     alert(getValue);
    //     $('.video_link').prop('hidden', false);
    // })


</script>
<!-- fix -->

<?php /**PATH C:\laragon\www\elmazon\resources\views/admin/videopart/parts/create.blade.php ENDPATH**/ ?>