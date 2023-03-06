<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('onlineExam.store') }}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الاسم بالعربي</label>
                    <input type="text" class="form-control" name="name_ar" style="text-align: center">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">الاسم بالانجليزية</label>
                    <input type="text" class="form-control" name="name_en" style="text-align: center">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="note" class="form-control-label">تيرم</label>
                    <Select name="term_id" class="form-control">
                        <option selected disabled style="text-align: center">اختر تيرم</option>
                        @foreach($terms as $term)
                            <option value="{{ $term->id }}"
                                    style="text-align: center">{{ $term->name_en }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-control-label">فصل</label>
                    <Select name="season_id" class="form-control">
                        <option selected disabled style="text-align: center">اختر فصل</option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}"
                                    style="text-align: center">{{ $season->name_en }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="type" class="form-control-label">النوع</label>
                    <Select name="examable_type" id="type" class="form-control type_choose" required="required">
                        <option selected disabled style="text-align: center">اختار النوع</option>
                        <option value="App\Models\Lesson" style="text-align: center">درس</option>
                        <option value="App\Models\Season" style="text-align: center">فصل</option>
                        <option value="App\Models\VideoParts" style="text-align: center">الفيديو</option>
                    </Select>
                </div>
                <div class="col-md-12">
                    <label for="lesson" class="form-control-label">الدرس</label>
                    <Select name="examable_id" class="form-control type_ajax_choose" required="required">
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="note" class="form-control-label">ملاحظة</label>
                    <textarea class="form-control" rows="10" name="note"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin.close') }}</button>
            <button type="submit" class="btn btn-primary" id="addButton">{{ trans('admin.add') }}</button>
        </div>
    </form>
</div>

<script>

    $(".type_choose").click(function () {
        var element = document.getElementById("type");
        var value = $(element).find("option:selected").val();
        var season = $('.seasonChoose').find("option:selected").val();

        $.ajax({
            url: '{{ route('examble_type') }}',
            data: {
                'id': value,
                'season_id': season,
            },
            success: function (data) {
                $('.type_ajax_choose').html(data);
            }
        })
    })

</script>
