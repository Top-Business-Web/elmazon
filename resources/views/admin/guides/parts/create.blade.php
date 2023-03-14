<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('guide.store') }}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="section_name_ar" class="form-control-label">العنوان بالعربية</label>
                    <input type="text" class="form-control" name="title_ar" required>
                </div>
                <div class="col-md-6">
                    <label for="section_name_en" class="form-control-label">العنوان بالانجليزية</label>
                    <input type="text" class="form-control" name="title_en" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="section_name_ar" class="form-control-label">الوصف بالعربية</label>
                    <textarea class="form-control" name="description_ar" rows="8" required></textarea>
                </div>
                <div class="col-md-6">
                    <label for="section_name_en" class="form-control-label">الوصف بالانجليزية</label>
                    <textarea class="form-control" name="description_en" rows="8" required></textarea>
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
