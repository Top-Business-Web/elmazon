<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="<?php echo e(route('questions.update', $question->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden" value="<?php echo e($question->id); ?>" name="id">
        <div class="form-group">
            <div class="col-md-2">
                <label class="">الدرجة</label>
                <input class="form-control" name="degree" value="<?php echo e($question->degree); ?>" type="number"/>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">السؤال</label>
                    <textarea class="form-control" rows="3" name="question"><?php echo e($question->question); ?></textarea>
                </div>
                <div class="col-md-6">
                    <label for="season" class="form-control-label">الصف</label>
                    <Select name="season_id" class="form-control user_choose">
                        <option selected disabled style="text-align: center">اختار صف</option>
                        <?php $__currentLoopData = $seasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $season): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($season->id); ?>"
                                    <?php echo e($question->season_id == $season->id ? 'selected' : ''); ?>

                                    style="text-align: center"><?php echo e($season->name_ar); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="term" class="form-control-label">الترم</label>
                    <Select name="term_id" class="form-control user_choose">
                        <option selected disabled style="text-align: center">اختار ترم</option>
                        <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($term->id); ?>"
                                    <?php echo e($question->term_id == $term->id? 'selected' : ''); ?>

                                    style="text-align: center"><?php echo e($term->name_ar); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="type" class="form-control-label">النوع</label>
                    <Select name="examable_type" id="type" class="form-control type_choose">
                        <option disabled style="text-align: center">اختار النوع</option>
                        <option value="App\Models\Lesson"
                                <?php echo e($question->examable_type == 'App\Models\Lesson' ? 'selected' : ''); ?> style="text-align: center">
                            درس
                        </option>
                        <option value="App\Models\Season"
                                <?php echo e($question->examable_type == 'App\Models\Season' ? 'selected' : ''); ?> style="text-align: center">
                            فصل
                        </option>
                        <option value="App\Models\VideoParts"
                                <?php echo e($question->examable_type == 'App\Models\VideoParts' ? 'selected' : ''); ?> style="text-align: center">
                            الفيديو
                        </option>
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="lesson" class="form-control-label">الدرس</label>
                    <Select name="examable_id" class="form-control type_ajax_choose">
                        <?php if($question->examable_type == 'App\Models\Lesson'): ?>
                            <?php $__currentLoopData = \Illuminate\Support\Facades\DB::table('lessons')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option selected style="text-align: center"
                                        <?php echo e($question->examable_id  == $lesson->id ? 'selected' : ''); ?> value="<?php echo e($lesson->id); ?>"><?php echo e($lesson->name_ar); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <?php if($question->examable_type == 'App\Models\Season'): ?>
                            <?php $__currentLoopData = \Illuminate\Support\Facades\DB::table('seasons')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $season): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option selected style="text-align: center"
                                        <?php echo e($question->examable_id  == $season->id ? 'selected' : ''); ?> value="<?php echo e($season->id); ?>"><?php echo e($season->name_ar); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <?php if($question->examable_type == 'App\Models\VideoParts'): ?>
                            <?php $__currentLoopData = \Illuminate\Support\Facades\DB::table('video_parts')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $videoparts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option selected style="text-align: center"
                                        <?php echo e($question->examable_id  == $videoparts->id ? 'selected' : ''); ?> value="<?php echo e($videoparts->id); ?>"><?php echo e($videoparts->name_ar); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="lesson" class="form-control-label">ملاحظة</label>
                    <textarea class="form-control" rows="8" name="note"><?php echo e($question->note); ?></textarea>
                </div>
                <div class="col-md-6">
                    <label for="">الصورة :</label>
                    <input type="file" name="image" class="dropify"
                           data-default-file="<?php echo e(asset($question->image)); ?>"/>
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

    $('.dropify').dropify();

    $(".type_choose").change(function () {
        var element = document.getElementById("type");
        var value = $(element).find("option:selected").val();

        $.ajax({
            url: '<?php echo e(route('examble_type')); ?>',
            data: {id: value},
            success: function (data) {
                $('.type_ajax_choose').html(data);
            }
        })
    })

</script>
<?php /**PATH C:\laragon\www\elmazon\resources\views/admin/questions/parts/edit.blade.php ENDPATH**/ ?>