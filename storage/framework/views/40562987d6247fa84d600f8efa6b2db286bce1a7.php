

<?php $__env->startSection('meta'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    Create Task
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(asset('assets/css/dropify.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/sweetalert2.bundle.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/select2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Create Task</div>
                    </div>
                    <div class="ibox-body">
                        <form name="form" action="<?php echo e(route('tasks.insert')); ?>" id="form" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="type">Type <span class="text-danger">*</span></label>
                                    <select name="type" id="type" id="type" class="form-control select2_tag" placeholder="Plese select type">
                                        <option value="" hidden>Select type</option>
                                        <option value="order" <?php if(@old('type') == 'order'): ?> selected <?php endif; ?>>Order</option>
                                        <option value="site_visit" <?php if(@old('type') == 'site_visit'): ?> selected <?php endif; ?>>Site Visit</option>
                                        <option value="payment" <?php if(@old('type') == 'payment'): ?> selected <?php endif; ?>>Payment</option>
                                    </select>
                                    <span class="kt-form__help error type"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div id="customer_div">
                                        <label for="customer_id">Customer <span class="text-danger"></span></label>
                                        <select name="customer_id" class="form-control" placeholder="Plese select customer" id="customer_id" >
                                            <option value="" hidden>Select customer</option>
                                            <?php if(isset($customers) && !empty($customers)): ?>
                                                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($row->party_name); ?>"><?php echo e($row->party_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                        <span class="kt-form__help error customer_id"></span>
                                    </div>
                                </div>
                                <div class="row" id="details"></div>
                                <div class="form-group col-sm-6">
                                    <label for="users">Allocate To <span class="text-danger">*</span></label>
                                    <select name="users[]" class="form-control select2_tag" placeholder="Plese select users" id="users" multiple>
                                        <?php if(isset($users) && !empty($users)): ?>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                    <span class="kt-form__help error users"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="description">Instruction <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" class="form-control" placeholder="Plese enter Instruction"><?php echo e(@old('description')); ?></textarea>
                                    <span class="kt-form__help error description"></span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="t_date">Taget Date <span class="text-danger">*</span></label>
                                    <input type="date" name="t_date" id="t_date" class="form-control" placeholder="Plese enter target date" min="<?php echo e(Date('Y-m-d')); ?>" value="<?php echo e(@old('t_date')); ?>" />
                                    <span class="kt-form__help error t_date"></span>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="file">Attechment <span class="text-danger">*</span></label>
                                    <input type="file" name="file" id="file" class="form-control dropify" placeholder="Plese select attachment" />
                                    <span class="kt-form__help error file"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="<?php echo e(route('tasks')); ?>" class="btn btn-default">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/dropify.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/promise.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/sweetalert2.bundle.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/select2.min.js')); ?>"></script>
    
    <script>
        let type = '';

        $(document).ready(function(){
            $('.dropify').dropify({
                messages: {
                    'default': 'Drag and drop file here or click',
                    'remove':  'Remove',
                    'error':   'Ooops, something wrong happended.'
                }
            });
            var drEvent = $('.dropify').dropify();        

            $('#users').select2({
                placeholder:"Plase select user"
            });

            $('#customer_id').select2({
                placeholder:"Plase select customer"
            });

            $(".select2_tag").select2({
                tags: true
            });

            $('#type').change(function(){
                type = $(this).val();
                if(type == 'order' || type == 'payment' || type == 'site_visit'){
                    $('#customer_div').show();
                } else {
                    $('#customer_div').hide();
                }
            });

            $('#customer_div').hide();

            $('#customer_id').change(function () {
                var name = $(this).val();
                if(name != '' || name != null){
                    $("#details").html('');
                    _customer_details(name);
                }
            });

            function _customer_details(name){
                $.ajax({
                    url : "<?php echo e(route('tasks.customer.details')); ?>",
                    type : 'post',
                    data : { "_token": "<?php echo e(csrf_token()); ?>", "name": name, 'type': type},
                    dataType: 'json',
                    async: false,
                    success : function(response){
                        if(response.code == 200){
                            $("#details").html(response.data);
                        }
                    }
                });
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            var form = $('#form');
            $('.kt-form__help').html('');
            form.submit(function(e) {
                $('.help-block').html('');
                $('.m-form__help').html('');
                $.ajax({
                    url : form.attr('action'),
                    type : form.attr('method'),
                    data : form.serialize(),
                    dataType: 'json',
                    async:false,
                    success : function(json){
                        return true;
                    },
                    error: function(json){
                        if(json.status === 422) {
                            e.preventDefault();
                            var errors_ = json.responseJSON;
                            $('.kt-form__help').html('');
                            $.each(errors_.errors, function (key, value) {
                                $('.'+key).html(value);
                            });
                        }
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\work\ami-enterprise\resources\views/tasks/create.blade.php ENDPATH**/ ?>