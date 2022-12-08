<?php $i = 1; ?>
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($i); ?></td>
        <td><?php echo e($row->user_name); ?></td>
        <td><?php echo e($row->party_name); ?></td>
        <td><?php echo e($row->next_date); ?></td>
        <td><?php echo e($row->note); ?></td>
    </tr>
    <?php $i++; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\xampp\htdocs\ami-enterprise\resources\views/payment_reminder/report.blade.php ENDPATH**/ ?>