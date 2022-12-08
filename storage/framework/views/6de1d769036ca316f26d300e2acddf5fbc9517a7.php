

<?php $__env->startSection('meta'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    Notices Board
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        ul.pinboards li, ul.tag-list li {
            list-style: none;
        }

        ul.pinboards li h4 {
            margin-top: 20px;
            font-size: 18px;
        }
        
        ul.pinboards li div p { font-size: 16px; }
        
        ul.pinboards li div {
            text-decoration: none;
            color: #000;
            background: #ffc;
            display: block;
            height: auto;
            width: 140px;
            padding: 1em;
            position: relative;
        }

        ul.pinboards li div small {
            position: absolute;
            top: 5px;
            right: 5px;
            font-size: 10px;
        }

        ul.pinboards li div span {
            position: absolute;
            font-size: 10px;
            bottom: 5px;
            right: 5px;
        }

        ul.pinboards li div a {
            position: absolute;
            right: 10px;
            bottom: 10px;
            color: inherit;
        }
        
        ul.pinboards li {
            margin: 10px 40px 50px 0;
            float: left;
        }

        ul.pinboards li div p {
            font-size: 12px;
        }

        ul.pinboards li div {
            text-decoration: none;
            color: #000;
            background: #ffc;
            display: block;
            height: auto;
            width: 140px;
            padding: 1em;
            /* Firefox */
            -moz-box-shadow: 5px 5px 2px #212121;
            /* Safari+Chrome */
            -webkit-box-shadow: 5px 5px 2px rgba(33, 33, 33, 0.7);
            /* Opera */
            box-shadow: 5px 5px 2px rgba(33, 33, 33, 0.7);
        }

        ul.pinboards li div {
            -webkit-transform: rotate(-6deg);
            -o-transform: rotate(-6deg);
            -moz-transform: rotate(-6deg);
            -ms-transform: rotate(-6deg);
        }

        ul.pinboards li:nth-child(even) div {
            -o-transform: rotate(4deg);
            -webkit-transform: rotate(4deg);
            -moz-transform: rotate(4deg);
            -ms-transform: rotate(4deg);
            position: relative;
            top: 5px;
        }

        ul.pinboards li:nth-child(3n) div {
            -o-transform: rotate(-3deg);
            -webkit-transform: rotate(-3deg);
            -moz-transform: rotate(-3deg);
            -ms-transform: rotate(-3deg);
            position: relative;
            top: -5px;
        }

        ul.pinboards li:nth-child(5n) div {
            -o-transform: rotate(5deg);
            -webkit-transform: rotate(5deg);
            -moz-transform: rotate(5deg);
            -ms-transform: rotate(5deg);
            position: relative;
            top: -10px;
        }

        ul.pinboards li div:hover, ul.pinboards li div:focus {
            -webkit-transform: scale(1.1);
            -moz-transform: scale(1.1);
            -o-transform: scale(1.1);
            -ms-transform: scale(1.1);
            position: relative;
            z-index: 5;
        }

        ul.pinboards li div {
            text-decoration: none;
            color: #000;
            background: #ffc;
            display: block;
            height: auto;
            width: 210px;
            padding: 1em;
            -moz-box-shadow: 5px 5px 7px #212121;
            -webkit-box-shadow: 5px 5px 7px rgba(33, 33, 33, 0.7);
            box-shadow: 5px 5px 7px rgba(33, 33, 33, 0.7);
            -moz-transition: -moz-transform 0.15s linear;
            -o-transition: -o-transform 0.15s linear;
            -webkit-transition: -webkit-transform 0.15s linear;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <ul class="pinboards mt-3">
        <?php if(isset($data) && $data->isNotEmpty()): ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <div>
                        <small><?php echo e($row->created_at); ?></small>
                        <h4><?php echo e($row->title); ?></h4>
                        <p style="word-wrap: break-word;"><?php echo e($row->description); ?></p>
                        <span><?php echo e(auth()->user()->name); ?></span>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <div class="page-content fade-in-up">
            <div class="row">
                <div class="col-md-12">
                    <div class="ibox">
                        <div class="ibox-body">
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <h3>No Notices Found...!!!</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </ul> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ami-enterprise\resources\views/notices/board.blade.php ENDPATH**/ ?>