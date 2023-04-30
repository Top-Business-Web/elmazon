<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('allExam.update', $allExam->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $allExam->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label for="exam_type" class="form-control-label">نوع الامتحان</label>
                    <select class="form-control" name="exam_type" id="exam_type"
                        @selected(old('exam_type',$allExam->exam_type))>
                        <option value="" disabled>اختر النوع</option>
                        <option value="all_exam" class="form-control">أونلاين</option>
                        <option value="pdf" class="form-control">Pdf</option>
                    </select>
                </div>
            </div>
            <div class="row d-none pdfType">
                <div class="col-md-6">
                    <label class="form-control-label" for="pdf_file_upload">رفع الملف (pdf)</label>
                    <input type="file" class="form-control" value="{{ $allExam->pdf_file_upload }}"
                           name="pdf_file_upload">
                </div>
                <div class="col-md-6">
                    <label class="form-control-label" for="pdf_num_questions">عدد الاسئلة</label>
                    <input type="number" class="form-control" value="{{ $allExam->pdf_num_questions }}"
                           name="pdf_num_questions">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-control-label" for="answer_pdf_file">رفع الاجابة pdf</label>
                    <input type="file" class="form-control" name="answer_pdf_file"
                           value="{{ $allExam->answer_pdf_file }}">
                </div>
                <div class="col-md-6">
                    <label class="form-control-label" for="answer_video_file">رفع الاجابة video</label>
                    <input type="file" class="form-control" name="answer_video_file"
                           value="{{  $allExam->answer_video_file }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label class="form-control-label" for="date_exam">موعد الامتحان</label>
                    <input type="date" class="form-control" name="date_exam" value="{{ $allExam->date_exam }}"
                           required="required">
                </div>
                <div class="col-md-3">
                    <label class="form-control-label" for="quize_minute">وقت الامتحان بالدقائق</label>
                    <input type="number" class="form-control" name="quize_minute" value="{{ $allExam->quize_minute }}"
                           required="required">
                </div>
                <div class="col-md-3">
                    <label class="form-control-label" for="trying_number">عدد المحاولات</label>
                    <input type="number" class="form-control" name="trying_number" value="{{ $allExam->trying_number }}"
                           required="required">
                </div>
                <div class="col-md-3">
                    <label class="form-control-label" for="degree">درجة الامتحان</label>
                    <input type="number" class="form-control" name="degree" value="{{ $allExam->degree }}"
                           required="required">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الاسم بالعربية</label>
                    <input type="text" class="form-control" name="name_ar" required="required"
                           value="{{ $allExam->name_ar }}">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">الاسم بالانجليزية</label>
                    <input type="text" class="form-control" name="name_en" required="required"
                           value="{{ $allExam->name_en }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="note" class="form-control-label">الصف</label>
                    <Select name="season_id" required="required"
                            class="form-control" @selected(old('season_id',$allExam->season_id))>
                        <option disabled style="text-align: center">اختر الصف</option>
                        @foreach($data['seasons'] as $season)
                            <option value="{{ $season->id }}"
                                    style="text-align: center">{{ $season->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-control-label">ترم</label>
                    <Select name="term_id" required="required"
                            class="form-control">
                        <option disabled style="text-align: center">اختر ترم</option>
                        <option class="form-control"
                                value="{{ $allExam->term_id }}">{{ $allExam->term->name_ar }}</option>
                    </Select>
                </div>
                <div class="col-md-6">
                                        <label for="note" class="form-control-label">لون الخلفية</label>
                    {{--                    <input type="color" class="form-control" value="{{ $allExam->background_color }}" name="background_color" required>--}}
                    <select name="background_color" id="colorSelect" class="form-control">
                        <option value="#FE7C04">#FE7C04</option>
                        <option value="#143A7B">#143A7B</option>
                        <option value="#854AA4">#854AA4</option>
                    </select>

                </div>
                <div class="col-md-6">
                    <span class="btn btn-sm mt-4 colorInput" style="width: 100%">Preview</span>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-9">
                    <label class="control-label">التعليمات بالعربية</label>
                    <div class="form-group itemItems1">
                        @foreach($allExam->instruction_ar as $val1)
                            <input type="text" name="instruction_ar[]" class="form-control mt-3 InputItemExtra1"
                                   value="{{ $val1 }}">
                        @endforeach
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="button" class=" mt-5 btn btn-primary MoreItem1">المزيد</button>
                    <button type="button" class=" mt-5 btn btn-danger delItem1">حذف</button>
                </div>
                <span class="badge Issue1 badge-danger"></span>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <label class="control-label">التعليمات بالانجليزية</label>
                    <div class="form-group itemItems2">
                        @foreach($allExam->instruction_en as $val2)
                            <input type="text" name="instruction_en[]" class="form-control mt-3 InputItemExtra2"
                                   value="{{ $val2 }}">
                        @endforeach
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="button" class=" mt-5 btn btn-primary MoreItem2">المزيد</button>
                    <button type="button" class=" mt-5 btn btn-danger delItem2">حذف</button>
                </div>
                <span class="badge Issue2 badge-danger"></span>
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

    $("#exam_type").on('change', function () {
        let opt = $(this).find('option:selected').val();
        if (opt === 'pdf') {
            $('.pdfType').removeClass('d-none').prop('disabled', 'false');
        } else {
            $('.pdfType').addClass('d-none').prop('disabled', 'ture');
        }
    })

</script>

<script>
    $(document).on('click', '.delItem1', function () {
        var Item = $('.InputItemExtra1').last();
        let issue = $('.Issue1');
        if (Item.val() === '' && $('.InputItemExtra1').length > 1) {
            Item.fadeOut();
            Item.remove();
            issue.addClass('badge-success');
            issue.text('The element deleted');
            setTimeout(function () {
                $('.Issue1').html('');
            }, 3000)
        } else {
            console.log('error')
        }
    })

    $(document).on('click', '.MoreItem1', function () {
        var Item = $('.InputItemExtra1').last();
        if (Item.val() !== '') {
            $('.itemItems1').append('<input type="text" name="instruction_ar[]" class="form-control InputItemExtra1 mt-3">')
        }
    })

    $(document).on('click', '.delItem2', function () {
        var Item = $('.InputItemExtra2').last();
        let issue = $('.Issue2');
        if (Item.val() === '' && $('.InputItemExtra2').length > 1) {
            Item.fadeOut();
            Item.remove();
            issue.addClass('badge-success');
            issue.text('The element deleted');
            setTimeout(function () {
                $('.Issue2').html('');
            }, 3000)
        } else {
            console.log('error')
        }
    })

    $(document).on('click', '.MoreItem2', function () {
        var Item = $('.InputItemExtra2').last();
        if (Item.val() !== '') {
            $('.itemItems2').append('<input type="text" name="instruction_en[]" class="form-control InputItemExtra2 mt-3">')
        }
    })
    $(document).ready(function () {
        $('.colorInput').addClass('d-none');

        const colorSelect = document.querySelector('#colorSelect');
        colorSelect.addEventListener('click', () => {
            $('.colorInput').removeClass('d-none');
            $('.colorInput').css('background-color', colorSelect.value);
        });
    })

</script>
