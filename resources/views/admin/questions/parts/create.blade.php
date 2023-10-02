<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('questions.store') }}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-6 mt-3">
                    <label class="form-check-label" for="degree">الدرجة</label>
                    <input class="form-control" name="degree" type="number"/>
                </div>
                <div class="col-md-6 mt-3">
                    <label class="form-check-label" for="degree">درجة الصعوبة</label>
                   <select class="form-control" name="difficulty">
                       <option value="low" class="form-control">سهل</option>
                       <option value="mid" class="form-control">متوسط</option>
                       <option value="high" class="form-control">صعب</option>
                   </select>
                </div>
                <div class="col-md-12 mt-3">
                    <label class="form-check-label" for="degree">نوع السؤال</label>
                   <select class="form-control" name="question_type">
                       <option value="text" style="text-align: center" class="form-control">مقالي</option>
                       <option value="choice" style="text-align: center" class="form-control">اختياري</option>
                   </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <label for="name_ar" class="form-control-label">السؤال</label>

                    <textarea id="questionTextarea" class="ckeditor form-control" rows="5" name="question"></textarea>
                </div>                

            </div>
            <div class="row">
                <div class="col-md-6 mt-3">
                    <label for="season" class="form-control-label">الصف</label>
                    <Select name="season_id" class="form-control seasonChoose">
                        <option selected disabled style="text-align: center">اختار الصف</option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}"
                                    style="text-align: center">{{ $season->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="term" class="form-control-label">الترم</label>
                    <Select name="term_id" class="form-control user_choose">
                        <option selected disabled style="text-align: center">اختار الصف</option>
                    </Select>
                </div>
            </div>
            <div class="row d-none choseExamp">
                <div class="col-md-12 mt-3">
                    <label for="type" class="form-control-label ">القسم</label>
                    <Select name="type" id="type" class="form-control type_choose">
                        <option selected disabled style="text-align: center">اختر قسم للسؤال</option>
                        <option value="lesson" style="text-align: center">درس</option>
                        <option value="subject_class" style="text-align: center">الوحدة</option>
                        <option value="video" style="text-align: center">الفيديو</option>
                        <option value="all_exam" style="text-align: center">امتحان شامل</option>
                        <option value="life_exam" style="text-align: center">امتحان لايف</option>
                    </Select>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6 mt-3">
                    <label for="lesson" class="form-control-label">ملاحظة</label>
                    <textarea id="mytextarea" class="ckeditor form-control" rows="8" name="note"></textarea>
                </div>

                <div id="editor"></div>
                <div class="col-md-6">

                    <label for="">الصورة :</label>
                    <input type="file" name="image" class="dropify" data-default-file="" id="image">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">أغلاق</button>
            <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
        </div>
    </form>
</div>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
     $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });
    $('.dropify').dropify();

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

    $(document).ready(function () {
        $('select[name="season_id"]').on('change', function () {
            $('.choseExamp').removeClass('d-none');
        })
    })


    $(document).ready(function () {
        $('select[name="examable_type"]').on('change', function () {
            var season = $('select[name="season_id"]').val();
            var term = $('select[name="term_id"]').val();
            var type = $(this).val();
            var typeText = $(this).find(":selected").text();
            $('.typeName').html(typeText);
            if (type) {
                $.ajax({
                    url: "{{ route('examble_type_question') }}",
                    type: "GET",
                    data: {
                        'type': type,
                        'season': season,
                        'term': term,
                    },
                    dataType: "json",
                    success: function (data) {
                        $('select[name="examable_id"]').empty();
                        $.each(data, function (key, value) {
                            $('select[name="examable_id"]').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });

// Get the textarea and image elements by their IDs
var textarea = document.getElementById("questionTextarea");
        var image = document.getElementById("image");

        textarea.addEventListener("input", function () {
            image.disabled = true;
        });
        image.addEventListener("click", function () {
            textarea.disabled = true;
        });


</script>
