@extends('admin.layouts_admin.master')
@section('title')
    {{($setting->title) ?? 'الصفحة الرئيسية'}} | لوحة التحكم
@endsection
@section('page_name')
    الرئـيسية
@endsection
@section('content')


    <div class="row">

        <!--  city chart -->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="card" style="height: 444px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div id="myChartPie"></div>
                        </div>
                        <div class="col">
                            <div id="myChartCol"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  city chart -->

        <!--  city chart -->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h1 class="text-center font-weight-bold"> احصائيات عامة </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  city chart -->


        <!-- users Count -->
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <i style="font-size: xxx-large" class="fa fa-graduation-cap d-flex"></i>
                        <div class="col">
                            <h6 class="bold font-weight-bolder">كل الطلاب</h6>
                            <h3 class="mb-2 number-font">{{ $users }}</h3>
                            <div class="progress h-2">
                                <div class="progress-bar bg-primary-gradient
                                    @if($users > 5 )
                                 w-10
                                @elseif($users > 15)
                                    w-25
                                @elseif($users > 45)
                                    w-50
                                @elseif($users > 70)
                                    w-75
                                @elseif($users > 90)
                                    w-100
                                @elseif($users > 150)
                                    w-260
                                @elseif($users > 200)
                                    w-337
                                 @endif
                                " role="progressbar"></div>
                            </div>
                        </div>
                        <a class="btn btn-sm btn-primary-light h-6 d-flex" href="{{ route('users.index') }}">
                            المزيد
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- users in center Count -->
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <i style="font-size: xxx-large" class="fa fa-graduation-cap d-flex"></i>
                        <div class="col">
                            <h6 class="bold font-weight-bolder">الطلاب داخل السنتر</h6>
                            <h3 class="mb-2 number-font">{{ $usersIn }}</h3>
                            <div class="progress h-2">
                                <div class="progress-bar bg-primary-gradient
                                    @if($usersIn > 5 )
                                 w-10
                                @elseif($usersIn > 15)
                                    w-25
                                @elseif($usersIn > 45)
                                    w-50
                                @elseif($usersIn > 70)
                                    w-75
                                @elseif($usersIn > 90)
                                    w-100
                                @elseif($usersIn > 150)
                                    w-260
                                @elseif($usersIn > 200)
                                    w-337
                                 @endif
                                " role="progressbar"></div>
                            </div>
                        </div>
                        <a class="btn btn-sm btn-primary-light h-6 d-flex" href="{{ route('users.index') }}">
                            المزيد
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- users out center Count -->
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <i style="font-size: xxx-large" class="fa fa-graduation-cap d-flex"></i>
                        <div class="col">
                            <h6 class="bold font-weight-bolder">الطلاب خارج السنتر</h6>
                            <h3 class="mb-2 number-font">{{ $usersOut }}</h3>
                            <div class="progress h-2">
                                <div class="progress-bar bg-primary-gradient
                                    @if($usersOut > 5 )
                                 w-10
                                @elseif($usersOut > 15)
                                    w-25
                                @elseif($usersOut > 45)
                                    w-50
                                @elseif($usersOut > 70)
                                    w-75
                                @elseif($usersOut > 90)
                                    w-100
                                @elseif($usersOut > 150)
                                    w-260
                                @elseif($usersOut > 200)
                                    w-337
                                 @endif
                                " role="progressbar"></div>
                            </div>
                        </div>
                        <a class="btn btn-sm btn-primary-light h-6 d-flex" href="{{ route('users.index') }}">
                            المزيد
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- paperExam Count -->
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <i style="font-size: xxx-large" class="fa fa-scroll d-flex"></i>
                        <div class="col">
                            <h6 class="bold font-weight-bolder"> عدد الامتحانات الورقية</h6>
                            <h3 class="mb-2 number-font">{{ $paperExam }}</h3>
                            <div class="progress h-2">
                                <div class="progress-bar bg-primary-gradient
                                    @if($paperExam > 5 )
                                 w-10
                                @elseif($paperExam > 15)
                                    w-25
                                @elseif($paperExam > 45)
                                    w-50
                                @elseif($paperExam > 70)
                                    w-75
                                @elseif($paperExam > 90)
                                    w-100
                                @elseif($paperExam > 150)
                                    w-260
                                @elseif($paperExam > 200)
                                    w-337
                                 @endif
                                " role="progressbar"></div>
                            </div>
                        </div>
                        <a class="btn btn-sm btn-primary-light h-6 d-flex" href="{{ route('papelSheetExam.index') }}">
                            المزيد
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- onlineExam Count -->
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <i style="font-size: xxx-large" class="fa fa-globe d-flex"></i>
                        <div class="col">
                            <h6 class="bold font-weight-bolder"> عدد الامتحانات الاونلاين</h6>
                            <h3 class="mb-2 number-font">{{ $onlineExam }}</h3>
                            <div class="progress h-2">
                                <div class="progress-bar bg-primary-gradient
                                    @if($onlineExam > 5 )
                                 w-10
                                @elseif($onlineExam > 15)
                                    w-25
                                @elseif($onlineExam > 45)
                                    w-50
                                @elseif($onlineExam > 70)
                                    w-75
                                @elseif($onlineExam > 90)
                                    w-100
                                @elseif($onlineExam > 150)
                                    w-260
                                @elseif($onlineExam > 200)
                                    w-337
                                 @endif
                                " role="progressbar"></div>
                            </div>
                        </div>
                        <a class="btn btn-sm btn-primary-light h-6 d-flex" href="{{ route('onlineExam.index') }}">
                            المزيد
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- liveExam Count -->
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <i style="font-size: xxx-large" class="fa fa-globe d-flex"></i>
                        <div class="col">
                            <h6 class="bold font-weight-bolder"> عدد الامتحانات اللايف</h6>
                            <h3 class="mb-2 number-font">{{ $liveExam }}</h3>
                            <div class="progress h-2">
                                <div class="progress-bar bg-primary-gradient
                                    @if($liveExam > 5 )
                                 w-10
                                @elseif($liveExam > 15)
                                    w-25
                                @elseif($liveExam > 45)
                                    w-50
                                @elseif($liveExam > 70)
                                    w-75
                                @elseif($liveExam > 90)
                                    w-100
                                @elseif($liveExam > 150)
                                    w-260
                                @elseif($liveExam > 200)
                                    w-337
                                 @endif
                                " role="progressbar"></div>
                            </div>
                        </div>
                        <a class="btn btn-sm btn-primary-light h-6 d-flex" href="{{ route('lifeExam.index') }}">
                            المزيد
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- videoParts Count -->
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <i style="font-size: xxx-large" class="fa fa-video d-flex"></i>
                        <div class="col">
                            <h6 class="bold font-weight-bolder"> عدد الفيديوهات (الدروس)</h6>
                            <h3 class="mb-2 number-font">{{ $videoParts }}</h3>
                            <div class="progress h-2">
                                <div class="progress-bar bg-primary-gradient
                                    @if($videoParts >= 5 )
                                 w-10
                                @elseif($videoParts > 15)
                                    w-25
                                @elseif($videoParts > 45)
                                    w-50
                                @elseif($videoParts > 70)
                                    w-75
                                @elseif($videoParts > 90)
                                    w-100
                                @elseif($videoParts > 150)
                                    w-260
                                @elseif($videoParts > 200)
                                    w-337
                                 @endif
                                " role="progressbar"></div>
                            </div>
                        </div>
                        <a class="btn btn-sm btn-primary-light h-6 d-flex" href="{{ route('videosParts.index') }}">
                            المزيد
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- videoBasic Count -->
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <i style="font-size: xxx-large" class="fa fa-video d-flex"></i>
                        <div class="col">
                            <h6 class="bold font-weight-bolder">عدد الفيديوهات (الاساسيات)</h6>
                            <h3 class="mb-2 number-font">{{ $videoBasic }}</h3>
                            <div class="progress h-2">
                                <div class="progress-bar bg-primary-gradient
                                    @if($videoBasic >= 5 )
                                 w-10
                                @elseif($videoBasic > 15)
                                    w-25
                                @elseif($videoBasic > 45)
                                    w-50
                                @elseif($videoBasic > 70)
                                    w-75
                                @elseif($videoBasic > 90)
                                    w-100
                                @elseif($videoBasic > 150)
                                    w-260
                                @elseif($videoBasic > 200)
                                    w-337
                                 @endif
                                " role="progressbar"></div>
                            </div>
                        </div>
                        <a class="btn btn-sm btn-primary-light h-6 d-flex" href="{{ route('videosParts.index') }}">
                            المزيد
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- videoResource Count -->
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <i style="font-size: xxx-large" class="fa fa-video d-flex"></i>
                        <div class="col">
                            <h6 class="bold font-weight-bolder">عدد الفيديوهات (المراجعات)</h6>
                            <h3 class="mb-2 number-font">{{ $videoResource }}</h3>
                            <div class="progress h-2">
                                <div class="progress-bar bg-primary-gradient
                                    @if($videoResource >= 5 )
                                 w-10
                                @elseif($videoResource > 15)
                                    w-25
                                @elseif($videoResource > 45)
                                    w-50
                                @elseif($videoResource > 70)
                                    w-75
                                @elseif($videoResource > 90)
                                    w-100
                                @elseif($videoResource > 150)
                                    w-260
                                @elseif($videoResource > 200)
                                    w-337
                                 @endif
                                " role="progressbar"></div>
                            </div>
                        </div>
                        <a class="btn btn-sm btn-primary-light h-6 d-flex" href="{{ route('videosParts.index') }}">
                            المزيد
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- lesson Count -->
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <i style="font-size: xxx-large" class="fa fa-book-open d-flex"></i>
                        <div class="col">
                            <h6 class="bold font-weight-bolder">عدد الدروس</h6>
                            <h3 class="mb-2 number-font">{{ $lesson }}</h3>
                            <div class="progress h-2">
                                <div class="progress-bar bg-primary-gradient
                                    @if($lesson >= 5 )
                                 w-10
                                @elseif($lesson > 15)
                                    w-25
                                @elseif($lesson > 45)
                                    w-50
                                @elseif($lesson > 70)
                                    w-75
                                @elseif($lesson > 90)
                                    w-100
                                @elseif($lesson > 150)
                                    w-260
                                @elseif($lesson > 200)
                                    w-337
                                 @endif
                                " role="progressbar"></div>
                            </div>
                        </div>
                        <a class="btn btn-sm btn-primary-light h-6 d-flex" href="{{ route('lessons.index') }}">
                            المزيد
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!--  class Count -->
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <i style="font-size: xxx-large" class="fa fa-grip-lines d-flex"></i>
                        <div class="col">
                            <h6 class="bold font-weight-bolder">عدد الوحدات</h6>
                            <h3 class="mb-2 number-font">{{ $class }}</h3>
                            <div class="progress h-2">
                                <div class="progress-bar bg-primary-gradient
                                    @if($class >= 5 )
                                 w-10
                                @elseif($class > 15)
                                    w-25
                                @elseif($class > 45)
                                    w-50
                                @elseif($class > 70)
                                    w-75
                                @elseif($class > 90)
                                    w-100
                                @elseif($class > 150)
                                    w-260
                                @elseif($class > 200)
                                    w-337
                                 @endif
                                " role="progressbar"></div>
                            </div>
                        </div>
                        <a class="btn btn-sm btn-primary-light h-6 d-flex" href="{{ route('subjectsClasses.index') }}">
                            المزيد
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!--  suggest Count -->
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <i style="font-size: xxx-large" class="fa fa-comment d-flex"></i>
                        <div class="col">
                            <h6 class="bold font-weight-bolder">الاقتراحات</h6>
                            <h3 class="mb-2 number-font">{{ $suggest }}</h3>
                            <div class="progress h-2">
                                <div class="progress-bar bg-primary-gradient
                                    @if($suggest >= 5 )
                                 w-10
                                @elseif($suggest > 15)
                                    w-25
                                @elseif($suggest > 45)
                                    w-50
                                @elseif($suggest > 70)
                                    w-75
                                @elseif($suggest > 90)
                                    w-100
                                @elseif($suggest > 150)
                                    w-260
                                @elseif($suggest > 200)
                                    w-337
                                 @endif
                                " role="progressbar"></div>
                            </div>
                        </div>
                        <a class="btn btn-sm btn-primary-light h-6 d-flex" href="{{ route('suggestions.index') }}">
                            المزيد
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!--  suggest Count -->
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <i style="font-size: xxx-large" class="fa fa-question-circle d-flex"></i>
                        <div class="col">
                            <h6 class="bold font-weight-bolder">بنك الاسئلة</h6>
                            <h3 class="mb-2 number-font">{{ $question }}</h3>
                            <div class="progress h-2">
                                <div class="progress-bar bg-primary-gradient
                                    @if($question >= 5 )
                                 w-10
                                @elseif($question > 15)
                                    w-25
                                @elseif($question > 45)
                                    w-50
                                @elseif($question > 70)
                                    w-75
                                @elseif($question > 90)
                                    w-100
                                @elseif($question > 150)
                                    w-260
                                @elseif($question > 200)
                                    w-337
                                 @endif
                                " role="progressbar"></div>
                            </div>
                        </div>
                        <a class="btn btn-sm btn-primary-light h-6 d-flex" href="{{ route('questions.index') }}">
                            المزيد
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--  suggest Count -->

        <!--  section Count -->
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <i style="font-size: xxx-large" class="fa fa-question-circle d-flex"></i>
                        <div class="col">
                            <h6 class="bold font-weight-bolder">عدد القاعات</h6>
                            <h3 class="mb-2 number-font">{{ $section }}</h3>
                            <div class="progress h-2">
                                <div class="progress-bar bg-primary-gradient
                                    @if($section >= 5 )
                                 w-10
                                @elseif($section > 15)
                                    w-25
                                @elseif($section > 45)
                                    w-50
                                @elseif($section > 70)
                                    w-75
                                @elseif($section > 90)
                                    w-100
                                @elseif($section > 150)
                                    w-260
                                @elseif($section > 200)
                                    w-337
                                 @endif
                                " role="progressbar"></div>
                            </div>
                        </div>
                        <a class="btn btn-sm btn-primary-light h-6 d-flex" href="{{ route('section.index') }}">
                            المزيد
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--  section Count -->

        <!--  guide Count -->
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <i style="font-size: xxx-large" class="fa fa-question-circle d-flex"></i>
                        <div class="col">
                            <h6 class="bold font-weight-bolder">عدد المصادر المراجع</h6>
                            <h3 class="mb-2 number-font">{{ $guide }}</h3>
                            <div class="progress h-2">
                                <div class="progress-bar bg-primary-gradient
                                    @if($guide >= 5 )
                                 w-10
                                @elseif($guide > 15)
                                    w-25
                                @elseif($guide > 45)
                                    w-50
                                @elseif($guide > 70)
                                    w-75
                                @elseif($guide > 90)
                                    w-100
                                @elseif($guide > 150)
                                    w-260
                                @elseif($guide > 200)
                                    w-337
                                 @endif
                                " role="progressbar"></div>
                            </div>
                        </div>
                        <a class="btn btn-sm btn-primary-light h-6 d-flex" href="{{ route('section.index') }}">
                            المزيد
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--  guide Count -->

        <script src="https://cdn.canvasjs.com/ga/canvasjs.min.js"></script>
        <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
        <script>
            var countryData = @php echo json_encode(array_values($country_name)) @endphp;
            var countryValData = @php echo json_encode(array_values($country_val)) @endphp;
            var dataPoints = [];

            for (var i = 0; i < countryData.length; i++) {
                dataPoints.push({
                    label: countryData[i], // Set the label from your data
                    y: countryValData[i] // Set the y value from your data
                });
            }
            var options = {
                animationEnabled: true,
                title: {
                    text: "احصائيات المحافظات"
                },
                data: [{
                    type: "pie",
                    yValueFormatString: "#,##0.0#",
                    dataPoints: dataPoints // Assign the dataPoints array here
                }]
            };

            $("#myChartPie").CanvasJSChart(options);


            var options1 = {
                animationEnabled: true,
                title: {
                    text: "احصائيات المحافظات"
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,##0.0#",
                    dataPoints: dataPoints // Assign the dataPoints array here
                }]
            };

            $("#myChartCol").CanvasJSChart(options1);
        </script>

    </div>

@endsection
@section('js')

@endsection

