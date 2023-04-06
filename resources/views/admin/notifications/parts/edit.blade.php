<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('notifications.update', $notification->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $notification->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">العنوان</label>
                    <input type="text" class="form-control" value="{{ $notification->title }}" name="title">
                </div>
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">طالب</label>
                    <Select name="user_id" class="form-control">
                        <option selected disabled style="text-align: center">اختار طالب</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                    {{ ($notification->user_id == $user->id)? 'selected' : '' }}
                                    style="text-align: center">{{ $user->name }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الترم</label>
                    <Select name="term_id" class="form-control">
                        <option selected disabled style="text-align: center">اختار الترم</option>
                        @foreach ($data['terms'] as $term)
                            <option value="{{ $term->id }}"
                                    {{ $lifeExam->term_id == $term->id ? 'selected' : '' }} style="text-align: center">
                                {{ $term->name_en }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الصف</label>
                    <Select name="season_id" class="form-control">
                        <option selected disabled style="text-align: center">اختار الصف</option>
                        @foreach ($data['seasons'] as $season)
                            <option value="{{ $season->id }}"
                                    {{ $lifeExam->season_id == $season->id ? 'selected' : '' }}
                                    style="text-align: center">{{ $season->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="name_en" class="form-control-label">الرسالة</label>
                    <textarea class="form-control" name="body" rows="10">{{ $notification->body }}</textarea>
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
</script>
