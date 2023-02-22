<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('groups.update', $group->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $group->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">{{ trans('admin.name_ar') }}</label>
                    <input type="text" class="form-control" value="{{ $group->name_ar }}" name="name_ar">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">{{ trans('admin.name_en') }}</label>
                    <input type="text" class="form-control" value="{{ $group->name_en }}" name="name_en">
                </div>
                <div class="col-md-12">
                    <label for="note" class="form-control-label">{{ trans('admin.note') }}</label>
                    <Select class="form-control" name="season_id">
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}"
                                    {{ $group->season_id == $season->id ? 'selected' : '' }}
                                    style="text-align: center">{{ $season->name_en }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin.close') }}</button>
            <button type="submit" class="btn btn-success" id="updateButton">{{ trans('admin.update') }}</button>
        </div>
    </form>
</div>
<script>
    $('.dropify').dropify()
</script>
