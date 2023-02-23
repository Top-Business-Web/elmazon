<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('lessons.update', $lesson->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $lesson->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الاسم باللغة العربية</label>
                    <input type="text" class="form-control" value="{{ $lesson->name_ar }}" name="name_ar">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">الاسم باللغة الانجليزية</label>
                    <input type="text" class="form-control" value="{{ $lesson->name_ar }}" name="name_en">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="name_ar" class="form-control-label">فصل</label>
                    <Select name="subject_class_id" class="form-control">
                        <option selected disabled style="text-align: center">اختار فصل</option>
                        @foreach($subjects_classes as $subject_class)
                            <option value="{{ $subject_class->id }}"
                                    {{ $lesson->subject_class_id == $subject_class->id? 'selected' : '' }}
                                    style="text-align: center">{{ $subject_class->name_en }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="note" class="form-control-label">ملاحظة</label>
                    <textarea class="form-control" name="note" rows="10">{{ $lesson->note }}</textarea>
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
