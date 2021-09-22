

<?php $__env->startSection('meta'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    Forget Password
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content mt-5">
        <div class="brand">
            <!-- <a class="link" href="javascript:void(0);"><?php echo e(_site_title()); ?></a> -->
            <a class="link" href="<?php echo e(route('dashboard')); ?>">
                <img src="<?php echo e(asset('logo.png')); ?>" alt="<?php echo e(_site_title()); ?>" style="width: 150px; height: 150px;">
            </a>
        </div>
        <form id="forgot-form" action="<?php echo e(route('password.forget')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <h3 class="m-t-10 m-b-10">Forgot password</h3>
            <p class="m-b-20">Enter your email address below and we'll send you password reset instructions.</p>
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="Email" autocomplete="off">
            </div>
            <div class="form-group">
                <button class="btn btn-info btn-block" type="submit">Submit</button>
                <p class="mt-2 mb-3 text-center">- OR -</p>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-info btn-block">Login</a>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        $(function() {
            $('#forgot-form').validate({
                errorClass: "help-block",
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                },
                highlight: function(e) {
                    $(e).closest(".form-group").addClass("has-error")
                },
                unhighlight: function(e) {
                    $(e).closest(".form-group").removeClass("has-error")
                },
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\work\ami-enterprise\resources\views/auth/forget-password.blade.php ENDPATH**/ ?>