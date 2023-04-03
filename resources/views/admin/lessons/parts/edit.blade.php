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
                    <input type="text" class="form-control" value="{{ $lesson->name_en }}"  name="name_en">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="type" class="form-control-label">الصف</label>
                    <Select name="season_id" id="type" class="form-control type_choose">
                        <option disabled style="text-align: center">اختار الصف</option>
                        <option value="1"
                                {{ $lesson->subject_class_id == '1' ? 'selected' : '' }} style="text-align: center">
                            الصف الثانوي 1
                        </option>
                        <option value="2"
                                {{ $lesson->subject_class_id == '2' ? 'selected' : '' }} style="text-align: center">
                            الصف الثانوي 2
                        </option>
                        <option value="3"
                                {{ $lesson->subject_class_id == '3' ? 'selected' : '' }} style="text-align: center">
                            الصف الثانوي 3
                        </option>
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="lesson" class="form-control-label">الوحدة</label>
                    <Select name="subject_class_id" class="form-control type_ajax_choose">
                        @if($lesson->subject_class_id == '1')
                            @foreach(\Illuminate\Support\Facades\DB::table('subject_classes')->get() as $subject_class)
                                <option selected style="text-align: center"
                                        {{ $lesson->subject_class_id  == $subject_class->id ? 'selected' : '' }} value="{{ $subject_class->id }}">{{ $subject_class->name_ar }}</option>
                            @endforeach
                        @endif
                        @if($lesson->subject_class_id == '2')
                                @foreach(\Illuminate\Support\Facades\DB::table('subject_classes')->get() as $subject_class)
                                <option selected style="text-align: center"
                                        {{ $lesson->subject_class_id  == $subject_class->id ? 'selected' : '' }} value="{{ $subject_class->id }}">{{ $subject_class->name_ar }}</option>
                            @endforeach
                        @endif
                        @if($lesson->subject_class_id == '3')
                                @foreach(\Illuminate\Support\Facades\DB::table('subject_classes')->get() as $subject_class)
                                <option selected style="text-align: center"
                                        {{ $lesson->subject_class_id  == $subject_class->id ? 'selected' : '' }} value="{{ $subject_class->id }}">{{ $subject_class->name_ar }}</option>
                            @endforeach
                        @endif
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
    $(".season").on('change', function() {
        var element = document.getElementById("season_choose");
        var value = $(element).find('option:selected').val();

        $.ajax({
            url: '{{ route('showUnit') }}',
            data: {
                'id': value,
            },
            success: function (data) {
                $('.type_ajax_choose').html(data);
            }
        })
    })
</script>
