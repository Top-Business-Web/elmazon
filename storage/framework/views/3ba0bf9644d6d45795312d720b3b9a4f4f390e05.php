<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="<?php echo e(route('questions.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">السؤال</label>
                    <textarea class="form-control" rows="3" name="question"></textarea>
                </div>
                <div class="col-md-6">
                    <label for="season" class="form-control-label">الصف</label>
                    <Select name="season_id" class="form-control seasonChoose" required="required">
                        <option selected disabled style="text-align: center">اختار صف</option>
                        <?php $__currentLoopData = $seasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $season): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($season->id); ?>"
                                    style="text-align: center"><?php echo e($season->name_ar); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="term" class="form-control-label">الترم</label>
                    <Select name="term_id" class="form-control user_choose" required="required">
                        <option selected disabled style="text-align: center">اختار ترم</option>
                        <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($term->id); ?>"
                                    style="text-align: center"><?php echo e($term->name_ar); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="type" class="form-control-label">النوع</label>
                    <Select name="examable_type" id="type" class="form-control type_choose" required="required">
                        <option selected disabled style="text-align: center">اختار النوع</option>
                        <option value="App\Models\Lesson" style="text-align: center">درس</option>
                        <option value="App\Models\SubjectClass" style="text-align: center">الوحدة</option>
                        <option value="App\Models\VideoParts" style="text-align: center">الفيديو</option>
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="lesson" class="form-control-label">الدرس</label>
                    <Select name="examable_id" class="form-control type_ajax_choose" required="required">
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="lesson" class="form-control-label">ملاحظة</label>
                    <textarea class="form-control" rows="10" name="note"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">أغلاق</button>
            <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
        </div>
    </form>
</div>

<script>

    $(".type_choose").change(function () {
        var element = document.getElementById("type");
        var value = $(element).find("option:selected").val();
        var season = $('.seasonChoose').find("option:selected").val();

        $.ajax({
            url: '<?php echo e(route('examble_type')); ?>',
            data: {
                'id': value,
                'season_id': season,
            },
            success: function (data) {
                $('.type_ajax_choose').html(data);
            }
        })
    })

</script>
<?php /**PATH C:\laragon\www\elmazon\resources\views/admin/questions/parts/create.blade.php ENDPATH**/ ?>