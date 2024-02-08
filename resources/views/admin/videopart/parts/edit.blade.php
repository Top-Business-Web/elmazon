<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('videosParts.update', $videosPart->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $videosPart->id }}" name="id">

        <div class="form-group">
            <input type="hidden" name="ordered" value=""/>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="name_ar" class="form-control-label">الاسم باللغة العربية</label>
                    <input type="text" class="form-control" name="name_ar" value="{{$videosPart->name_ar}}">
                </div>
                <div class="col-md-12 mt-3">
                    <label for="name_en" class="form-control-label">الاسم باللغة الانجليزية</label>
                    <input type="text" class="form-control" name="name_en" value="{{$videosPart->name_en}}">
                </div>

                <div class="col-md-12 mt-3"><label class="labels">صوره خلفيه الفيديو</label>
                    <input type="file" class="form-control" name="background_image">
                </div>
            </div>


            <div class="row">
                <div class="col-md-6 mt-3">
                    <label for="name_ar" class="form-control-label">الصف الدراسي</label>
                    <Select name="season_id" id="season_id" class="form-control select2">

                        @foreach ($seasons as $season)
                            <option value="{{ $season->id }}" {{$videosPart->season_id == $season->id ? 'selected' : ''}}>{{ $season->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>


                <div class="col-md-6 mt-3">
                    <label for="name_ar" class="form-control-label">اختر تيرم</label>
                    <Select name="term_id" id="term_id" class="form-control select2">
                        @foreach($terms as $term)
                            <option value="{{$term->id}}" {{$videosPart->term_id == $term->id ? 'selected' : ''}}>{{$term->name_ar}}</option>
                        @endforeach

                    </Select>
                </div>


                <div class="col-md-6 mt-3">
                    <label for="name_ar" class="form-control-label">اختر فصل معين</label>
                    <select name="subject_class_id" id="subject_class_id" class="form-control select2">
                        <option disabled>اختر فصل معين</option>
                        <option selected>{{$lesson->subject_class->name_ar}}</option>

                    </select>
                </div>

                <div class="col-md-6 mt-3">
                    <label for="name_ar" class="form-control-label">اختر درس معين</label>
                    <select name="lesson_id" id="lesson_id" class="form-control select2">
                        <option disabled>اختر درس معين</option>
                        <option value="{{$lesson->id}}" selected>{{$lesson->name_ar}}</option>

                    </select>
                </div>


            </div>

            <div class="row mb-3">


                <div class="col-md-12 mt-3">
                    <label for="head">شهر</label>
                    <select name="month" class="form-control" id="signup_birth_month">
                        <option value="">اختر شهر</option>
                        @for ($i = 1; $i <= 12; $i++)
                            {
                            <option value="{{$i}}" {{$videosPart->month == $i ? 'selected' : ''}}> {{date( 'F', strtotime( "$i/12/10" ) )}}</option>
                        @endfor
                    </select>
                </div>
            </div>

            @php
                $isInternalUrl = \Illuminate\Support\Str::startsWith($videosPart->link, url('/'));
            @endphp

            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="video_link" class="form-control-label">نوع ارفاق الملف</label>
                    <select class="form-control" name="link_type" id="uploadFileType" required>
                        <option class="form-control" value="" disabled selected>اختر النوع</option>
                        <option class="form-control"  value="linkUp" {{ (!$isInternalUrl && $videosPart->youtube_link == null ) ? 'selected' : '' }} >من الكمبيوتر</option>
                        <option class="form-control" {{ $isInternalUrl ? 'selected' : '' }} value="linkUrl">لينك من السيرفر</option>
                        <option class="form-control" {{  $videosPart->youtube_link ? 'selected' : '' }} value="youtube_link">لينك من اليوتيوب</option>
                    </select>
                </div>

                <div class="col-md-12 video_link d-none linkUp">
                    <label for="video_link" class="form-control-label">ارفاق ملف *</label>
                    <input type="file" name="link" class="form-control"
                           data-default-file=""/>
                </div>

                <div class="col-md-12 video_link_server d-none linkUrl">
                    <label for="video_link" class="form-control-label">مسار فيديو من سيرفر المأذون *</label>
                    <input type="url" name="link_server" class="form-control"
                           value="{{ $videosPart->link }}"
                           data-default-file="" placeholder="EX : {{ url('/') }}"/>
                    <small class="text-danger">قم بعمل copy للمسار من مدير الملفات *</small>
                </div>

                <div class="col-md-12 video_link mt-3 d-none linkYouTube">
                    <label for="video_link" class="form-control-label">مسار فيديو مثال (Youtube)*</label>
                    <input type="text" name="youtube_link" class="form-control" value="{{$videosPart->youtube_link}}"/>
                </div>

                <div class="col-md-12 video_date mt-3 ">
                    <label for="video_date" class="form-control-label">وقت الفيديو</label>
                    <input type="text" id="date_video" class="form-control" name="video_time"
                           value="{{$videosPart->video_time}}">
                </div>
            </div>
            <div class="row">

                <div class="col-md-12 mt-3">
                    <label for="name_en" class="form-control-label">ملاحظة</label>
                    <textarea class="form-control" name="note" rows="10"></textarea>
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

{{--eldpaour 8-2-2024--}}
<script>
    $(document).ready(function () {
        let linkUp = $('.linkUp');
        let linkUrl = $('.linkUrl');
        let linkYouTube = $('.linkYouTube');
        $('select[name="link_type"]').on('change', function () {
            let selected = $(this).val();
            if (selected === 'linkUp') {
                linkUp.removeClass('d-none').find('input').prop('disabled', false);
                linkUrl.addClass('d-none').find('input').prop('disabled', true);
                linkYouTube.addClass('d-none').find('input').prop('disabled', true);
            }
            if (selected === 'linkUrl') {
                linkUrl.removeClass('d-none').find('input').prop('disabled', false);
                linkUp.addClass('d-none').find('input').prop('disabled', true);
                linkYouTube.addClass('d-none').find('input').prop('disabled', true);
            }
            if (selected === 'youtube_link') {
                linkYouTube.removeClass('d-none').find('input').prop('disabled', false);
                linkUp.addClass('d-none').find('input').prop('disabled', true);
                linkUrl.addClass('d-none').find('input').prop('disabled', true);
            }
        });
    });

    $(document).ready(function () {
        let linkUp = $('.linkUp');
        let linkUrl = $('.linkUrl');
        let linkYouTube = $('.linkYouTube');

        // Initially hide all link sections and disable their input fields
        linkUp.addClass('d-none').find('input').prop('disabled', true);
        linkUrl.addClass('d-none').find('input').prop('disabled', true);
        linkYouTube.addClass('d-none').find('input').prop('disabled', true);

        // Show the appropriate link section based on the initial value of the select element
        let selected = $('select[name="link_type"]').val();
        if (selected === 'linkUp') {
            linkUp.removeClass('d-none').find('input').prop('disabled', false);
        } else if (selected === 'linkUrl') {
            linkUrl.removeClass('d-none').find('input').prop('disabled', false);
        } else if (selected === 'youtube_link') {
            linkYouTube.removeClass('d-none').find('input').prop('disabled', false);
        }

        // Event listener for select element change
        $('select[name="link_type"]').on('change', function () {
            let selected = $(this).val();
            // Hide all link sections and disable their input fields
            linkUp.addClass('d-none').find('input').prop('disabled', true);
            linkUrl.addClass('d-none').find('input').prop('disabled', true);
            linkYouTube.addClass('d-none').find('input').prop('disabled', true);

            // Show the appropriate link section and enable its input fields based on the selected value
            if (selected === 'linkUp') {
                linkUp.removeClass('d-none').find('input').prop('disabled', false);
            } else if (selected === 'linkUrl') {
                linkUrl.removeClass('d-none').find('input').prop('disabled', false);
            } else if (selected === 'youtube_link') {
                linkYouTube.removeClass('d-none').find('input').prop('disabled', false);
            }
        });
    });


</script>
{{--eldpaour 8-2-2024--}}
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


    $(document).ready(function () {
        $('select[name="term_id"]').on('click', function () {

            let season_id = $("#season_id").val();
            let term_id = $("#term_id").val();

            if (term_id) {
                $.ajax({
                    url: "{{ URL::to('getAllSubjectClassesBySeasonAndTerm') }}",
                    type: "GET",
                    data: {
                        "season_id": season_id,
                        "term_id": term_id,
                    },
                    dataType: "json",
                    success: function (data) {
                        $('select[name="subject_class_id"]').empty();
                        $.each(data, function (key, value) {
                            $('select[name="subject_class_id"]').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });


    $(document).ready(function () {
        $('select[name="subject_class_id"]').on('click', function () {

            let subject_class_id = $("#subject_class_id").val();

            if (subject_class_id) {
                $.ajax({
                    url: "{{ URL::to('getAllLessonsBySubjectClass') }}",
                    type: "GET",
                    data: {
                        "subject_class_id" : subject_class_id,
                    },
                    dataType: "json",
                    success: function (data) {
                        $('select[name="lesson_id"]').empty();
                        $.each(data, function (key, value) {
                            $('select[name="lesson_id"]').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });

</script>
<!-- fix -->
