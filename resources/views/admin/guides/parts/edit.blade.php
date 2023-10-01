<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('guide.update', $guide->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $guide->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="section_name_ar" class="form-control-label">العنوان بالعربية</label>
                    <input type="text" class="form-control" value="{{ $guide->title_ar }}" name="title_ar">
                </div>
                <div class="col-md-6">
                    <label for="section_name_en" class="form-control-label">العنوان بالانجليزية</label>
                    <input type="text" class="form-control" value="{{ $guide->title_en }}" name="title_en">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الصف</label>
                    <Select name="season_id" id="season_id" class="form-control season_id">
                        <option selected disabled style="text-align: center">اختار الصف</option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}" {{ $guide->season_id == $season->id ? 'selected' : '' }}
                                    style="text-align: center">{{ $season->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="">الترم</label>
                    <select name="term_id" id="term_id" class="form-control term_id">
                        <option value="{{ $guide->term_id }}" style="text-align: center" >{{ $guide->term->name_ar }}</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="head">لون الخلفية</label>
                    <input type="color" class="form-control" name="background_color"
                           value="{{ $guide->background_color }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="section_name_ar" class="form-control-label">الوصف بالعربية</label>
                    <textarea class="form-control" name="description_ar" rows="8"
                              >{{ $guide->description_ar }}</textarea>
                </div>
                <div class="col-md-6">
                    <label for="section_name_en" class="form-control-label">الوصف بالانجليزية</label>
                    <textarea class="form-control" name="description_en" rows="8"
                              >{{ $guide->description_en }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="section_name_ar" class="form-control-label">مرجع</label>
                    <input type="file" name="file" class="form-control" data-default-file="{{ asset($guide->file) }}"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="section_name_ar" class="form-control-label">ايقونة</label>
                    <input type="file" name="icon" class="dropify" data-default-file="{{ asset($guide->icon) }}" />
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
        $('.season_id').on('change', function () {
            let season = $(this).val();
            $.ajax({
                url: '{{ route("subjectClassSort")}}',
                method: 'GET',
                data: {
                    'id': season,
                }, success: function (data) {
                    $('.term_id').html(data);
                    console.log(data);
                }
            })
        })
    });

</script>
