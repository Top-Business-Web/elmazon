<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('onlineExam.update', $onlineExam->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $onlineExam->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-2">
                    <label for="name_ar" class="form-control-label">الدرجة</label>
                    <input type="number" class="form-control" name="degree" style="text-align: center" value="{{ $onlineExam->degree }}">
                </div>
                <div class="col-md-5">
                    <label for="date_exam" class="form-control-label">موعد الامتحان</label>
                    <input type="date" class="form-control" name="date_exam" style="text-align: center" value="{{ $onlineExam->date_exam }}">
                </div>
                <div class="col-md-3">
                    <label for="name_en" class="form-control-label"> وقت الامتحان</label>
                    <input type="number" class="form-control" value="{{ $onlineExam->quize_minute }}" name="quize_minute" style="text-align: center" placeholder="الوقت بالدقائق">
                </div>
                <div class="col-md-2">
                    <label for="name_en" class="form-control-label"> عدد المحاولات </label>
                    <input type="number" class="form-control" value="{{ $onlineExam->trying_number }}" name="trying_number" style="text-align: center" placeholder="الوقت بالدقائق">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الاسم بالعربي</label>
                    <input type="text" class="form-control" value="{{ $onlineExam->name_ar }}" name="name_ar" style="text-align: center">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">الاسم بالانجليزية</label>
                    <input type="text" class="form-control" value="{{ $onlineExam->name_en }}" name="name_en" style="text-align: center">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="note" class="form-control-label">تيرم</label>
                    <Select name="term_id" class="form-control">
                        <option selected disabled style="text-align: center">اختر تيرم</option>
                        @foreach($terms as $term)
                            <option value="{{ $term->id }}"
                                    {{ ($onlineExam->term_id == $term->id)? 'selected' : '' }}
                                    style="text-align: center">{{ $term->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-control-label">فصل</label>
                    <Select name="season_id" class="form-control">
                        <option selected disabled style="text-align: center">اختر فصل</option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}"
                                    {{ ($onlineExam->season_id == $season->id)? 'selected' : '' }}
                                    style="text-align: center">{{ $season->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="type" class="form-control-label">النوع</label>
                    <Select name="examable_type" id="type" class="form-control type_choose">
                        <option disabled style="text-align: center">اختار النوع</option>
                        <option value="App\Models\Lesson"
                                {{ $onlineExam->examable_type == 'App\Models\Lesson' ? 'selected' : '' }} style="text-align: center">
                            درس
                        </option>
                        <option value="App\Models\Season"
                                {{ $onlineExam->examable_type == 'App\Models\Season' ? 'selected' : '' }} style="text-align: center">
                            فصل
                        </option>
                        <option value="App\Models\VideoParts"
                                {{ $onlineExam->examable_type == 'App\Models\VideoParts' ? 'selected' : '' }} style="text-align: center">
                            الفيديو
                        </option>
                    </Select>
                </div>
                <div class="col-md-12">
                    <label for="lesson" class="form-control-label">الدرس</label>
                    <Select name="examable_id" class="form-control type_ajax_choose">
                        @if($onlineExam->examable_type == 'App\Models\Lesson')
                            @foreach(\Illuminate\Support\Facades\DB::table('lessons')->get() as $lesson)
                                <option selected style="text-align: center"
                                        {{ $onlineExam->examable_id  == $lesson->id ? 'selected' : '' }} value="{{ $lesson->id }}">{{ $lesson->name_ar }}</option>
                            @endforeach
                        @endif
                        @if($onlineExam->examable_type == 'App\Models\Season')
                            @foreach(\Illuminate\Support\Facades\DB::table('seasons')->get() as $season)
                                <option selected style="text-align: center"
                                        {{ $onlineExam->examable_id  == $season->id ? 'selected' : '' }} value="{{ $season->id }}">{{ $season->name_ar }}</option>
                            @endforeach
                        @endif
                        @if($onlineExam->examable_type == 'App\Models\VideoParts')
                            @foreach(\Illuminate\Support\Facades\DB::table('video_parts')->get() as $videoparts)
                                <option selected style="text-align: center"
                                        {{ $onlineExam->examable_id  == $videoparts->id ? 'selected' : '' }} value="{{ $videoparts->id }}">{{ $videoparts->name_ar }}</option>
                            @endforeach
                        @endif
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="note" class="form-control-label">ملاحظة</label>
                    <textarea class="form-control" rows="10" name="note">{{ $onlineExam->note }}</textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin.close') }}</button>
            <button type="submit" class="btn btn-success" id="updateButton">{{ trans('admin.update') }}</button>
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
