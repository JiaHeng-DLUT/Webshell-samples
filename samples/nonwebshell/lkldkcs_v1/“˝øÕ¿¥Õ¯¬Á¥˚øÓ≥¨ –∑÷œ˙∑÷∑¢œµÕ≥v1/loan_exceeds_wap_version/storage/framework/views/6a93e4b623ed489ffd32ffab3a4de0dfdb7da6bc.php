<?php $__env->startSection('content'); ?>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新权限</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="<?php echo e(route('admin.permission.update',['permission'=>$permission])); ?>" method="post">
                <?php echo e(method_field('put')); ?>

                <input type="hidden" name="id" value="<?php echo e($permission->id); ?>">
                <?php echo $__env->make('admin.permission._from', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <?php echo $__env->make('admin.permission._js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>