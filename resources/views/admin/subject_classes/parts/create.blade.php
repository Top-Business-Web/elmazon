<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('subjectsClasses.store') }}" enctype="multipart/form-data">
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
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">{{ trans('admin.season') }}</label>
                    <Select name="term_id" class="form-control">
                        <option selected disabled style="text-align: center">Select Season</option>
                        @foreach($terms as $term)
                            <option value="{{ $term->id }}"
                                    style="text-align: center">{{ $term->name_en }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-control-label">{{ trans('admin.note') }}</label>
                    <input type="text" class="form-control" name="note">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Image :</label>
                        <input type="file" name="image" class="dropify"
                               data-default-file=""/>

                    </div>
                    <span class="form-text text-danger text-center"> Recomended : 2048 X 1200 to up Px <br> Extension : png, gif, jpeg,
                                        jpg,webp</span>

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
    $('.dropify').dropify();
</script>

