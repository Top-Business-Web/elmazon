<link href="{{asset('assets/admin')}}/plugins/select2/select2.min.css" rel="stylesheet"/>

<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Edit Supervisor</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="" >
    @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name" class="form-control-label">Photo</label>
{{--            <input type="file" id="testDrop" class="dropify" name="photo" data-default-file="{{get_user_photo($admin->photo)}}"/>--}}
        </div>
        <input type="hidden" name="id" value=""/>
        <div class="form-group">
            <label for="name" class="form-control-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="">
        </div>
        <div class="form-group">
            <label for="email" class="form-control-label">Email</label>
            <input type="text" class="form-control" name="email" id="email" value="">
        </div>
        <div class="form-group">
            <label for="password" class="form-control-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="********">
        </div>
{{--        @php--}}
{{--            $roles = ["platform","admin","activity"];--}}
{{--        @endphp--}}

        <div class="form-group">
            <label for="text" class="form-control-label">Supervisor type</label>
            <select class="form-control" name="supervisor_type">
                <option disabled>choose role</option>
{{--                @foreach($roles as $role)--}}
{{--                    <option value="{{$role}}" {{$admin->supervisor_type == $role ? 'selected' : ''}}>{{$role}}</option>--}}

{{--                @endforeach--}}
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Assign Roles</label>
            <select name="permissions[]" class="form-control select2" data-placeholder="Choose Roles" multiple>
{{--                @foreach($permissions as $permission)--}}
{{--                    <option value="{{$permission->name}}" {{in_array($permission->id,$adminPermissions) ? 'selected' : ''}}>{{$permission->name}}</option>--}}
{{--                @endforeach--}}
            </select>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" id="updateButton">Update</button>
        </div>
    </form>
</div>
<script>
    $('.dropify').dropify()
</script>
<script src="{{asset('assets/admin')}}/js/select2.js"></script>
<script src="{{asset('assets/admin')}}/plugins/select2/select2.full.min.js"></script>
