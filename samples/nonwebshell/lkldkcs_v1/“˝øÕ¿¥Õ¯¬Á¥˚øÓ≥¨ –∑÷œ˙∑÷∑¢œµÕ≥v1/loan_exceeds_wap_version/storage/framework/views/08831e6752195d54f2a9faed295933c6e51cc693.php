<div class="layui-inline">
    <label class="layui-form-label">部门</label>
    <div class="layui-input-block">
        <select name="department_id" id="department_id"  lay-filter="department_id">
            <option value="">不限</option>
            <?php $departments=\App\Models\Department::all();?>
            <?php if($departments->count()): ?>
                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($department->id); ?>"><?php echo e($department->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </select>
    </div>
</div>

<div class="layui-inline">
    <label class="layui-form-label">渠道</label>
    <div class="layui-input-block">
        <select name="channel_code" id="channel_code" lay-search>
            <option value="">不限</option>
        </select>
    </div>
</div>
