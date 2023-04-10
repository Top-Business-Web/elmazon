<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('notifications.store') }}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                        <label for="name_ar" class="form-control-label">لمن الرسالة</label>
                    <Select name="user_id" class="form-control notificationType">
                        <option style="text-align: center" value="all">كل الطلاب</option>
                        <option style="text-align: center" value="user">اختر طالب</option>
                    </Select>
                </div>
                <div class="col-md-12 titleDiv">
                    <label for="name_ar" class="form-control-label">العنوان</label>
                    <input type="text" class="form-control" name="title">
                </div>
                <div class="col-md-6 userSelect d-none">
                    <label for="name_ar" class="form-control-label">طالب</label>
                    <input list="users" name="user_id" class="form-control" placeholder="اكتب كود الطالب">
                    <datalist id="users">
                        @foreach($users as $user)
                            <option value="{{ $user->code }}"
                                    style="text-align: center">{{ $user->code }}</option>
                        @endforeach
                    </datalist>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="term_id" class="form-control-label">الترم</label>
                    <Select name="term_id" class="form-control">
                        <option selected style="text-align: center">الكل</option>
                        @foreach($terms as $term)
                            <option value="{{ $term->id }}"
                                    style="text-align: center">{{ $term->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="season_id" class="form-control-label">الصف</label>
                    <Select name="season_id" class="form-control">
                        <option selected style="text-align: center">الكل</option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}"
                                    style="text-align: center">{{ $season->name_ar }}</option>
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
        <div class="row">
            <div class="col-md-12">
                <label for="phone" class="form-control-label">الصورة</label>
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
    $('.dropify').dropify();

    $('.notificationType').on('change', function(){
        // alert($(this).val());
        if($(this).val() == 'user'){
            $('.userSelect').removeClass('d-none')
            $('.titleDiv').removeClass('col-md-12').addClass('col-md-6')
        } else {
            $('.userSelect').addClass('d-none')
            $('.titleDiv').addClass('col-md-12').removeClass('col-md-6')
        }
    })
</script>

