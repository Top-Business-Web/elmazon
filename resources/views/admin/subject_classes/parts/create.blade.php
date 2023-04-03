<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('subjectsClasses.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الاسم بالعربية</label>
                    <input type="text" class="form-control" value="" name="name_ar">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">الاسم بالانجليزية</label>
                    <input type="text" class="form-control" value="" name="name_en">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الصف</label>
                    <Select name="season_id" class="form-control">
                        <option selected disabled style="text-align: center">اختار الصف</option>
                        @foreach ($seasons as $season)
                            <option value="{{ $season->id }}" style="text-align: center">{{ $season->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الترم</label>
                    <Select name="term_id" class="form-control">
                        <option selected disabled style="text-align: center">اختار الترم</option>
                        @foreach ($terms as $term)
                            <option value="{{ $term->id }}" style="text-align: center">
                                {{ $term->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="">الصورة :</label>
                    <input type="file" name="image" class="dropify"
                           data-default-file=""/>

                    <span class="form-text text-danger text-center"> Recomended : 2048 X 1200 to up Px <br> Extension :
                        png, gif, jpeg,
                        jpg,webp</span>

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
    $('.dropify').dropify()
    $(".season_choose").click(function () {
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

