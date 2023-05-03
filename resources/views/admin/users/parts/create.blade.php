<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">صورة :</label>
                        <input type="file" name="image" class="dropify" value="{{ asset('users/default/avatar.jpg') }}"
                               data-default-file="{{ asset('users/default/avatar.jpg') }}" required/>
                    </div>
                    <span class="form-text text-danger text-center">
                        Recomended : 2048 X 1200 to up Px <br>
                        Extension : png, gif, jpeg,jpg,webp
                    </span>
                </div>
                <div class="col-md-6 mt-8">
                    <label for="name" class="form-control-label">اسم الطالب</label>
                    <input type="text" class="form-control" placeholder="اسم الطالب" name="name"
                           required="required">
                    <div class="row">
                        <div class="col-7">
                            <label for="code" class="form-control-label">كود الطالب</label>
                            <input type="text" class="form-control CodeStudent" placeholder="كود الطالب" name="code"
                                 disabled  required>
                            <input type="hidden" class="form-control CodeStudent" placeholder="كود الطالب" name="code" required>
                        </div>
                        <div class="col-5">
                            <button type="button"
                                    class="btn btn-sm btn-primary form-control mt-5 GeneCode">
                                generate code
                            </button>
                        </div>
                        <div class="col-12">
                            <label for="birth_date" class="form-control-label">تاريخ الميلاد</label>
                            <input type="date" class="form-control" placeholder="تاريخ الميلاد" name="birth_date"
                                  required>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <label for="phone" class="form-control-label">رقم الهاتف</label>
                    <input type="text" class="form-control phoneInput" name="phone" placeholder="201XXXXXXXXX"
                           required="required">
                </div>
                <div class="col-md-6">
                    <label for="father_phone" class="form-control-label">رقم هاتف ولي الامر</label>
                    <input type="text" class="form-control" name="father_phone" placeholder="201XXXXXXXXX"
                           required="required">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name" class="form-control-label">الصف الدراسي</label>
                    <select class="form-control SeasonSelect" name="season_id" required="required">
                        <option value="" data-name="" selected disabled>اختار الصف</option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id}}">{{ $season->name_ar }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="country_id" class="form-control-label">المحافظة</label>
                    <select class="form-control" name="country_id" required="required">
                        <option value="" selected disabled>اختار المحافظة</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id}}">{{ $country->name_ar }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="date_start_code" class="form-control-label">تاريخ بداية الاشتراك</label>
                    <input type="date" class="form-control" name="date_start_code" placeholder="تاريخ بداية الاشتراك"
                           required="required">
                </div>
                <div class="col-md-6">
                    <label for="date_end_code" class="form-control-label">تاريخ نهاية الاشتراك</label>
                    <input type="date" class="form-control" name="date_end_code" placeholder="تاريخ نهاية الاشتراك"
                           required="required">
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

    $('.GeneCode').on('click', function () {
        // var data = $(this).val();
        // var phone = $('.phoneInput').val();
        var code = Math.floor(Math.random() * 9999999999999);
        var userCode = ''
        $('.CodeStudent').val(code);
    })
</script>
