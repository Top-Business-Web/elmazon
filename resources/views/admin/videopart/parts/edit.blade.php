<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('videosParts.update', $videosPart->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $videosPart->id }}" name="id">
        <div class="form-group">
            <input type="hidden" name="ordered" value="" />
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
{{--                        <option value="" style="text-align: center">فيديوهات عامة</option>--}}
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}"
                                    {{ $videosPart->lesson_id == $lesson->id ? 'selected' : '' }}
                                    style="text-align: center">{{ $lesson->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="type" class="form-control-label">النوع</label>
                    <select class="form-control type" id="type" name="type">
                        <option value="1" {{ $videosPart->type == 'pdf' ? 'selected' : '' }}>ملف ورقي</option>
                        <option value="2" {{ $videosPart->type == 'audio' ? 'selected' : '' }}>صوت</option>
                        <option value="3" {{ $videosPart->type == 'video' ? 'selected' : '' }}>فيديو</option>
                    </select>
                </div>
                <div class="col-md-4 video_link">
                    <label for="video_link" class="form-control-label">لينك</label>
                    <input type="file" name="link" value="{{ $videosPart->link }}" class="form-control"
                           data-default-file=""/>
                </div>
                <div class="col-md-4 video_date" hidden>
                    <label for="video_date" class="form-control-label">وقت الفيديو</label>
                    <input type="text" id="date_video" value="{{ $videosPart->video_time }}" class="form-control" name="video_time">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="background_color" class="form-control-label">لون الخلفية</label>
                    <input type="color" id="background_color" class="form-control" name="background_color" value="{{ $videosPart->background_color }}">
                </div>
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
<!-- fix -->
