<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('videosParts.update', $videosPart->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $videosPart->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الاسم باللغة العربية</label>
                    <input type="text" class="form-control" value="{{ $videosPart->name_ar }}" name="name_ar">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">الاسم باللغة الانجليزية</label>
                    <input type="text" class="form-control" value="{{ $videosPart->name_en }}" name="name_en">
                </div>
                <div class="col-md-12">
                    <label for="lesson_id" class="form-control-label">درس</label>
                    <Select name="lesson_id" class="form-control user_choose">
                        <option selected disabled style="text-align: center">اختار درس</option>
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}"
                                    {{ $videosPart->lesson_id == $lesson->id? 'selected' : '' }}
                                    style="text-align: center">{{ $lesson->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 video_link">
                    <label for="video_link" class="form-control-label">لينك الفيديو</label>
                    <input type="file" name="video_link" {{ $videosPart->video_link }} class="form-control"
                           data-default-file=""/>
                </div>
                <div class="col-md-6 video_date">
                    <label for="video_date" class="form-control-label">وقت الفيديو</label>
                    <input type="text" class="form-control" value="{{ $videosPart->video_time }}" name="video_time">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="name_en" class="form-control-label">ملاحظة</label>
                    <textarea class="form-control" name="note" rows="10">{{ $videosPart->note }}</textarea>
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
