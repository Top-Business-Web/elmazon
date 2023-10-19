<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('papelSheetExam.store') }}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-12 mt-3">
                    <label for="degree" class="form-control-label">درجه الامتحان الورقي</label>
                    <input type="number" class="form-control" name="degree" min="0">
                    </Select>
                </div>
                <div class="col-md-12 mt-3">
                    <label for="date_exam" class="form-control-label">موعد الامتحان</label>
                    <input type="date" class="form-control" name="date_exam">
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <label for="name_ar" class="form-control-label">اسم الامتحان باللغه العربيه</label>
                    <input type="text" class="form-control" name="name_ar">
                </div>
                <div class="col-md-12 mt-3">
                    <label for="name_en" class="form-control-label">اسم الامتحان باللغه الانجليزيه</label>
                    <input type="text" class="form-control" name="name_en">
                </div>
            </div>


            <div class="row">
                <div class="col-md-12 mt-3">
                    <label for="name_ar" class="form-control-label">الصف الدراسي</label>
                    <Select name="season_id" class="form-control">
                        <option selected disabled style="text-align: center">اختار الصف</option>
                        @foreach ($seasons as $season)
                            <option value="{{ $season->id }}" style="text-align: center">{{ $season->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-12 mt-3">
                    <label for="name_ar" class="form-control-label">اختر التيرم التابع للصف الدراسي</label>
                    <Select name="term_id" class="form-control">
                        <option selected disabled style="text-align: center">اختار الترم</option>
                        @foreach ($terms as $term)
                            <option value="{{ $term->id }}" style="text-align: center">{{ $term->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12 mt-3">
                    <label for="name_en" class="form-control-label">بدايه تاريخ التسجيل</label>
                    <input type="date" class="form-control" name="from">
                </div>
                <div class="col-md-12 mt-3">
                    <label for="name_en" class="form-control-label">نهايه تاريخ التسجيل بالامتحان الورقي</label>
                    <input type="date" class="form-control" name="to">
                    </Select>
                </div>

            </div>



{{--            <div class="row col-md-12 mt-3" id="input-container">--}}
{{--                <input type="text" class="col-md-4 form-control input-field" placeholder="موعد البدايه">--}}
{{--                <input type="text" class="col-md-4 form-control input-field" placeholder="موعد النهايه">--}}
{{--                <button class="col-md-4 btn btn-primary add-button">اضافه موعد جديد</button>--}}
{{--            </div>--}}


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
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


{{--<script>--}}
{{--    $(document).ready(function() {--}}
{{--        // Add Input--}}
{{--        $(".add-button").click(function() {--}}
{{--            $("#input-container").append('<input type="text" class="col-md-8 form-control input-field mt-3"> <button class="col-md-4 btn btn-danger delete-button mt-3">حذف الموعد</button>');--}}
{{--        });--}}

{{--        // Delete Input--}}
{{--        $("#input-container").on("click", ".delete-button", function() {--}}
{{--            $(this).prev(".input-field").remove();--}}
{{--            $(this).remove();--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
