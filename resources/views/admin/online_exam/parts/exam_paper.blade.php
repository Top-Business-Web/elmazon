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

    <form action="" method="post">
        @csrf
        <div class="form-group">
            <div class="row">
                @foreach($answers as $answer)
                    <div class="col-md-4">
                        <label for="question_text">Question text:</label>
                        <textarea class="form-control" rows="6" disabled
                                  id="question_text">{{ $answer->question->question }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label for="answer_choices">Answer choices:</label>
                        <textarea class="form-control" rows="4" disabled
                                  id="answer_choices">{{ $answer->answer }}</textarea>
                    </div>
                    <div class="col-md-0">
                        <label for="correct_answer">مصحح/ غير مصحح:</label>
                        <input type="checkbox" class="form-control">
                    </div>
                @endforeach
            </div>
            <div class="row">
                @foreach($question as $answer)
                    <div class="col-md-4">
                        <label for="question_text">Question text:</label>
                        <textarea class="form-control" rows="6" disabled
                                  id="question_text">{{ $answer->question->question }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label for="answer_choices">Answer choices:</label>
                        <textarea class="form-control" rows="4" disabled
                                  id="answer_choices"></textarea>
                    </div>
                    <div class="col-md-0">
                        <label for="correct_answer">Degree:</label>
                        <input type="number" class="form-control">
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    </div>
    @include('admin.layouts_admin.myAjaxHelper')
@endsection


