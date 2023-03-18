<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('slider.update', $slider->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $slider->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label for="type" class="form-control-label">النوع</label>
                    <select class="form-control" name="type" style="text-align: center">
                        <option style="text-align: center"
                                {{ $slider->type == 'image' ? 'selected' : '' }}
                                value="0">صورة</option>
                        <option style="text-align: center"
                                {{ $slider->type == 'video' ? 'selected' : '' }}
                                value="1">فيديو</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="phone" class="form-control-label">الصورة</label>
                    <input type="file" class="form-control dropify" data-default-file="{{ asset($slider->file) }}" min="11" name="file">
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
