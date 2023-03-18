<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('contactUs.store') }}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الاسم</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">موضوع</label>
                    <input type="text" class="form-control" name="subject">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="note" class="form-control-label">رسالة</label>
                    <textarea class="form-control" name="message" rows="10"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
        </div>
    </form>
</div>

