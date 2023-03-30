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
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">بيانات امتحان الطالب </h1>

                </div>
                <div class="card-body">
                    @foreach($answers as $answer)
                    <form id="addForm" class="addForm" method="POST" action="{{ route('paperExamSheetStore', $answer->user_id) }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $answer->user_id }}"/>
                        <input type="hidden" name="papel_sheet_exam_id" value="{{ $answer->papel_sheet_exam_id }}"/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">الامتحان</label>
                                        <input class="form-control" name=""
                                               value="{{ $answer->papelSheetExam->name_ar }}"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">وقت الامتحان</label>
                                        <input class="form-control" name=""
                                               value="{{ $answer->papelSheetExamTime->from }}"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">الطالب</label>
                                        <input class="form-control" name="" value="{{ $answer->user->name }}"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">القاعة</label>
                                        <input class="form-control" name=""
                                               value="{{ $answer->sections->section_name_ar }}"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">الدرجة</label>
                                        <input type="number" class="form-control" style="text-align: center" name="degree" value=""/>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary" data-dismiss="modal">اضافة علامة</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layouts_admin.myAjaxHelper')
@endsection


