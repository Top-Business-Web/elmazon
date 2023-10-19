<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('motivational.update', $motivational->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $motivational->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label for="percentage" class="form-control-label">النسبةالمئوية</label>
                    <input type="text" class="form-control" name="percentage"
                           placeholder="مثال : 100%"
                           value="{{ $motivational->percentage }}"
                           id="percentage">
                </div>
                <div class="col-md-12">
                    <label for="name_ar" class="form-control-label">الجملة بالعربية</label>
                    <textarea rows="7" class="form-control" name="title_ar" required>{{ $motivational->title_ar }}</textarea>
                </div>
                <div class="col-md-12">
                    <label for="name_en" class="form-control-label">الجملة بالانجليزية</label>
                    <textarea rows="7" class="form-control" name="title_en" required>{{ $motivational->title_en }}</textarea>
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
