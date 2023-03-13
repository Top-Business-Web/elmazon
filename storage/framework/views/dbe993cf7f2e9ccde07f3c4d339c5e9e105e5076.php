<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="<?php echo e(route('slider.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label for="phone" class="form-control-label">الصورة</label>
                    <input type="file" class="form-control dropify" min="11" name="image">
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
    $('.dropify').dropify()
</script>
<?php /**PATH C:\laragon\www\elmazon\resources\views/admin/sliders/parts/create.blade.php ENDPATH**/ ?>