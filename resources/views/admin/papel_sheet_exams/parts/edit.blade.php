<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('papelSheetExam.update', $papelSheetExam->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $papelSheetExam->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12 mt-3">
                    <label for="degree" class="form-control-label">درجه الامتحان الورقي</label>
                    <input type="number" class="form-control" name="degree" min="0" value="{{ $papelSheetExam->degree }}">
                    </Select>
                </div>
                <div class="col-md-12 mt-3">
                    <label for="date_exam" class="form-control-label">موعد الامتحان</label>
                    <input type="date" class="form-control" name="date_exam" value="{{ $papelSheetExam->date_exam }}">
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <label for="name_ar" class="form-control-label">اسم الامتحان باللغه العربيه</label>
                    <input type="text" class="form-control" name="name_ar" value="{{ $papelSheetExam->name_ar }}">
                </div>
                <div class="col-md-12 mt-3">
                    <label for="name_en" class="form-control-label">اسم الامتحان باللغه الانجليزيه</label>
                    <input type="text" class="form-control" value="{{ $papelSheetExam->name_en }}" name="name_en">
                </div>
            </div>


            <div class="row">
                <div class="col-md-12 mt-3">
                    <label for="name_ar" class="form-control-label">الصف الدراسي</label>
                    <Select name="season_id" class="form-control">
                        @foreach ($seasons as $season)
                            <option value="{{ $season->id }}" {{ $papelSheetExam->seanon_id == $season->id ? 'selected' : ''}}>{{ $season->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-12 mt-3">
                    <label for="name_ar" class="form-control-label">اختر التيرم التابع للصف الدراسي</label>
                    <Select name="term_id" class="form-control">
                        <option selected disabled style="text-align: center">اختار الترم</option>
                        @foreach ($terms as $term)
                            <option value="{{ $term->id }}" {{ $papelSheetExam->term_id == $term->id ?  'selected' : ''}}>{{ $term->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>



            <div class="row">
                <div class="col-md-12 mt-3">
                    <label for="name_en" class="form-control-label">بدايه تاريخ التسجيل</label>
                    <input type="date" class="form-control" value="{{ $papelSheetExam->from }}" name="from">
                </div>
                <div class="col-md-12 mt-3">
                    <label for="name_en" class="form-control-label">نهايه تاريخ التسجيل بالامتحان الورقي</label>
                    <input type="date" class="form-control" value="{{ $papelSheetExam->to }}" name="to">
                    </Select>
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

