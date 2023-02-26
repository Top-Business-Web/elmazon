<meta charset="UTF-8">
<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- FAVICON -->
<link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('assets/admin/images/logo-mazon.png')); ?>" />

<!-- TITLE -->
<title><?php echo $__env->yieldContent('title'); ?></title>

<!-- BOOTSTRAP CSS -->
<link href="<?php echo e(asset('assets/admin/plugins/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet" />

<!-- STYLE CSS -->


<link href="<?php echo e(asset('assets/admin/css-rtl/style.css')); ?>" rel="stylesheet"/>
<link href="<?php echo e(asset('assets/admin/css-rtl/skin-modes.css')); ?>" rel="stylesheet"/>
<link href="<?php echo e(asset('assets/admin/css-rtl/dark-style.css')); ?>" rel="stylesheet"/>








<!-- SIDE-MENU CSS -->
<link href="<?php echo e(asset('assets/admin/css-rtl/sidemenu.css')); ?>" rel="stylesheet">

<!--PERFECT SCROLL CSS-->
<link href="<?php echo e(asset('assets/admin/plugins/p-scroll/perfect-scrollbar.css')); ?>" rel="stylesheet"/>

<!-- CUSTOM SCROLL BAR CSS-->
<link href="<?php echo e(asset('assets/admin/plugins/scroll-bar/jquery.mCustomScrollbar.css')); ?>" rel="stylesheet"/>

<!--- FONT-ICONS CSS -->
<link href="<?php echo e(asset('assets/admin/css-rtl/icons.css')); ?>" rel="stylesheet"/>

<!-- SIDEBAR CSS -->
<link href="<?php echo e(asset('assets/admin/plugins/sidebar/sidebar.css')); ?>" rel="stylesheet">

<!-- COLOR SKIN CSS --><link id="theme" rel="stylesheet" type="text/css" media="all" href="<?php echo e(asset('assets/admin/colors/color1.css')); ?>" />

<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

<!-- TOASTR CSS -->
@toastr_css

<!-- Switcher CSS -->
<link href="<?php echo e(asset('assets/admin')); ?>/switcher/css/switcher.css" rel="stylesheet">
<link href="<?php echo e(asset('assets/admin')); ?>/switcher/demo.css" rel="stylesheet">

<script defer src="<?php echo e(asset('assets/admin')); ?>/iconfonts/font-awesome/js/brands.js"></script>
<script defer src="<?php echo e(asset('assets/admin')); ?>/iconfonts/font-awesome/js/solid.js"></script>
<script defer src="<?php echo e(asset('assets/admin')); ?>/iconfonts/font-awesome/js/fontawesome.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet" />
<?php echo $__env->yieldContent('css'); ?>
<?php /**PATH C:\laragon\www\students\resources\views/admin/layouts_admin/head.blade.php ENDPATH**/ ?>