<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('ads.update', $ad->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $ad->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label for="name_ar" class="form-control-label">اللينك</label>
                    <input type="text" class="form-control" value="{{ $ad->link }}" name="link">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="name_en" class="form-control-label">الصورة</label>
                    <input type="file" class="form-control dropify" data-default-file="{{ asset($ad->image) }}" min="11" name="image">
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-success" id="updateButton">اضافة</button>
        </div>
    </form>
</div>
<script>
    $('.dropify').dropify()
</script>
