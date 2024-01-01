@extends('admin.layouts_admin.master')

@section('title')
    وضع المطور
@endsection
@section('page_name')
    وضع المطور
@endsection
@section('content')
    <form method="POST" id="updateForm" class="updateForm" action="{{ route('advancedDo') }}" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h3 class="text-center font-weight-bold"> فتح فيديو لطالب</h3>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="season"> كود الطالب</label>
                            <input class="form-control" list="studens" id="student" name="user_id" type="text">
                            <datalist id="studens">
                                @foreach ($students as $s)
                                    <option value="{{ $s->id }}">{{ $s->code }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-4">
                            <label for="season"> ID فيديو</label>
                            <input class="form-control" list="videos" id="video_id" name="video_id" type="text">
                            <datalist id="videos">
                                @foreach ($videos as $v)
                                    <option value="{{ $v->id }}">{{ $v->name_ar }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div style="display: flex; align-items: center" class="col-4">
                            <div style="margin-top: 26px">
                                <button class=" from-control btn btn-success" type="submit">تاكيد</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <!-- End Form -->
    @include('admin.layouts_admin.myAjaxHelper')
    <script></script>
@endsection
