<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('subjectsClasses.update', $subjectsClass->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $subjectsClass->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">{{ trans('admin.name_ar') }}</label>
                    <input type="text" class="form-control" value="{{ $subjectsClass->name_ar }}" name="name_ar">
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">{{ trans('admin.name_en') }}</label>
                    <input type="text" class="form-control" value="{{ $subjectsClass->name_en }}" name="name_en">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">{{ trans('admin.season') }}</label>
                    <Select name="term_id" class="form-control">
                        <option selected disabled style="text-align: center">Select Season</option>
                        @foreach($terms as $term)
                            <option value="{{ $term->id }}"
                                    {{ $subjectsClass->term_id == $term->id? 'selected' : '' }}
                                    style="text-align: center">{{ $term->name_en }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-control-label">{{ trans('admin.note') }}</label>
                    <input type="text" class="form-control" value="{{ $subjectsClass->note }}" name="note">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Image :</label>
                        <input type="file" name="image" class="dropify"
                               data-default-file="{{ asset($subjectsClass->image) }}"/>

                    </div>
                    <span class="form-text text-danger text-center"> Recomended : 2048 X 1200 to up Px <br> Extension : png, gif, jpeg,
                                        jpg,webp</span>

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin.close') }}</button>
            <button type="submit" class="btn btn-success" id="updateButton">{{ trans('admin.update') }}</button>
        </div
    </form>
</div>
<script>
    $('.dropify').dropify()
</script>
