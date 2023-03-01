<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="<?php echo e(route('addAnswer',$question->id)); ?>">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <input type="hidden" name="question_id" value="<?php echo e($question->id); ?>" class="form-control">
            <div class="row">
                <div class="col-lg-12">
                    <div id="inputFormRow">
                        <div class="input-group mb-3">
                            <input type="hidden" name="answer_number[1]" class="form-control">
                            <input type="text" name="answer[1]" class="form-control m-input">
                            <div class="input-group-append">
                                <button id="removeRow" type="button" class="btn btn-danger">ازالة</button>
                            </div>
                            <input type="radio" name="answer_status"
                                   value="1" class="form-control check_class" required>
                        </div>
                    </div>

                    <div id="newRow"></div>
                    <button id="addRow" type="button" class="btn btn-info addAnswer">اضافة اجابة</button>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="buttonAnswer" class="btn btn-primary" id="addButton">اضافة</button>
        </div>
    </form>
</div>

<script type="text/javascript">

    var i = 1;
    // add row
    $("#addRow").click(function () {

        ++i;
        var html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<input type="hidden" name="answer_number[' + i + ']" class="form-control">';
        html += '<input type="text" name="answer[' + i + ']" data-num=""  class="form-control m-input answerInput" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow" type="button" class="btn btn-danger">ازالة</button>';
        html += '</div>';
        html += '<input type="radio" name="answer_status" value="' + i + '" class="form-control check_class"></span>';
        html += '</div>';

        // var answerLength =  $('.answerInput').length();
        var answer = $('.answerInput');

        if (answer.last().val() !== '' && answer.length < 3) {
            $('#newRow').append(html);
            var numQuestion = answer.length;
            $('')
        }

    });


    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
    });


</script>
<?php /**PATH C:\laragon\www\students\resources\views/admin/questions/parts/answers.blade.php ENDPATH**/ ?>