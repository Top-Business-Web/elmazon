<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('allExam.store') }}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الاسم بالعربية</label>
                    <input type="text" class="form-control" name="name_ar">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">الاسم بالانجليزية</label>
                    <input type="text" class="form-control" name="name_en">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="note" class="form-control-label">تيرم</label>
                    <Select name="term_id" class="form-control">
                        <option selected disabled style="text-align: center">اختر تيرم</option>
                        @foreach($data['terms'] as $term)
                            <option value="{{ $term->id }}"
                                    style="text-align: center">{{ $term->name_en }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-control-label">فصل</label>
                    <Select name="season_id" class="form-control">
                        <option selected disabled style="text-align: center">اختر فصل</option>
                        @foreach($data['seasons'] as $season)
                            <option value="{{ $season->id }}"
                                    style="text-align: center">{{ $season->name_en }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">وقت الامتحان</label>
                    <input type="number" class="form-control" name="quize_minute">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">عدد المحاولات</label>
                    <input type="number" class="form-control" name="trying_number">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الدرجة</label>
                    <input type="number" class="form-control" name="degree">
                </div>
                <div class="col-md-6">
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
    $('.dropify').dropify()
</script>
