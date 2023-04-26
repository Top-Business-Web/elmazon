<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('guide.update', $guide->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $guide->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="section_name_ar" class="form-control-label">العنوان بالعربية</label>
                    <input type="text" class="form-control" value="{{ $guide->title_ar }}" name="title_ar" required>
                </div>
                <div class="col-md-6">
                    <label for="section_name_en" class="form-control-label">العنوان بالانجليزية</label>
                    <input type="text" class="form-control" value="{{ $guide->title_en }}" name="title_en" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="section_name_ar" class="form-control-label">الوصف بالعربية</label>
                    <textarea class="form-control" name="description_ar" rows="8" required>{{ $guide->description_ar }}</textarea>
                </div>
                <div class="col-md-6">
                    <label for="section_name_en" class="form-control-label">الوصف بالانجليزية</label>
                    <textarea class="form-control" name="description_en" rows="8" required>{{ $guide->description_en }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="section_name_ar" class="form-control-label">ايقونة</label>
                    <input type="file" name="icon" class="dropify" data-default-file="{{ asset($guide->icon) }}"/>
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
