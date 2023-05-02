<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('lifeExam.store') }}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الاسم بالعربية</label>
                    <input type="text" style="text-align: center" class="form-control" name="name_ar" required>
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">الاسم بالانجليزية</label>
                    <input type="text" style="text-align: center" class="form-control" name="name_en" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="date_exam" class="form-control-label">موعد الامتحان</label>
                    <input type="date" style="text-align: center" class="form-control" name="date_exam" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="time_start" class="form-control-label">موعد البدء</label>
                    <input type="time" style="text-align: center" class="form-control" name="time_start" required>
                </div>
                <div class="col-md-6">
                    <label for="time_end" class="form-control-label">موعجد النهاية</label>
                    <input type="time" style="text-align: center" class="form-control" name="time_end" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="term_id" class="form-control-label">الترم</label>
                    <Select name="term_id" class="form-control" required>
                        <option selected disabled style="text-align: center">اختار ترم</option>
                        @foreach($terms as $term)
                            <option value="{{ $term->id }}"
                                    style="text-align: center">{{ $term->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="season_id" class="form-control-label">الصف</label>
                    <Select name="season_id" class="form-control" required>
                        <option selected disabled style="text-align: center">اختار الصف</option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}"
                                    style="text-align: center">{{ $season->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="time_start" class="form-control-label">وقت الامتحان</label>
                    <input type="number" style="text-align: center" class="form-control" name="quiz_minute" required>
                </div>
                <div class="col-md-4">
                    <label for="time_end" class="form-control-label">محاولات</label>
                    <input type="number" style="text-align: center" class="form-control" name="trying" required>
                </div>
                <div class="col-md-4">
                    <label for="time_end" class="form-control-label">الدرجة</label>
                    <input type="number" style="text-align: center" class="form-control" name="degree" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="note" class="form-control-label">ملاحظة</label>
                   <textarea class="form-control" name="note" rows="8"></textarea>
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

</script>
