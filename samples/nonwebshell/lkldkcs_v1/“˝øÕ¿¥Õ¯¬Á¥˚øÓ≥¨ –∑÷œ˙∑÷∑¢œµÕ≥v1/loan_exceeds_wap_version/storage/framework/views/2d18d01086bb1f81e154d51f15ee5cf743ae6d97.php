<?php $__env->startSection('content'); ?>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">

            <form action="" method="get" class="layui-form" >
                <div class="layui-btn-group layui-inline">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.permission.create')): ?>
                        <a class="layui-btn layui-btn-sm" href="<?php echo e(route('admin.permission.create')); ?>">添 加</a>
                    <?php endif; ?>
                    <?php if(request('parent_id')): ?>
                        <a class="layui-btn layui-btn-sm" id="returnParent" pid="0" href="javascript:history.back()">返回上级</a>
                    <?php endif; ?>
                </div>
                <div class="layui-inline" style="float:right;margin-right:5%;">
                    <div class="layui-inline">
                        <input class="layui-input" name="keyword" value="<?php echo e(request('keyword','')); ?>" autocomplete="off" placeholder="输入权限进行搜索">
                    </div>
                    <button class="layui-btn layui-btn-normal" type="submit">搜索</button>
                </div>
            </form>
        </div>

        <div class="layui-card-body">
            <?php if($permissions->count()): ?>
                <form name="form-article-list" id="form-article-list" class="layui-form layui-form-pane" >
                    <table class="layui-table">
                        <colgroup>
                            
                            
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col width="200">
                        </colgroup>
                        <thead>
                        <tr>
                            
                            
                            <th>权限标识</th>
                            <th>展示名称</th>
                            <th>路由</th>
                            <th>图标</th>
                            <th>排序值</th>
                            <th>创建时间</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    
                                    
                                    <td><?php echo e($permission->name); ?></td>
                                    <td><?php echo e($permission->display_name); ?></td>
                                    <td><?php echo e($permission->route); ?></td>
                                    <td>
                                        <i class="layui-icon <?php echo e($permission->icon?$permission->icon->class:''); ?>"></i>
                                    </td>
                                    <td>
                                        <input type="tel" maxlength="3"  class="sort" value="<?php echo e($permission->sort); ?>" data-id="<?php echo e($permission->id); ?>" style="border: none;height: 40px;width: 50px">
                                    </td>
                                    <td><?php echo e($permission->created_at); ?></td>
                                    <td><?php echo e($permission->updated_at); ?></td>
                                    <td>
                                        <div class="layui-btn-group">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.permission')): ?>
                                                <a class="layui-btn layui-btn-sm" href="<?php echo e(url('admin/permission')); ?>?parent_id=<?php echo e($permission->id); ?>">子权限</a>
                                            <?php endif; ?>
                                            
                                                <a class="layui-btn layui-btn-sm" href="<?php echo e(url("admin/permission/$permission->id/edit")); ?>">编辑</a>
                                            
                                            
                                                
                                            real_informations
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </form>
                <div id="paginate-render"></div>
            <?php else: ?>
                <br />
                <blockquote class="layui-elem-quote">暂无数据!</blockquote>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <?php echo $__env->make('admin.layouts._paginate',[ 'count' => $permissions->total() ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script>
        $('body').find('.sort').on('blur',function () {
            var id=$(this).data('id');
            var sort=$(this).val();
            var _token="<?php echo e(csrf_token()); ?>";
            $.post('/admin/permission/sort',{'_token':_token,'id':id,'sort':sort},function (res) {
                if(res.code===1){
                    layer.msg(res.msg);
                }
            })
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>