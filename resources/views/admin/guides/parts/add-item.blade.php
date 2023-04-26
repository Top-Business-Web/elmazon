<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('addItems') }}">
        @csrf
        <input type="hidden" name="from_id" value="{{ $id }}" />
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
                    <label for="name_ar" class="form-control-label">الوحدة</label>
                    <Select name="subject_class_id" id="subject_id" class="form-control subject_id">
                        <option selected disabled style="text-align: center">اختار الوحدة</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}"
                                    style="text-align: center">{{ $subject->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="">الدرس</label>
                    <select name="lesson_id" id="lesson_id" class="form-control lesson_id">
                        <option value="" style="text-align: center">الكل</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="file" class="form-control-label">ملف المراجعة</label>
                   <input type="file" name="file" class="form-control"  required/>
                </div>
                <div class="col-md-4">
                    <label for="answer_pdf_file" class="form-control-label">ملف الاجابة (ملف ورقي)</label>
                    <input type="file" name="answer_pdf_file" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label for="answer_video_file" class="form-control-label">ملف الاجابة (فيديو)</label>
                    <input type="file" name="answer_video_file" class="form-control" />
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

    $(document).ready(function () {
        $('.subject_id').on('change', function () {
            let season = $(this).val();
            $.ajax({
                url: '{{ route("lessonSort")}}',
                method: 'GET',
                data: {
                    'id': season,
                }, success: function (data) {
                    $('.lesson_id').html(data);
                    console.log(data);
                }
            })
        })
    });

</script>
