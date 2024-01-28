<div class="modal-body">
    <div class="row">
        <div class="col-md-12 mt-3">
            <label for="section_name_ar" class="form-control-label">ارفق المرجع*</label>
        </div>
    </div>
    <form action="{{ route('guide.guidUploadFile',$guide->id) }}" class="dropzone" id="my-dropzone">
        @csrf
    </form>

</div>
<script>
    Dropzone.discover();
</script>

<script>
    Dropzone.options.myDropzone = {
        maxFilesize: 500,
        init: function() {
            this.on("uploadprogress", function(file, progress) {
                console.log("File progress", progress);
            });
        }
    }
</script>
