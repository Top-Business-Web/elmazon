<!-- DATATABLE CSS -->
<link href="<?php echo e(asset('assets/admin')); ?>/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="<?php echo e(asset('assets/admin')); ?>/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
<link href="<?php echo e(asset('assets/admin')); ?>/plugins/datatable/fileexport/buttons.bootstrap4.min.css" rel="stylesheet" />

<!-- JQUERY JS -->
<script src="<?php echo e(asset('assets/admin')); ?>/js/jquery-3.4.1.min.js"></script>

<!-- DATATABLE JS -->
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/datatable/datatable.js"></script>
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/datatable/dataTables.responsive.min.js"></script>
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/datatable/fileexport/dataTables.buttons.min.js"></script>
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/datatable/fileexport/buttons.bootstrap4.min.js"></script>
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/datatable/fileexport/jszip.min.js"></script>
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/datatable/fileexport/pdfmake.min.js"></script>
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/datatable/fileexport/vfs_fonts.js"></script>
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/datatable/fileexport/buttons.html5.min.js"></script>
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/datatable/fileexport/buttons.print.min.js"></script>
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/datatable/fileexport/buttons.colVis.min.js"></script>


<!-- BOOTSTRAP JS -->
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/bootstrap/js/popper.min.js"></script>

<!-- SPARKLINE JS-->
<script src="<?php echo e(asset('assets/admin')); ?>/js/jquery.sparkline.min.js"></script>

<!-- CHART-CIRCLE JS-->
<script src="<?php echo e(asset('assets/admin')); ?>/js/circle-progress.min.js"></script>

<!-- RATING STARJS -->
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/rating/jquery.rating-stars.js"></script>

<!-- EVA-ICONS JS -->
<script src="<?php echo e(asset('assets/admin')); ?>/iconfonts/eva.min.js"></script>

<!-- INPUT MASK JS-->
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/input-mask/jquery.mask.min.js"></script>

<!-- SIDE-MENU JS-->
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/sidemenu/sidemenu.js"></script>


<script src="<?php echo e(asset('assets/admin')); ?>/plugins/p-scroll/perfect-scrollbar.min.js"></script>
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/sidemenu/sidemenu-scroll.js"></script>

<!-- CUSTOM SCROLLBAR JS-->
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- SIDEBAR JS -->
<script src="<?php echo e(asset('assets/admin')); ?>/plugins/sidebar/sidebar.js"></script>
<script src="<?php echo e(asset('assets/admin/js/toastr.js')); ?>"></script>

<!-- CUSTOM JS -->
<script src="<?php echo e(asset('assets/admin')); ?>/js/custom.js"></script>

<!-- Switcher JS -->
<script src="<?php echo e(asset('assets/admin')); ?>/switcher/js/switcher.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>











<script>

    function playAudio() {
        var x = new Audio('<?php echo e(asset('sound/eventually-590.ogg')); ?>');
        // Show loading animation.
        var playPromise = x.play();

        if (playPromise !== undefined) {
            playPromise.then(_ => {
                x.play();
            })
                .catch(error => {
                });

        }
    }


    $('.logoutAdmin').on('click', function(){
        $.ajax({
            url: '<?php echo e(route('admin.logout')); ?>',
            success: function(data){
                if(data === 200){
                    toastr.info('تم تسجيل الخروج بنجاح');
                    window.setTimeout(function () {
                        window.location.href = '/admin';
                    }, 1000);
                    playAudio();
                }
            }
        })
    })
</script>
<?php echo $__env->yieldContent('js'); ?>
<?php /**PATH C:\laragon\www\elmazon\resources\views/admin/layouts_admin/scripts.blade.php ENDPATH**/ ?>