

<?php $__env->startSection('meta'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    Orders select customer
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <h1 class="ibox-title">Orders select customer</h1>
                    </div>
                    <div class="ibox-body">
                        <div class="row mt-5">
                            <div class="col-lg-3 col-md-6"></div>
                            <div class="col-lg-3 col-md-6">
                                <a href="<?php echo e(route('orders.create')); ?>"> 
                                    <div class="ibox bg-info color-white widget-stat">
                                        <div class="ibox-body p-5 text-center">
                                            <h2 class="m-b-5 font-strong text-white">Old Customers</h2>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="<?php echo e(route('customers.create')); ?>"> 
                                    <div class="ibox bg-warning color-white widget-stat">
                                        <div class="ibox-body p-5 text-center">
                                            <h2 class="m-b-5 font-strong text-white">New Customer</h2>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ami-enterprise\resources\views/orders/select_customer.blade.php ENDPATH**/ ?>