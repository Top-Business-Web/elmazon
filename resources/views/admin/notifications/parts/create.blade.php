<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('notifications.store') }}">
        @csrf
            <div class="row">
                <div class="col-md-12">

                    <div class="mt-3">
                        <label for="type" class="form-control-label">تريد ارسال هذا الاشعار لمن*</label>
                        <select name="type" class="form-control select2">
                            <option value="users">كل طلبه هذا الصف</option>
                            <option value="student">طالب معين</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label for="user_id" class="form-control-label">اختر طالب معين*</label>
                        <select name="user_id" class="form-control select2">
                            @foreach($users as $user)
                            <option  value="{{$user->id}}">{{$user->code}}</option>
                            @endforeach

                        </select>
                    </div>



                    <div class="titleDiv mt-3">
                        <label for="title" class="form-control-label">عنوان الرساله</label>
                        <input type="text" class="form-control" name="title">
                    </div>

                    <div class="mt-3">
                        <label for="body" class="form-control-label">الرسالة</label>
                        <textarea class="form-control" name="body" rows="10"></textarea>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <label for="season_id" class="form-control-label">الصف الدراسي</label>
                    <Select name="season_id" class="form-control select2">
                        <option selected>الكل</option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}">{{ $season->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>

                <div class="col-md-12 mt-3">
                    <label for="term_id" class="form-control-label">اختر التيرم</label>
                    <select name="term_id" class="form-control select2">

                    </select>
                </div>

            </div>

        <div class="row">
            <div class="col-md-12 mt-3">
                <label for="phone" class="form-control-label">ارفاق صوره او ملف مع الاشعار*</label>
                <input type="file" class="form-control dropify" min="11" name="image">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
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


<script>
    $('.dropify').dropify();

    $('.type').on('change', function(){
        // alert($(this).val());
        if($(this).val() == 'student'){
            $('.userSelect').removeClass('d-none')
        } else {
            $('.userSelect').addClass('d-none')
        }
    })

    {{--$('.student_code').keyup(function(){--}}
    {{--    var code =  $(this).val();--}}
    {{--    if (code) {--}}
    {{--        $.ajax({--}}
    {{--            url: "{{ route('searchUser') }}",--}}
    {{--            type: "GET",--}}
    {{--            data: {--}}
    {{--                code: code--}}
    {{--            },--}}
    {{--            success: function (data) {--}}
    {{--                $('#status_code').text(data);--}}
    {{--            },--}}
    {{--        });--}}
    {{--    } else {--}}
    {{--        console.log('Code is empty');--}}
    {{--    }--}}
    {{--});--}}



</script>

