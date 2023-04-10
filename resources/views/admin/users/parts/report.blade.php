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
                        <div class="card" id="cardPrint">
                            <div class="card-body">
                                <div class="invoice-title">
                                    <h4 class="float-end font-size-16">{{ ' اسم الطالب : ' . $user->name }}</h4>
                                    <h5 class="float-end font-size-16">الصف الدراسي : </h5>
                                </div>
                                <hr>
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 fw-bold">المعلومات</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-nowrap">
                                        <thead>
                                        <tr>
                                            <th style="width: 70px;">No.</th>
                                            <th>Item</th>
                                            <th class="text-end">Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>01</td>
                                            <td>Skote - Admin Dashboard Template</td>
                                            <td class="text-end">$499.00</td>
                                        </tr>

                                        <tr>
                                            <td>02</td>
                                            <td>Skote - Landing Template</td>
                                            <td class="text-end">$399.00</td>
                                        </tr>

                                        <tr>
                                            <td>03</td>
                                            <td>Veltrix - Admin Dashboard Template</td>
                                            <td class="text-end">$499.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-end">Sub Total</td>
                                            <td class="text-end">$1397.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="border-0 text-end">
                                                <strong>Shipping</strong></td>
                                            <td class="border-0 text-end">$13.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="border-0 text-end">
                                                <strong>Total</strong></td>
                                            <td class="border-0 text-end"><h4 class="m-0">$1410.00</h4></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-print-none">
                                    <div class="float-end">
                                        <a style="color: white" onclick="printData()" class="btn btn-success waves-effect waves-light me-1 printReport"><i class="fa fa-print"></i> طباعة </a>
                                        <a href="{{ route('users.index') }}" class="btn btn-primary w-md waves-effect waves-light">الرجوع</a>
                                    </div>
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
    <script>
        // $('.printReport').on('click', function(e){
        //     e.preventDefault();
        //     window.printThis()
        // })

        function printData()
        {
            var divToPrint=document.getElementById("cardPrint");
            newWin= window.open();
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }

        // $('button').on('click',function(){
        //     printData();
        // })
    </script>
@endsection

