@extends('Admin/layouts_admin/master')

@section('title')
    اسئلة امتحان الاونلاين
@endsection
@section('page_name')
    اسئلة امتحان الاونلاين
@endsection
@section('content')
    <form method="POST" action="">
        @csrf
        <input type="hidden" name="online_exam_id" value="{{ $exam->id }}">
        <input type="hidden" name="all_exam_id">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-striped table-bordered text-nowrap w-100" id="dataTable">
                                <thead>
                                    <tr class="fw-bolder text-muted bg-light">
                                        <th class="min-w-25px">#</th>
                                        <th class="min-w-50px">السؤال</th>
                                        <th class="min-w-50px">ملاحظة</th>
                                        <th class="min-w-50px">فصل</th>
                                        <th class="min-w-50px">الترم</th>
                                        <th class="min-w-50px">نوع المثال</th>
                                        <th class="min-w-50px">المثال</th>
                                        <th class="min-w-50px rounded-end">العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questions as $question)
                                        <tr>
                                            <td>{{ $question->id }}</td>
                                            <td>{{ $question->question }}</td>
                                            <td>{{ $question->note }}</td>
                                            <td>{{ $question->season_id }}</td>
                                            <td>{{ $question->term_id }}</td>
                                            <td>{{ $question->examable_type }}</td>
                                            <td>{{ $question->examable_id }}</td>
                                            <td><input type="checkbox"
                                                 class="form-control check1 check" name="question_id" 
                                                 {{ (in_array($question->id,$online_questions_ids)? "checked":'') }}
                                                    value="{{ $question->id }}"
                                                     id="check"></td>
                                                     

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @include('Admin/layouts_admin/myAjaxHelper')
@endsection
@section('ajaxCalls')
    <script>
        $(".check").on('click', function() {
           
            var exam = $('input[name="online_exam_id"]').val();
            var question = $(this).val();
            
            if ($(this).is(':checked')) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('addQuestion') }}',
                    data: {
                       
                        online_exam_id: exam,
                        question_id: question,
                        "_token": $('#token').val()

                    },
                    success: function(data) {
                        toastr.success('تم الاضافة بنجاح');
                    },
                    error: function(data) {
                        toastr.error('هناك خطأ ما ..');
                    }

                });
            } else {
                alert(question)
                $.ajax({
                    type: 'POST',
                    url: '{{ route('deleteQuestion') }}',
                    data: {

                        online_exam_id: exam,
                        question_id: question,
                        "_token": $('#token').val()

                    },
                    success: function(data) {
                        toastr.success('تم الحذف بنحاح بنجاح');
                    },
                    error: function(data) {
                        toastr.error('هناك خطأ ما ..');
                    }
                })
            }
        })
    </script>
@endsection
