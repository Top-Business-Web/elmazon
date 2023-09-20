@extends('admin.layouts_admin.master')

@section('title')
    تقرير الطالب
@endsection
@section('page_name')
    {{  '  تقرير الطالب :  '. $user->name  }}
@endsection
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body" id="cardPrint">
                                <div class="invoice-title">
                                    <h3 class="float-end font-size-16">{{ ' اسم الطالب : ' . $user->name }}</h3>
                                    <h6 class="float-end font-size-16">{{ ' كود الطالب : ' . $user->code }} </h6>
                                    <h6 class="float-end font-size-16">
                                        {{ ' الصف الدراسي : ' . $user->season->name_ar . ' - ' . $term->name_ar }}
                                    </h6>
                                </div>
                                <hr>
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 col-6 fw-bold">معلومات الاشتراك</h3>
                                </div>
                                <div class="styled-table">
                                    <table class="styled-table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th style="width: 70px;">#</th>
                                            <th>الشهر</th>
                                            <th class="text-end">المبلغ</th>
                                            <th class="text-end">تاريخ الدفع</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($subscriptions as $subscription)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $subscription->month }}</td>
                                                <td class="text-end">{{ $subscription->price }}</td>
                                                <td>{{ $subscription->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 col-6 fw-bold">معلومات المشاهدة</h3>
                                </div>

                                <div class="row">
                                    <div class="styled-table col-md-12">
                                        <table class="styled-table">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th style="width: 70px;">#</th>
                                                <th>اسم الفيديو</th>
                                                <th class="text-end">وقت المشاهدة</th>
                                                <th class="text-end">مدة الفيديو</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($videos as $video)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $video->video->name_ar ?? '' }}</td>
                                                    <td class="text-end">{{ $video->created_at->format('Y-m-d') }}</td>
                                                    <td>{{ $video->minutes ?? '' . ' دقيقة ' }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <td></td>
                                            <td>المجموع :
                                                {{ $videos->count() . '  فيديو  ' }}
                                            </td>
                                            <td></td>
                                            <td>مجموع دقائق المشاهده :
                                                {{ $totalTimeFormatted }}
                                            </td>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div>
                                        <h3 class="">معلومات الانجازات</h3>
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>
                                <hr>
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 col-6 fw-bold">معلومات الامتحانات</h3>
                                </div>
                                <div class="styled-table">
                                    <table class="styled-table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th style="width: 70px;">#</th>
                                            <th>اسم الامتحان</th>
                                            <th>نوع الامتحان</th>
                                            <th>درجة الامتحان</th>
                                            <th>تاريخ الامتحان</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($exams as $exam)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $exam->online_exam->name_ar ?? $exam->all_exam->name_ar ?? $exam->life_exam->name_ar }}</td>
                                                @if($exam->online_exam_id)
                                                    <td>اونلاين</td>
                                                @elseif($exam->all_exam_id)
                                                    <td>شامل</td>
                                                @else
                                                    <td>لايف</td>
                                                @endif
                                                <td>{{ ($exam->online_exam->degree ?? $exam->all_exam->degree ?? $exam->life_exam->degree) }}
                                                    / {{ $exam->full_degree }}</td>
                                                <td>{{ $exam->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                        @endforeach
                                        @foreach($paperExams as $paper)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $paper->papel_sheet_exam->name_ar }}</td>
                                                <td>ورقي</td>
                                                <td>{{ $paper->papel_sheet_exam->degree }}
                                                    / {{ $paper->degree }}</td>
                                                <td>{{ $paper->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td> مجموع الامتحانات :</td>
                                        <td>{{ $exams->count() + $paperExams->count() }}</td>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                            <div class="d-print-none m-3">
                                <div class="float-end">
                                    <a style="color: white" onclick="printReport()"
                                       class="btn btn-success waves-effect waves-light me-1 printReport"><i
                                            class="fa fa-print"></i> طباعة </a>
                                    <a href="{{ route('users.index') }}"
                                       class="btn btn-primary w-md waves-effect waves-light">الرجوع</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>

        @include('admin.layouts_admin.myAjaxHelper')
        @endsection
        @section('ajaxCalls')
{{--            <script type="text/javascript" src="{{ asset('assets/admin/assets/js/printThis.js') }}"></script>--}}
            <script>
               function printReport(){
                   $('#cardPrint').printThis({
                       importCSS: true,            // import parent page css
                       importStyle: true,          // import style tags
                       printContainer: true,      // print html container
                       pageTitle: "تقرير الطالب",              // add title to print page
                       loadCSS: '{{ asset('assets/admin/css/custom-table.css') }}',                // path to additional css file - use an array [] for multiple
                   });
               }
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
            <script>
                var xValues = ["الدروس", "الوحدات"];
                var yValues = ['{{ $lessonCount }}','{{ $classCount }}'];
                var barColors = ["green", "blue"];

                new Chart("myChart", {
                    type: "bar",
                    data: {
                        labels: xValues,
                        datasets: [{
                            backgroundColor: barColors,
                            data: yValues
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                            display: false,
                            text: "معلومات الانجازات"
                        }
                    }
                });
            </script>

@endsection
