<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">
        <div class="admin-block d-flex">
            <div>
                <img src="<?php echo e(asset('assets/img/admin-avatar.png')); ?>" width="45px" />
            </div>
            <div class="admin-info">
                <div class="font-strong"><?php echo e(auth()->user()->name ?? ''); ?></div>
                <small>
                        User
                </small>
            </div>
        </div>
        
    </div>
</nav><?php /**PATH C:\xampp\htdocs\hotfocus\resources\views/layout/sidebar.blade.php ENDPATH**/ ?>