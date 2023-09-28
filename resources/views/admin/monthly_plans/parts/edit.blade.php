<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('monthlyPlans.update', $monthlyPlan->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $monthlyPlan->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label for="name_ar" class="form-control-label">العنوان</label>
                    <input type="text" class="form-control" value="{{ $monthlyPlan->title }}" name="title" style="text-align: center">
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-control-label">من</label>
                    <input type="date" class="form-control" value="{{ $monthlyPlan->start }}" name="start">
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-control-label">الى</label>
                    <input type="date" class="form-control" value="{{ $monthlyPlan->end }}" name="end">
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
