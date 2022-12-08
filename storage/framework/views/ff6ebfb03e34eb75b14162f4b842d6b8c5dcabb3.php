

<?php $__env->startSection('meta'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    View Pre Defined Message
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">View Pre Defined Message</div>
                    </div>
                    <div class="ibox-body">
                        <form name="form" id="form" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field("PATCH"); ?>
                            <input type="hidden" name="id" value="<?php echo e($data->id); ?>">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="message">Message <span class="text-danger">*</span></label>
                                    <textarea name="message" id="message" class="form-control" placeholder="Plese enter message" disabled><?php echo e($data->message ?? ''); ?></textarea>
                                    <span class="kt-form__help error message"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <a href="<?php echo e(route('pre_defined_message')); ?>" class="btn btn-default">Back</a>
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


<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ami-enterprise\resources\views/preDefineMessage/view.blade.php ENDPATH**/ ?>