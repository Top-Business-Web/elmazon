<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('videosParts.store') }}" enctype="multipart/form-data">
        @csrf
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
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}"
                                    style="text-align: center">{{ $lesson->name_ar }}</option>
                        @endforeach
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

