<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('audio.store') }}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الاسم</label>
                    <input type="file" class="form-control" name="audio">
                </div>
                <div class="col-md-6">
                    <label for="lesson" class="form-control-label">الدرس</label>
                    <Select name="lesson_id" class="form-control user_choose">
                        <option selected disabled style="text-align: center">اختار درس</option>
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}"
                                    style="text-align: center">{{ $lesson->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">أغلاق</button>
            <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
        </div>
    </form>
</div>

<script>
    $('.dropify').dropify()
</script>
