<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('notifications.store') }}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">العنوان</label>
                    <input type="text" class="form-control" name="title">
                </div>
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">طالب</label>
                    <Select name="user_id" class="form-control">
                        <option selected disabled style="text-align: center">اختار طالب</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                    style="text-align: center">{{ $user->name }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="name_en" class="form-control-label">الرسالة</label>
                    <textarea class="form-control" name="body" rows="10"></textarea>
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
    $('.dropify').dropify();
</script>

