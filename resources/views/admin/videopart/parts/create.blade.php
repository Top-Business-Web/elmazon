<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('videosParts.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="hidden" name="ordered" value="" />
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="name_ar" class="form-control-label">الاسم باللغة العربية</label>
                    <input type="text" class="form-control" name="name_ar">
                </div>
                <div class="col-md-12 mt-3">
                    <label for="name_en" class="form-control-label">الاسم باللغة الانجليزية</label>
                    <input type="text" class="form-control" name="name_en">
                </div>

                <div class="col-md-12 mt-3"><label class="labels">صوره خلفيه الفيديو</label>
                    <input type="file" class="form-control" name="background_image">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="lesson_id" class="form-control-label">درس</label>
                    <Select name="lesson_id" class="form-control user_choose">
                        <option selected disabled style="text-align: center">اختار درس</option>
{{--                        <option value="" style="text-align: center">فيديوهات عامة</option>--}}
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}"
                                    style="text-align: center">{{ $lesson->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="head">شهر</label>
                    <select name="month" class="form-control" id="signup_birth_month" >
                        <option value="" style="text-align: center">اختر شهر</option>
                        <?php for ($i = 1; $i <= 12; $i++){
                            echo '<option style="text-align: center" value="' . $i . '">' . date( 'F', strtotime( "$i/12/10" ) ) . '</option>';
                        }?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">


                <div class="col-md-12 video_link">
                    <label for="video_link" class="form-control-label">ارفاق ملف *</label>
                    <input type="file" name="link" class="form-control"
                           data-default-file=""/>
                </div>

                <div class="col-md-12 video_link mt-3">
                    <label for="video_link" class="form-control-label">مسار فيديو مثال (Youtube)*</label>
                    <input type="text" name="youtube_link" class="form-control"/>
                </div>

                <div class="col-md-12 video_date mt-3">
                    <label for="video_date" class="form-control-label">وقت الفيديو</label>
                    <input type="text" id="date_video" class="form-control" name="video_time">
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
            <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
        </div>
    </form>
</div>
<script>



    $(document).ready(function() {
        $('#type').on('change', function() {
            var element = document.getElementById("type");
            var value = $(element).find('option:selected').val();
            if(value !='video'){
                $('.video_date').prop('hidden', true);
            }
            else{
                $('.video_date').prop('hidden', false);
            }
        })
    })

</script>
<!-- fix -->

