<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('terms.update', $term->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $term->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">{{ trans('admin.name_ar') }}</label>
                    <input type="text" class="form-control" value="{{ $term->name_ar }}" name="name_ar">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">{{ trans('admin.name_en') }}</label>
                    <input type="text" class="form-control" value="{{ $term->name_en }}" name="name_en">
                </div>
                <div class="col-md-12">
                    <label for="note" class="form-control-label">{{ trans('admin.note') }}</label>
                    <textarea class="form-control" name="note" rows="10">{{ $term->note }}</textarea>
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