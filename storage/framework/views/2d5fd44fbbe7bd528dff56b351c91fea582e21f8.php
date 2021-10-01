

<?php $__env->startSection('meta'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    Upload new data - Payment
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Upload new data - Payment</div>
                    </div>
                    <div class="ibox-body">
                        <form name="form" action="<?php echo e(route('payment.import')); ?>" id="form" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="file">File <span class="text-danger">*</span></label>
                                    <input type="file" name="file" id="file" class="form-control" placeholder="Plese select file" />
                                    <span class="kt-form__help error file"></span>
                                    <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong><?php echo e($message); ?></strong>
                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-default">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\work\ami-enterprise\resources\views/payment/import.blade.php ENDPATH**/ ?>