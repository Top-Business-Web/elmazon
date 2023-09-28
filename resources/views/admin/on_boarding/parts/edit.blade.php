<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('onBoarding.update', $onBoarding->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $onBoarding->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label for="type" class="form-control-label"> العنوان باللغة العربية</label>
                    <input class="form-control" name="title_ar" value="{{$onBoarding->title_ar}}" required />
                </div>
                <div class="col-md-12">
                    <label for="type" class="form-control-label"> العنوان باللغة الانجليزية</label>
                    <input class="form-control" name="title_en" value="{{$onBoarding->title_en}}" required />
                </div>
                <div class="col-md-12">
                    <label for="type" class="form-control-label">الوصف باللغة العربية</label>
                    <input class="form-control" name="description_ar" value="{{$onBoarding->description_ar}}" required />
                </div>
                <div class="col-md-12">
                    <label for="type" class="form-control-label">الوصف باللغة الانجليزية</label>
                    <input class="form-control" name="description_en" value="{{$onBoarding->description_en}}" required />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="phone" class="form-control-label">الصورة</label>
                    <input type="file" class="form-control dropify" data-default-file="{{ asset($onBoarding->image) }}" min="11" name="image">
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
