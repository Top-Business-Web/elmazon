<meta charset="UTF-8">
<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- FAVICON -->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/admin/images/logo-mazon.png') }}" />

<!-- TITLE -->
<title>@yield('title')</title>

<!-- BOOTSTRAP CSS -->
<link href="{{asset('assets/admin/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>


<!-- STYLE CSS -->

{{--start style css-- rtl--}}
<link href="{{asset('assets/admin/css-rtl/style.css')}}" rel="stylesheet"/>
<link href="{{asset('assets/admin/css-rtl/skin-modes.css')}}" rel="stylesheet"/>
<link href="{{asset('assets/admin/css-rtl/dark-style.css')}}" rel="stylesheet"/>

{{--end style css-- ltr--}}

{{--<link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet"/>--}}
{{--<link href="{{asset('assets/admin/css/skin-modes.css')}}" rel="stylesheet"/>--}}
{{--<link href="{{asset('assets/admin/css/dark-style.css')}}" rel="stylesheet"/>--}}


<!-- SIDE-MENU CSS -->
<link href="{{asset('assets/admin/css-rtl/sidemenu.css')}}" rel="stylesheet">

<!--PERFECT SCROLL CSS-->
<link href="{{asset('assets/admin/plugins/p-scroll/perfect-scrollbar.css')}}" rel="stylesheet"/>

<!-- CUSTOM SCROLL BAR CSS-->
<link href="{{asset('assets/admin/plugins/scroll-bar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>

<!--- FONT-ICONS CSS -->
<link href="{{asset('assets/admin/css-rtl/icons.css')}}" rel="stylesheet"/>

<!-- SIDEBAR CSS -->
<link href="{{asset('assets/admin/plugins/sidebar/sidebar.css')}}" rel="stylesheet">

<!-- COLOR SKIN CSS --><link id="theme" rel="stylesheet" type="text/css" media="all" href="{{asset('assets/admin/colors/color1.css')}}" />

<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

<!-- TOASTR CSS -->
@toastr_css

<!-- Switcher CSS -->
<link href="{{asset('assets/admin')}}/switcher/css/switcher.css" rel="stylesheet">
<link href="{{asset('assets/admin')}}/switcher/demo.css" rel="stylesheet">

<script defer src="{{asset('assets/admin')}}/iconfonts/font-awesome/js/brands.js"></script>
<script defer src="{{asset('assets/admin')}}/iconfonts/font-awesome/js/solid.js"></script>
<script defer src="{{asset('assets/admin')}}/iconfonts/font-awesome/js/fontawesome.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet" />
@yield('css')
