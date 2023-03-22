@extends('admin.layouts_admin.master')
@foreach($answers as $answer)
    @section('title')
       ورقة الطالب  {{ $answer->user->name }}
    @endsection
    @section('page_name')
        ورقة الطالب  {{ $answer->user->name }}
    @endsection
@endforeach
@section('content')

    <form action="{{ route('storeExamPaper') }}" method="post">
        @csrf
{{--        <input type="hidden" name="user_id" value="{{ $answer->user->id }}"/>--}}
        <div class="form-group">
            <div class="row">
                @foreach($answers as $answer)
                    <div class="col-md-4">
                        <label for="question_text">السؤال :</label>
                        <textarea class="form-control" name="question_id" rows="6" disabled
                                  id="question_text">{{ $answer->question->question }}</textarea>
                    </div>
                    <input type="hidden" name="questions[{{$loop->iteration}}][question_id]" value="{{ $answer->question_id }}"/>
                    <div class="col-md-4">
                        <label for="answer_choices">الاجابة :</label>
                        <textarea class="form-control" rows="4" disabled
                                  id="answer_choices">{{ $answer->answer }}</textarea>
                    </div>
                    <div class="col-md-1">
                        <label for="correct_answer">الدرجة :</label>
                        <input type="number"  name="questions[{{$loop->iteration}}][degree]"  class="form-control">
                    </div>
                    <div class="col-md-0">
                        <label for="correct_answer">درجة السؤال :</label>
                        <input type="number" name="degree" style="text-align: center" value="{{ $answer->question->degree }}" class="form-control" disabled>
                    </div>
                @endforeach
            </div>
            <div class="row">
                @foreach($question as $answer)
                    <div class="col-md-4">
                        <label for="question_text">السؤال :</label>
                        <textarea class="form-control"  rows="6" disabled
                                  id="question_text">{{ $answer->question->question }}</textarea>
                    </div>
                <input type="hidden"  value="{{ $answer->question_id }}"/>
                    <div class="col-md-4">
                        <label for="answer_choices">الاجابة :</label>
                        <textarea class="form-control" rows="4" disabled
                                  id="answer_choices"></textarea>
                    </div>
                    <div class="col-md-0">
                        <label for="correct_answer" style="text-align: center">درجة السؤال :</label>
                        <input type="number" style="text-align: center" value="{{ $answer->question->degree }}" class="form-control" disabled>
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" class="btn btn-primary">تصحيح</button>
    </form>

    </div>
    @include('admin.layouts_admin.myAjaxHelper')
@endsection


