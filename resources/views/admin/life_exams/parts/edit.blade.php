<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('lifeExam.update', $lifeExam->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $lifeExam->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الاسم بالعربية</label>
                    <input type="text" style="text-align: center" value="{{ $lifeExam->name_ar}}" class="form-control" name="name_ar" required>
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">الاسم بالانجليزية</label>
                    <input type="text" style="text-align: center" value="{{ $lifeExam->name_en}}" class="form-control" name="name_en" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="date_exam" class="form-control-label">موعد الامتحان</label>
                    <input type="date" style="text-align: center" value="{{ $lifeExam->date_exam}}" class="form-control" name="date_exam" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="time_start" class="form-control-label">موعد البدء</label>
                    <input type="time" style="text-align: center" value="{{ $lifeExam->time_start}}" class="form-control" name="time_start" required>
                </div>
                <div class="col-md-6">
                    <label for="time_end" class="form-control-label">موعجد النهاية</label>
                    <input type="time" style="text-align: center" value="{{ $lifeExam->time_end}}" class="form-control" name="time_end" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الترم</label>
                    <Select name="term_id" class="form-control" required>
                        <option selected disabled style="text-align: center">اختار الترم</option>
                        @foreach ($data['terms'] as $term)
                            <option value="{{ $term->id }}"
                                    {{ $lifeExam->term_id == $term->id ? 'selected' : '' }} style="text-align: center">
                                {{ $term->name_en }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الصف</label>
                    <Select name="season_id" class="form-control" required>
                        <option selected disabled style="text-align: center">اختار الصف</option>
                        @foreach ($data['seasons'] as $season)
                            <option value="{{ $season->id }}"
                                    {{ $lifeExam->season_id == $season->id ? 'selected' : '' }}
                                    style="text-align: center">{{ $season->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="answer_video_file" class="form-control-label">ملف فيديو اجابة</label>
                    <input type="file" class="form-control" name="answer_video_file">
                </div>
                <div class="col-md-6">
                    <label for="answer_pdf_file" class="form-control-label">ملف ورقي اجابة</label>
                    <input type="file" class="form-control" name="answer_pdf_file">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="time_start" class="form-control-label">وقت الامتحان</label>
                    <input type="number" style="text-align: center" value="{{ $lifeExam->quiz_minute}}" class="form-control" name="quiz_minute" required>
                </div>
                <div class="col-md-4">
                    <label for="time_end" class="form-control-label">محاولات</label>
                    <input type="number" style="text-align: center" value="1" readonly class="form-control" name="trying" required>
                </div>
                <div class="col-md-4">
                    <label for="time_end" class="form-control-label">الدرجة</label>
                    <input type="number" style="text-align: center" value="{{ $lifeExam->degree}}" class="form-control" name="degree" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="note" class="form-control-label">ملاحظة</label>
                    <textarea class="form-control" name="note" rows="8">{{ $lifeExam->note}}</textarea>
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
