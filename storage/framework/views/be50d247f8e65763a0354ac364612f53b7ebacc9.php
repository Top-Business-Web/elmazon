<!doctype html>
<html lang="en" dir="ltr">

<head>
    <?php echo $__env->make('admin.layouts_admin.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <style>


    </style>
</head>

<body class="app sidebar-mini">

<!-- Start Switcher -->
<?php echo $__env->make('admin.layouts_admin.switcher', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- End Switcher -->

<!-- GLOBAL-LOADER -->
<?php echo $__env->make('admin.layouts_admin.loader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- /GLOBAL-LOADER -->

<!-- PAGE -->
<div class="page">
    <div class="page-main">
        <!--APP-SIDEBAR-->
    <?php echo $__env->make('admin.layouts_admin.main-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!--/APP-SIDEBAR-->

        <!-- Header -->
    <?php echo $__env->make('admin.layouts_admin.main-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Header -->
        <!--Content-area open-->
        <div class="app-content">
            <div class="side-app">

                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <div>
                        <h1 class="page-title">مرحبا بعودتك <i class="fas fa-heart text-danger"></i></h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('adminHome')); ?>">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $__env->yieldContent('page_name'); ?></li>
                        </ol>
                    </div>
                </div>
                <!-- PAGE-HEADER END -->
                <?php echo $__env->yieldContent('content'); ?>
            </div>
            <!-- End Page -->
        </div>
        <!-- CONTAINER END -->
    </div>
    <!-- SIDE-BAR -->

    <!-- FOOTER -->
<?php echo $__env->make('admin.layouts_admin.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- FOOTER END -->
</div>
<!-- BACK-TO-TOP -->
<a href="#top" id="back-to-top"><i class="fa fa-angle-up mt-4"></i></a>

<?php echo $__env->make('admin.layouts_admin.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('ajaxCalls'); ?>
@toastr_js
@toastr_render
</body>
</html>
<?php /**PATH C:\laragon\www\students\resources\views/Admin/layouts_admin/master.blade.php ENDPATH**/ ?>