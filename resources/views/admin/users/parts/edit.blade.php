<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('users.update',$user->id) }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="id" value="{{ $user->id }}">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Image :</label>
                        <input type="file" name="image" class="dropify" value="{{ ($user->image !== null) ? asset($user->image) : asset('users/default/avatar3.jpg') }}"
                               data-default-file="{{ ($user->image !== null) ? asset($user->image) : asset('users/default/avatar3.jpg') }}"/>
                    </div>
                    <span class="form-text text-danger text-center">
                        Recomended : 2048 X 1200 to up Px <br>
                        Extension : png, gif, jpeg,jpg,webp
                    </span>
                </div>
                <div class="col-md-6 mt-8">
                    <label for="name" class="form-control-label">اسم الطالب</label>
                    <input type="text" class="form-control" placeholder="اسم الطالب" name="name"
                            value="{{ $user->name }}">
                    <div class="row">
                        <div class="col-7">
                            <label for="code" class="form-control-label">كود الطالب</label>
                            <input type="text" class="form-control CodeStudent" placeholder="كود الطالب" name="code"
                                   disabled  value="{{ $user->code }}">
                            <input type="hidden" class="form-control CodeStudent" placeholder="كود الطالب" name="code" value="{{ $user->code }}">
                        </div>
                        <div class="col-5">
                            <button type="button" hidden
                                    class="btn btn-sm btn-primary form-control mt-5 GeneCode">
                                generate code
                            </button>
                        </div>
                        <div class="col-12">
                            <label for="birth_date" class="form-control-label">تاريخ الميلاد</label>
                            <input type="date" class="form-control" value="{{ $user->birth_date }}" placeholder="تاريخ الميلاد" name="birth_date"
                                  required>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <label for="phone" class="form-control-label">رقم الهاتف</label>
                    <input type="text" class="form-control phoneInput" value="{{ $user->phone }}" name="phone" placeholder="201XXXXXXXXX"
                           >
                </div>
                <div class="col-md-6">
                    <label for="father_phone" class="form-control-label">رقم هاتف ولي الامر</label>
                    <input type="text" class="form-control" value="{{ $user->father_phone }}" name="father_phone" placeholder="201XXXXXXXXX"
                           >
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name" class="form-control-label">الصف الدراسي</label>
                    <select class="form-control SeasonSelect" name="season_id">
                        <option value="" data-name="" disabled>اختار الصف</option>
                        @foreach($seasons as $season)
                            <option
                                {{ ($user->season_id == $season->id) ? 'selected' : '' }}
                                value="{{ $season->id}}">
                                {{ $season->name_ar }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="country_id" class="form-control-label">المحافظة</label>
                    <select class="form-control" name="country_id">
                        <option value="" disabled>اختار المحافظة</option>
                        @foreach($countries as $country)
                            <option
                                {{ ($user->country_id == $country->id) ? 'selected' : '' }}
                                value="{{ $country->id}}">
                                {{ $country->name_ar }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="date_start_code" class="form-control-label">تاريخ بداية الاشتراك</label>
                    <input type="date" class="form-control" value="{{ $user->date_start_code }}" name="date_start_code" placeholder="تاريخ بداية الاشتراك"
                           >
                </div>
                <div class="col-md-6">
                    <label for="date_end_code" class="form-control-label">تاريخ نهاية الاشتراك</label>
                    <input type="date" class="form-control" value="{{ $user->date_end_code }}" name="date_end_code" placeholder="تاريخ نهاية الاشتراك"
                           >
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-primary" id="addButton">تحديث</button>
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
