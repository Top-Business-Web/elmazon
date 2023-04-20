<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('onlineExam.store') }}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label for="name_ar" class="form-control-label">نوع الامتحان</label>
                    <select name="exam_type" class="form-control" id="exam_type" required="required">
                        <option value="">اختر نوع الامتحان</option>
                        <option value="pdf">PDF</option>
                        <option value="online">Online</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <label for="name_ar" class="form-control-label">الدرجة</label>
                    <input type="number" class="form-control" name="degree" style="text-align: center">
                </div>
                <div class="col-md-5">
                    <label for="date_exam" class="form-control-label">موعد الامتحان</label>
                    <input type="date" class="form-control" name="date_exam" style="text-align: center">
                </div>
                <div class="col-md-3">
                    <label for="name_en" class="form-control-label"> وقت الامتحان</label>
                    <input type="number" class="form-control" name="quize_minute" style="text-align: center" placeholder="الوقت بالدقائق">
                </div>
                <div class="col-md-2">
                    <label for="name_en" class="form-control-label"> عدد المحاولات </label>
                    <input type="number" class="form-control" value="" name="trying_number" style="text-align: center" placeholder="عدد المحاولات">
                </div>
            </div>

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
                    <label for="note" class="form-control-label">الصف</label>
                    <Select name="season_id" class="form-control selectSeason">
                        <option selected disabled style="text-align: center">اختر الصف</option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}"
                                    style="text-align: center">{{ $season->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-control-label">تيرم</label>
                    <Select name="term_id" class="form-control selectTerm">
                        <option selected disabled style="text-align: center">اختر تيرم</option>
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
                    <label for="note" class="form-control-label">التعليمات</label>
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

        // $('#exam_type').change( function(){
        //     $(this).val();
        //     alert($(this).val())
        // })

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

    $(document).ready(function () {
        $('select[name="season_id"]').on('change', function () {
            var season_id = $(this).val();
            if (season_id) {
                $.ajax({
                    url: "{{ URL::to('terms/season/') }}/" + season_id,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('select[name="term_id"]').empty();
                        $.each(data, function (key, value) {
                            $('select[name="term_id"]').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });



</script>
