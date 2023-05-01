<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('questions.update', $question->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $question->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-check-label" for="degree">الدرجة</label>
                    <input class="form-control" name="degree" type="number" required="required" value="{{ $question->degree }}"/>
                </div>
                <div class="col-md-6">
                    <label class="form-check-label" for="degree">درجة الصعوبة</label>
                    <select class="form-control" name="difficulty" required="required">
                        <option value="low" class="form-control" {{ $question->difficulty == 'low' ? 'selected' : '' }}>سهل</option>
                        <option value="mid" class="form-control" {{ $question->difficulty == 'mid' ? 'selected' : '' }}>متوسط</option>
                        <option value="high" class="form-control" {{ $question->difficulty == 'high' ? 'selected' : '' }}>صعب</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="name_ar" class="form-control-label">السؤال</label>
                    <textarea class="form-control" rows="5" name="question">{{ $question->question }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="season" class="form-control-label">الصف</label>
                    <Select name="season_id" class="form-control seasonChoose"
                            required="required">
                        <option disabled style="text-align: center">اختار الصف</option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}"
                                    {{ $question->season_id == $season->id ? 'selected' : '' }}
                                    style="text-align: center">{{ $season->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="term" class="form-control-label">الترم</label>
                    <Select name="term_id" class="form-control user_choose"
                            required="required">
                        <option selected value="{{ $question->term_id }}" style="text-align: center">{{ $question->term->name_ar }}</option>
                    </Select>
                </div>
            </div>
            <div class="row d-none choseExamp">
                <div class="col-md-6 ">
                    <label for="type" class="form-control-label ">النوع</label>
                    <Select name="examable_type" id="type" class="form-control type_choose"
                            required="required">
                        <option disabled style="text-align: center">اختار النوع</option>
                        <option value="App\Models\Lesson"
                                {{ $question->examable_type == 'App\Models\Lesson' ? 'selected' : '' }}
                                style="text-align: center">درس</option>
                        <option value="App\Models\SubjectClass"
                                {{ $question->examable_type == 'App\Models\SubjectClass' ? 'selected' : '' }}
                                style="text-align: center">الوحدة</option>
                        <option value="App\Models\VideoParts"
                                {{ $question->examable_type == 'App\Models\VideoParts' ? 'selected' : '' }}
                                style="text-align: center">الفيديو</option>
                        <option value="App\Models\AllExam"
                                {{ $question->examable_type == 'App\Models\AllExam' ? 'selected' : '' }}
                                style="text-align: center">امتحان شامل</option>
                        <option value="App\Models\LifeExam"
                                {{ $question->examable_type == 'App\Models\LifeExam' ? 'selected' : '' }}
                                style="text-align: center">امتحان لايف</option>
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="lesson" class="form-control-label typeName">الدرس</label>
                    <Select name="examable_id" class="form-control type_ajax_choose" required="required">
                        <option value="{{ $question->examable_id }}">{{ $question->examable_id }}</option>
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="lesson" class="form-control-label">ملاحظة</label>
                    <textarea class="form-control" rows="8" name="note">{{ $question->note }}</textarea>
                </div>
                <div class="col-md-6">
                    <label for="">الصورة :</label>
                    <input type="file" name="image" class="dropify"
                           value="{{ $question->image }}"
                           data-default-file="{{ $question->image }}"/>
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

</script>
