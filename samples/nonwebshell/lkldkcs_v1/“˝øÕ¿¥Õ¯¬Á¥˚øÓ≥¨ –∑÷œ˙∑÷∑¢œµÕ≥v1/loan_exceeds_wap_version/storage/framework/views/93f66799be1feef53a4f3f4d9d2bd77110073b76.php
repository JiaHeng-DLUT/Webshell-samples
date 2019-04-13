<?php $__env->startSection('content'); ?>
    <div class="layui-card">

        <div class="layui-card-header layuiadmin-card-header-auto">

            <form action="" method="get" class="layui-form" >
                <div class="layui-btn-group layui-inline">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.user.create')): ?>
                        <a class="layui-btn layui-btn-sm" href="<?php echo e(route('admin.user.create')); ?>">添 加</a>
                    <?php endif; ?>
                </div>
                <div class="layui-inline" style="float:right;margin-right:5%;">
                    <div class="layui-inline">
                        <select name="role_id">
                            <option value="">全部角色</option>
                            <?php if($roles->count()): ?>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($role->id); ?>" <?php echo e(request('role_id','')==$role->id?'selected':''); ?>><?php echo e($role->display_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <button class="layui-btn layui-btn-normal" type="submit">搜索</button>
                </div>
            </form>

        </div>

        <div class="layui-card-body">
                <table class="layui-table" id="dataTable">
                    
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                    
                    <thead>
                    <tr>
                        
                        
                        <th>显示名称</th>
                        <th>登录用户名</th>
                        <th>角色类型</th>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.user.status')): ?>
                            <th>状态</th>
                        <?php endif; ?>
                        <th>创建时间</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($users->count()): ?>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            
                            
                            <td><?php echo e($user->name); ?></td>
                            <td><?php echo e($user->username); ?></td>
                            <td><?php echo e(implode('、',$user->roles->pluck('display_name')->all())); ?></td>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.user.status')): ?>
                                <td class="layui-form">
                                    <input type="checkbox" name="status" lay-filter="status" <?php if($user->isRoot()): ?> disabled <?php endif; ?> data-id="<?php echo e($user->id); ?>" lay-skin="switch" lay-text="启用|禁用"  value="<?php echo e($user->status); ?>"  <?php echo e($user->status == '1' ? 'checked' : ''); ?>>
                                </td>
                            <?php endif; ?>
                            <td><?php echo e($user->created_at); ?></td>
                            <td><?php echo e($user->updated_at); ?></td>
                            <td>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.user.create')): ?>
                                    <a class="layui-btn layui-btn-sm" href="<?php echo e(route('admin.user.edit',$user->id)); ?>">编辑</a>
                                <?php endif; ?>
                                
                                    
                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.user.permission')): ?>
                                    <a class="layui-btn layui-btn-sm" href="<?php echo e(route('admin.user.permission',$user->id)); ?>">权限</a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.user.destroy')): ?>
                                    <?php if(in_array('root',$user->roles->pluck('name')->all())): ?>
                                        <a class="layui-btn layui-btn-danger layui-btn-sm  layui-btn-disabled" href="javascript:;" disabled="">删除</a>
                                    <?php else: ?>
                                        <a class="layui-btn layui-btn-danger layui-btn-sm form-delete" href="javascript:;" data-url="<?php echo e(route('admin.user.destroy', $user->id)); ?>">删除</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align: center">暂无数据!</td>
                        </tr>
                        
                        
                    <?php endif; ?>
                    </tbody>

                </table>
                <form id="delete-form" action="" method="POST" style="display:none;">
                    <input type="hidden" name="_method" value="DELETE">
                    <?php echo e(csrf_field()); ?>

                </form>
                <div id="paginate-render"></div>


        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <?php echo $__env->make('admin.layouts._paginate',[ 'count' => $users->total(), ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script>
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            var form = layui.form;

            form.on('switch(status)', function(data){
                var user_id=$(data.elem).data('id');
                var status=data.value;
                $.post("<?php echo e(route('admin.user.status')); ?>",{user_id:user_id,status:status},function (res) {
                    console.log(res);
                    if(res.code===0){
                        $(data.elem).attr('value',res.status);
                        layer.msg(res.msg,{icon:1});
                    }else {
                        layer.msg(res.msg,{icon:2});
                    }
                })
            });

        })
    </script>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('admin.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>