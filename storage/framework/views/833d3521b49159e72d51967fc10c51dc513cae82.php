

<?php $__env->startSection('meta'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    View Order
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(asset('assets/vendors/select2/dist/css/select2.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css')); ?>" rel="stylesheet" />

    <link href="<?php echo e(asset('assets/css/dropify.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/sweetalert2.bundle.css')); ?>" rel="stylesheet">

    <style>
        .select2-container--default .select2-selection--single{
            height: 35px;
        }

        @media  print{
            .hide{
                display: none;
            }
        }

        .table>tbody>tr>td{
            border-top: none !important;
            padding: 0.50rem;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-content fade-in-up">
        <div class="row" id="printableArea">
            <div class="col-md-12 hide" id="mainArea">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">View Order</div>
                    </div>
                    <div class="ibox-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" value="<?php echo e($data->name ?? ''); ?>" placeholder="Plese enter name" disabled />
                                <span class="kt-form__help error name"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="order_date">Order Date <span class="text-danger"></span></label>
                                <input type="date" name="order_date" id="order_date" class="form-control" value="<?php echo e($data->order_date ?? ''); ?>" placeholder="Plese enter order date" disabled />
                                <span class="kt-form__help error order_date"></span>
                            </div>
                            <div class="row" id="customer_details"></div>
                            <div class="form-group col-sm-12">
                                <label for="remark">Remark <span class="text-danger"></span></label>
                                <textarea name="remark" id="remark" cols="30" rows="5" class="form-control" placeholder="Plese enter remark" disabled><?php echo e($data->remark ?? ''); ?></textarea>
                                <span class="kt-form__help error remark"></span>
                            </div>
                            <div class="form-group col-sm-12">
                                <?php if(isset($data->file) && !empty($data->file)): ?>
                                    <?php $file = url('/uploads/orders/').'/'.$data->file; ?>
                                <?php else: ?>
                                    <?php $file = ''; ?>
                                <?php endif; ?>
                                <label for="file">Attechment <span class="text-danger"></span></label>
                                <input type="file" name="file" id="file" class="form-control dropify" placeholder="Plese select attachment" data-default-file="<?php echo e($file); ?>" data-show-remove="false" />
                                <span class="kt-form__help error file"></span>
                            </div>
                        </div>
                        <?php if(isset($data->order_details) && $data->order_details->isNotEmpty()): ?>
                            <div class="row" id="table" style="display:block">
                        <?php else: ?>
                            <div class="row" id="table" style="display:none">
                        <?php endif; ?>
                            <div class="col-sm-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:05%">Sr. No</th>
                                            <th style="width:45%">Product</th>
                                            <th style="width:15%">Quantity</th>
                                            <th style="width:15%">Price</th>
                                            <th style="width:20%">Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($data->order_details) && $data->order_details->isNotEmpty()): ?>
                                            <?php $i=1; ?>
                                            <?php $__currentLoopData = $data->order_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="clone" id="clone_<?php echo e($i); ?>">
                                                    <th style="width:05%"><?php echo e($i); ?></th>
                                                    <th style="width:45%"><?php echo e($row->product_name); ?>

                                                        <input type="hidden" name="product_id[]" id="product_<?php echo e($i); ?>" value="<?php echo e($row->product_id); ?>">
                                                    </th>
                                                    <th style="width:15%">
                                                        <input type="text" name="quantity[]" id="quantity_<?php echo e($i); ?>" value="<?php echo e($row->quantity); ?>" class="form-control digit" disabled>
                                                    </th>
                                                    <th style="width:15%">
                                                        <input type="text" name="price[]" id="price_<?php echo e($i); ?>" value="<?php echo e($row->price); ?>" class="form-control digit" disabled>
                                                    </th>
                                                    <th style="width:20%">
                                                        <textarea name="remarks[]" id="remarks_<?php echo e($i); ?>" disabled ><?php echo e($row->remark ?? ''); ?></textarea>
                                                    </th>
                                                </tr>
                                                <?php $i++; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                        <div class="form-group">
                            <a href="<?php echo e(route('orders.edit', ['id' => base64_encode($data->id)])); ?>" class="btn btn-primary hide">Edit</a>
                            <a href="<?php echo e(route('orders')); ?>" class="btn btn-default hide">Back</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12" id="subArea" style="display:none">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">View Order</div>
                    </div>
                    <div class="ibox-body">
                        <table class="table">
                            <tr>
                                <td>Name: <?php echo e($data->name ?? ''); ?></td>
                                <td>Order Date: <?php echo e($data->order_date ?? ''); ?></td>
                            </tr>
                            <tr class="mt-5">
                                <td>Billing Name: <?php echo e($customer->billing_name ?? ''); ?></td>
                            </tr>
                            <tr>
                                <td>Contact Person: <?php echo e($customer->contact_person ?? ''); ?></td>
                                <td>Mobile Number: <?php echo e($customer->mobile_number ?? ''); ?></td>
                            </tr>
                            <tr>
                                <td>Billing Address: <?php echo e($customer->billing_address ?? ''); ?></td>
                                <td>Delivery Address: <?php echo e($customer->delivery_address ?? ''); ?></td>
                            </tr>
                            <tr>
                                <td>Electrician: <?php echo e($customer->electrician ?? ''); ?></td>
                                <td>Electrician Number: <?php echo e($customer->electrician_number ?? ''); ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Remark: <br/> 
                                    <?php echo e($data->remark ?? ''); ?>

                                </td>
                            </tr>
                        </table>
                        <?php if(isset($data->order_details) && $data->order_details->isNotEmpty()): ?>
                            <div class="row" id="table" style="display:block">
                        <?php else: ?>
                            <div class="row" id="table" style="display:none">
                        <?php endif; ?>
                            <div class="col-sm-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:05%">Sr. No</th>
                                            <th style="width:45%">Product</th>
                                            <th style="width:15%">Quantity</th>
                                            <th style="width:10%">Price</th>
                                            <th style="width:25%">Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($data->order_details) && $data->order_details->isNotEmpty()): ?>
                                            <?php $i=1; ?>
                                            <?php $__currentLoopData = $data->order_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="clone" id="clone_<?php echo e($i); ?>">
                                                    <th style="width:05%"><?php echo e($i); ?></th>
                                                    <th style="width:45%"><?php echo e($row->product_name); ?></th>
                                                    <th style="width:15%"><?php echo e($row->quantity); ?></th>
                                                    <th style="width:10%"><?php echo e($row->price); ?></th>
                                                    <th style="width:25%"><?php echo e($row->remark ?? ''); ?></th>
                                                </tr>
                                                <?php $i++; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <input type="button" class="btn btn-primary" style="cursor:pointer" onclick="printDiv('printableArea')" value="Print" />
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('assets/vendors/select2/dist/js/select2.full.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/scripts/form-plugins.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/js/dropify.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/promise.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/sweetalert2.bundle.js')); ?>"></script>
    
    <script>
        $(document).ready(function () {
            $('.dropify').dropify({
                messages: {
                    'default': 'Drag and drop file here or click',
                    'remove':  'Remove',
                    'error':   'Ooops, something wrong happended.'
                }
            });
            var drEvent = $('.dropify').dropify(); 

            let exst_name = "<?php echo e($data->name ?? ''); ?>";
            
            if(exst_name != '' || exst_name != null){
                $("#customer_details").html('');
                _customer_details(exst_name);
            }

            $('#order_date').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true
            });
        });

        function _customer_details(name){
            $.ajax({
                url : "<?php echo e(route('orders.customer.details')); ?>",
                type : 'post',
                data : { "_token": "<?php echo e(csrf_token()); ?>", "name": name},
                dataType: 'json',
                async: false,
                success : function(json){
                    $("#customer_details").append(
                        '<div class="form-group col-md-6"><span style="font-weight: bold; padding-left:16px;">Billing Name: </span><span>'+json.data.billing_name+'</span></div>'+
                        '<div class="form-group col-md-6"><span style="font-weight: bold; padding-left:16px;">Contact Person: </span><span>'+json.data.contact_person+'</span></div>'+
                        '<div class="form-group col-md-6"><span style="font-weight: bold; padding-left:16px;">Mobile Number: </span><span>'+json.data.mobile_number+'</span></div>'+
                        '<div class="form-group col-md-6"><span style="font-weight: bold; padding-left:16px;">Billing Address: </span><span>'+json.data.billing_address+'</span></div>'+
                        '<div class="form-group col-md-6"><span style="font-weight: bold; padding-left:16px;">Delivery Address: </span><span>'+json.data.delivery_address+'</span></div>'+
                        '<div class="form-group col-md-6"><span style="font-weight: bold; padding-left:16px;">Electrician: </span><span>'+json.data.electrician+'</span></div>'+
                        '<div class="form-group col-md-6"><span style="font-weight: bold; padding-left:16px;">Electrician Number: </span><span>'+json.data.electrician_number+'</span></div>');
                }
            });
        }

        function printDiv(divName) {
            $('#subArea').css('display', 'block');
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
            $('#subArea').css('display', 'none');
        }
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\work\ami-enterprise\resources\views/orders/view.blade.php ENDPATH**/ ?>