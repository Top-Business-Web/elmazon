<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('lessons.store') }}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">{{ trans('admin.name_ar') }}</label>
                    <input type="text" class="form-control" name="name_ar">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">{{ trans('admin.name_en') }}</label>
                    <input type="text" class="form-control" name="name_en">
                </div>
            </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="subject_class" class="form-control-label">فئة الموضوع</label>
                        <select class="form-control" name="subject_class_id">
                            <option selected disabled style="text-align: center">Select Subject Class</option>
                            @foreach($subjects_classes as $subject_class)
                                <option style="text-align: center" value="{{ $subject_class->id }}">{{ $subject_class->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="note" class="form-control-label">{{ trans('admin.note') }}</label>
                        <textarea class="form-control" name="note" rows="10"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin.close') }}</button>
            <button type="submit" class="btn btn-primary" id="addButton">{{ trans('admin.add') }}</button>
        </div>
    </form>
</div>

<script>
    $('.dropify').dropify()
</script>
