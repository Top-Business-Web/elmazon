<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('slider.update', $slider->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $slider->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label for="image" class="form-control-label">الصورة</label>
                    <input type="file" class="form-control dropify" data-default-file="{{ asset($slider->image) }}" name="image">
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
