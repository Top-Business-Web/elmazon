<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('questions.update', $question->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $question->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">السؤال</label>
                    <textarea class="form-control" rows="3" name="question">{{ $question->question }}</textarea>
                </div>
                <div class="col-md-6">
                    <label for="season" class="form-control-label">الصف</label>
                    <Select name="season_id" class="form-control user_choose">
                        <option selected disabled style="text-align: center">اختار صف</option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}"
                                    {{ $question->season_id == $season->id ? 'selected' : '' }}
                                    style="text-align: center">{{ $season->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="term" class="form-control-label">الترم</label>
                    <Select name="term_id" class="form-control user_choose">
                        <option selected disabled style="text-align: center">اختار ترم</option>
                        @foreach($terms as $term)
                            <option value="{{ $term->id }}"
                                    {{ $question->term_id == $term->id? 'selected' : '' }}
                                    style="text-align: center">{{ $term->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="type" class="form-control-label">النوع</label>
                    <Select name="examable_type" id="type" class="form-control type_choose">
                        <option disabled style="text-align: center">اختار النوع</option>
                        <option value="App\Models\Lesson"
                                {{ $question->examable_type == 'App\Models\Lesson' ? 'selected' : '' }} style="text-align: center">
                            درس
                        </option>
                        <option value="App\Models\Season"
                                {{ $question->examable_type == 'App\Models\Season' ? 'selected' : '' }} style="text-align: center">
                            فصل
                        </option>
                        <option value="App\Models\VideoParts"
                                {{ $question->examable_type == 'App\Models\VideoParts' ? 'selected' : '' }} style="text-align: center">
                            الفيديو
                        </option>
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="lesson" class="form-control-label">الدرس</label>
                    <Select name="examable_id" class="form-control type_ajax_choose">
                        @if($question->examable_type == 'App\Models\Lesson')
                            @foreach(\Illuminate\Support\Facades\DB::table('lessons')->get() as $lesson)
                                <option selected style="text-align: center"
                                        {{ $question->examable_id  == $lesson->id ? 'selected' : '' }} value="{{ $lesson->id }}">{{ $lesson->name_ar }}</option>
                            @endforeach
                        @endif
                        @if($question->examable_type == 'App\Models\Season')
                            @foreach(\Illuminate\Support\Facades\DB::table('seasons')->get() as $season)
                                <option selected style="text-align: center"
                                        {{ $question->examable_id  == $season->id ? 'selected' : '' }} value="{{ $season->id }}">{{ $season->name_ar }}</option>
                            @endforeach
                        @endif
                        @if($question->examable_type == 'App\Models\VideoParts')
                            @foreach(\Illuminate\Support\Facades\DB::table('video_parts')->get() as $videoparts)
                                <option selected style="text-align: center"
                                        {{ $question->examable_id  == $videoparts->id ? 'selected' : '' }} value="{{ $videoparts->id }}">{{ $videoparts->name_ar }}</option>
                            @endforeach
                        @endif
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="lesson" class="form-control-label">ملاحظة</label>
                    <textarea class="form-control" rows="10" name="note">{{ $question->note }}</textarea>
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

    $(".type_choose").change(function () {
        var element = document.getElementById("type");
        var value = $(element).find("option:selected").val();

        $.ajax({
            url: '{{ route('examble_type') }}',
            data: {id: value},
            success: function (data) {
                $('.type_ajax_choose').html(data);
            }
        })
    })

</script>
