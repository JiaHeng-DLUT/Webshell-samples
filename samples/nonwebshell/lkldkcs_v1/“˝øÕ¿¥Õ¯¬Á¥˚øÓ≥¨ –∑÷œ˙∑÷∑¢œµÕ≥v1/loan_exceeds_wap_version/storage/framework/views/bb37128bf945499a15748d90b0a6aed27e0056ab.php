<?php echo e(csrf_field()); ?>

<input type="hidden" name="previous_url" value="<?php echo e(url()->previous()); ?>">

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>父级</label>
    <div class="layui-input-block">
        <select name="parent_id" lay-search>
            <option value="0">顶级权限</option>
            <?php $__empty_1 = true; $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <option value="<?php echo e($perm['id']); ?>" <?php echo e(isset($permission->id) && $perm['id'] == $permission->parent_id ? 'selected' : ''); ?> ><?php echo e($perm['display_name']); ?></option>
                <?php if(isset($perm['_child'])): ?>
                    <?php $__currentLoopData = $perm['_child']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($childs['id']); ?>" <?php echo e(isset($permission->id) && $childs['id'] == $permission->parent_id ? 'selected' : ''); ?> >&nbsp;&nbsp;┗━━<?php echo e($childs['display_name']); ?></option>
                        <?php if(isset($childs['_child'])): ?>
                            <?php $__currentLoopData = $childs['_child']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lastChilds): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($lastChilds['id']); ?>" <?php echo e(isset($permission->id) && $lastChilds['id'] == $permission->parent_id ? 'selected' : ''); ?> >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;┗━━<?php echo e($lastChilds['display_name']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" value="<?php echo e($permission->name??old('name')); ?>" lay-verify="required" class="layui-input" placeholder="如：system.index">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>显示名称</label>
    <div class="layui-input-block">
        <input type="text" name="display_name" value="<?php echo e($permission->display_name??old('display_name')); ?>" lay-verify="required" class="layui-input" placeholder="如：系统管理">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">路由</label>
    <div class="layui-input-block">
        <input class="layui-input" type="text" name="route" value="<?php echo e($permission->route??old('route')); ?>" placeholder="如：admin.member" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">图标</label>
    <div class="layui-input-inline">
        <input class="layui-input" type="hidden" name="icon_id" value="<?php echo e($permission->icon_id??old('icon_id')); ?>">
    </div>
    <div class="layui-form-mid layui-word-aux" id="icon_box">
        <i class="layui-icon <?php echo e($permission->icon->class??''); ?>"></i> <?php echo e($permission->icon->name??''); ?>

    </div>
    <div class="layui-form-mid layui-word-aux">
        <button type="button" class="layui-btn layui-btn-xs" onclick="showIconsBox()">选择图标</button>
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" >确 认</button>
        <a href="<?php echo e(route('admin.permission')); ?>" class="layui-btn"  >返 回</a>
    </div>
</div>

