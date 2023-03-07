<!DOCTYPE html>
<html lang="ar">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $__env->make('admin.auth.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<div class="container">
    <main class="signup-container" style="margin-top: 40px">
        <h1 class="heading-primary">تسجيل الدخول<span class="span-blue">.</span></h1>
        <p class="text-mute">يرجي ادخال بيانات التحقق</p>

        <form class="signup-form" action="<?php echo e(route('admin.login')); ?>" method="post" id="LoginForm">
            <?php echo csrf_field(); ?>
            <label class="inp">
                <input type="email" name="email" class="input-text" placeholder="&nbsp;">
                <span class="label">البريد الإلكتروني</span>
                <span class="input-icon"><i class="fa-solid fa-envelope"></i></span>
            </label>
            <label class="inp">
                <input type="password" name="password" class="input-text" placeholder="&nbsp;" id="password">
                <span class="label">كلمة المرور</span>
                <span class="input-icon input-icon-password" data-password><i class="fa-solid fa-eye"></i></span>
            </label>
            <button class="btn btn-login" id="loginButton">تسجيل الدخول</button>
        </form>
    </main>
    <div class="welcome-container">
        <h1 class="heading-secondary"> <span class="lg"><?php echo e(($setting->title) ?? 'مرحبا بعودتك'); ?></span></h1>
        <img src="<?php echo e(asset('assets/admin/images/Banner-Big-min.gif')); ?>" alt="login" style="max-height: 400px; max-width: 400px; mix-blend-mode: multiply">
    </div>
</div>

<?php echo $__env->make('admin.auth.js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</html>
<?php /**PATH C:\laragon\www\elmazon\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>