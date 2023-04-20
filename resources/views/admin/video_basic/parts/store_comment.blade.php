<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('storeReply') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الاسم باللغة العربية</label>
                    <input type="text" class="form-control" name="name_ar">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">الاسم باللغة الانجليزية</label>
                    <input type="text" class="form-control" name="name_en">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="head">لون الخلفية</label>
                    <input type="color" class="form-control" name="background_color"
                           value="">
                </div>
                <div class="col-md-6">
                    <label for="time" class="form-control-label">المدة</label>
                    <input type="number" class="form-control" name="time">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="">لينك الفيديو :</label>
                    <input type="file" name="video_link" class="dropify"
                           data-default-file=""/>
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
</script>
<!-- fix -->

