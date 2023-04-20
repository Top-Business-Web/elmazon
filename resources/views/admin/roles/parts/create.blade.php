<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{route('roles.store')}}">
        @csrf
        <div class="form-group">
            <label for="name" class="form-control-label">الاسم</label>
            <input type="text" class="form-control" name="name" id="name" required="required">
        </div>

        <div class="form-group">
            <label class="form-control-label">الصلاحيات</label>
            <hr>
            @foreach($permissions as $permission)
                <div class="badge badge-primary m-2">
                    <input type="checkbox" class="" name="permission[]" value="{{ $permission->id }}"
                           id="{{ $permission->id }}">
                    <label for="{{ $permission->id }}" class="m-2">{{ $permission->name }}</label>
                </div>
            @endforeach
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
