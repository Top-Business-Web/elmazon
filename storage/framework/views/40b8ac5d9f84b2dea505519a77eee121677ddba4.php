<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="<?php echo e(route('addAnswer')); ?>">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <input type="hidden" name="question_id" id="<?php echo e($question->id); ?>" class="form-control">
            <div class="row">
                <div class="col-lg-12">
                    <div id="inputFormRow">
                        <div class="input-group mb-3">
                            <input type="text" name="answer[]" class="form-control m-input"  autocomplete="off">
                            <div class="input-group-append">
                                <button id="removeRow" type="button" class="btn btn-danger">ازالة</button>
                            </div>
                            <input type="radio" name="answer_status" class="form-control check_class">
                        </div>
                    </div>

                    <div id="newRow"></div>
                    <button id="addRow" type="button" class="btn btn-info addAnswer">اضافة اجابة</button>
                    <button type="button" class="btn btn-success accept">تأكيد</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="note">ملاحظة</label> :
                    <textarea rows="10" name="note" class="form-control note"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
        </div>
    </form>
</div>

<script type="text/javascript">


    // add row
    $("#addRow").click(function () {


        var html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<input type="text" name="answer[]" class="form-control m-input answerInput" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow" type="button" class="btn btn-danger">ازالة</button>';
        html += '</div>';
        html += '<input type="radio" name="answer_status" class="form-control check_class"></span>';
        html += '</div>';

        // var answerLength =  $('.answerInput').length();
        var answer =  $('.answerInput');

        if (answer.last().val() !== '' && answer.length < 3) {
            $('#newRow').append(html);
            console.log(answer.length);
        }

    });



    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
    });


    $('.accept').on('click', function () {
        if( $('.check_class').is(':checked') ){
            var value = $('.answerInput').val();


        }
    })

</script>
<?php /**PATH C:\laragon\www\students\resources\views/admin/questions/parts/answers.blade.php ENDPATH**/ ?>