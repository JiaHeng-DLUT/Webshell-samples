<?php echo e(csrf_field()); ?>



<!-- 首先引入css, 和js, 唯一依赖: jQuery -->
<link href="/static/admin/layuiadmin/layui/dist/formSelects-v4.css" rel="stylesheet" />
<script src="/static/admin/layuiadmin/layui/dist/jquery.min.js"></script>
<script src="/static/admin/layuiadmin/layui/dist/formSelects-v4.min.js"></script>

<input type="hidden" name="id" value="<?php echo e($user_model->id??old('id')); ?>">
<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>模型名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" id="my_name" maxlength="10"  value="<?php echo e($user_model->name??old('name')); ?>" lay-verify="my_name" placeholder="请输入模型名称 1~10个汉字" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">注册时间</label>
    <div class="layui-input-block" >
        <input type="radio" name="register_at_type"  lay-filter="register_at_type" value="0" title="不限"  <?php if(isset($user_model->register_at_type) && $user_model->register_at_type == 0): ?> checked <?php endif; ?> <?php if(old('register_at_type')==0): ?> checked <?php endif; ?> checked>
        <input type="radio" name="register_at_type"  lay-filter="register_at_type" value="1" title="绝对时间"  <?php if(isset($user_model->register_at_type) && $user_model->register_at_type == 1): ?> checked <?php endif; ?> <?php if(old('register_at_type')==1): ?> checked <?php endif; ?> >
        <input type="radio" name="register_at_type"  lay-filter="register_at_type" value="2" title="相对时间"  <?php if(isset($user_model->register_at_type) && $user_model->register_at_type == 2): ?> checked <?php endif; ?> <?php if(old('register_at_type')==2): ?> checked <?php endif; ?>>
    </div>
    <div class="form-group my_status" id="register_abstract"   <?php if(isset($user_model) && $user_model->register_at_type == 1 ): ?> style="display: block" <?php endif; ?> <?php if(old('register_at_type') ==1): ?> style="display: block" <?php endif; ?>>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" placeholder="开始时间" lay-verify="register_at_abstract_start" name="register_at_abstract_start" id="register_at_abstract_start" value="<?php echo e($user_model->register_at_abstract_start??old('register_at_abstract_start') ? $user_model->register_at_abstract_start??old('register_at_abstract_start'): null); ?>" autocomplete="off">
        </div>
        <span class="layui-input-inline time"> <= 注册时间 <= </span>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" placeholder="结束时间" lay-verify="register_at_abstract_end" name="register_at_abstract_end" id="register_at_abstract_end" value="<?php echo e($user_model->register_at_abstract_end??old('register_at_abstract_end')?$user_model->register_at_abstract_end??old('register_at_abstract_end'):null); ?>" autocomplete="off">
        </div>
    </div>
    <div class="form-group my_status" id="register_relative" <?php if(isset($user_model) && $user_model->register_at_type == 2 ): ?> style="display: block" <?php endif; ?> <?php if(old('register_at_type') ==2 ): ?> style="display: block" <?php endif; ?>>
        <div class="layui-input-inline">
        <input type="number" min="0" name="register_at_relative_num" id="register_at_relative_num"  value="<?php echo e($user_model->register_at_relative_num??old('register_at_relative_num')? $user_model->register_at_relative_num??old('register_at_relative_num') :null); ?>" lay-verify="register_at_relative_num"  class="layui-input" size="300">
        </div>
        <div class="layui-input-inline">
            <select name="register_at_relative_unit" lay-verify="register_at_relative_unit">
                <option value="day" <?php if(isset($user_model->register_at_relative_unit) && $user_model->register_at_relative_unit == 'day'): ?> selected <?php endif; ?> <?php if(old('register_at_relative_unit')=='day'): ?> selected <?php endif; ?>>天</option>
                <option value="week" <?php if(isset($user_model->register_at_relative_unit) && $user_model->register_at_relative_unit == 'week'): ?> selected <?php endif; ?> <?php if(old('register_at_relative_unit')=='week'): ?> selected <?php endif; ?>>周</option>
                <option value="month" <?php if(isset($user_model->register_at_relative_unit) && $user_model->register_at_relative_unit == 'month'): ?> selected <?php endif; ?> <?php if(old('register_at_relative_unit')=='month'): ?> selected <?php endif; ?>>月</option>
                <option value="year" <?php if(isset($user_model->register_at_relative_unit) && $user_model->register_at_relative_unit == 'year'): ?> selected <?php endif; ?> <?php if(old('register_at_relative_unit')=='year'): ?> selected <?php endif; ?>>年</option>
            </select>
        </div>
        <div class="layui-input-inline">
            <select name="register_at_relative_type" lay-verify="register_at_relative_type">
                <option value="1" <?php if(isset($user_model->register_at_relative_type) && $user_model->register_at_relative_type == '1'): ?> selected <?php endif; ?>  <?php if(old('register_at_relative_type')=='1'): ?> selected <?php endif; ?>>以前</option>
                <option value="2" <?php if(isset($user_model->register_at_relative_type) && $user_model->register_at_relative_type == '2'): ?> selected <?php endif; ?>  <?php if(old('register_at_relative_type')=='2'): ?> selected <?php endif; ?>>以内</option>
            </select>
        </div>
    </div>
</div>




<div class="layui-form-item">
    <label class="layui-form-label">注册来源渠道名称</label>
    <div class="layui-input-block">
        <select name="register_channels[]" xm-select="select1">

            <?php if(count($channels)): ?>


                    <?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option
                                <?php if(isset($user_model) && in_array($channel->channel_code,$user_model->register_channels)): ?> selected  <?php endif; ?>
                                <?php if(old('register_channels') && in_array($channel->channel_code, explode(',',old('register_channels')[0]))): ?> selected  <?php endif; ?>
                        value="<?php echo e($channel->channel_code); ?>"><?php echo e($channel->channel_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php endif; ?>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">注册平台</label>
    <div class="layui-input-block">
        <select name="register_platforms[]" xm-select="select2">
            <option <?php if(isset($user_model) && in_array('android',$user_model->register_platforms)): ?> selected  <?php endif; ?> <?php if(old('register_platforms') && in_array('android', explode(',',old('register_platforms')[0]))): ?> selected = "selected" <?php endif; ?> value="android">android</option>
            <option <?php if(isset($user_model) && in_array('ios',$user_model->register_platforms)): ?> selected  <?php endif; ?> <?php if(old('register_platforms') && in_array('ios', explode(',',old('register_platforms')[0]))): ?> selected = "selected" <?php endif; ?> value="ios">ios</option>
            <option <?php if(isset($user_model) && in_array('pc',$user_model->register_platforms)): ?> selected  <?php endif; ?> <?php if(old('register_platforms') && in_array('pc', explode(',',old('register_platforms')[0]))): ?> selected = "selected" <?php endif; ?> value="pc">pc</option>
            <option <?php if(isset($user_model) && in_array('wap',$user_model->register_platforms)): ?> selected  <?php endif; ?> <?php if(old('register_platforms') && in_array('wap', explode(',',old('register_platforms')[0]))): ?> selected = "selected" <?php endif; ?> value="wap">wap</option>

        </select>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">累计登录天数</label>
        <div class="layui-input-inline">
            <input type="number" min="0" max="9999" name="all_login_day_start"    placeholder="" autocomplete="off" class="layui-input" value="<?php echo e($user_model->all_login_day_start??old('all_login_day_start')); ?>" size="300">

        </div>
        <span class="layui-input-inline time"> <= 累计登录天数 <= </span>
        <div class="layui-input-inline">
            <input type="number" min="0" max="9999" name="all_login_day_end"    placeholder="" autocomplete="off" class="layui-input" value="<?php echo e($user_model->all_login_day_end??old('all_login_day_end')); ?>" size="300">
        </div>
    </div>


<div class="layui-form-item">
    <label class="layui-form-label">累计产品申请数</label>
    <div class="layui-input-inline">
        <input type="number" name="all_apply_num_start" min="0" max="9999" id="all_apply_num_start"  value="<?php echo e($user_model->all_apply_num_start??old('all_apply_num_start')); ?>" lay-verify="all_apply_num_start"  class="layui-input" size="300">
    </div>
    <span class="layui-input-inline time"> <= 累计产品申请数 <= </span>
    <div class="layui-input-inline">
        <input type="number" name="all_apply_num_end" min="0" max="9999" id="all_apply_num_end"  value="<?php echo e($user_model->all_apply_num_end??old('all_apply_num_end')); ?>" lay-verify="all_apply_num_end"  class="layui-input" size="300">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">申请过产品</label>
    <div class="layui-input-block">
        <select name="apply_loans[]" xm-select="select3">
            <?php if(count($products)): ?>
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option
                            <?php if(isset($user_model) && in_array($product->id,$user_model->apply_loans)): ?> selected  <?php endif; ?>
                            <?php if(old('apply_loans') && in_array($product->id, old('apply_loans'))): ?> selected = "selected" <?php endif; ?> value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">未申请过产品</label>
    <div class="layui-input-block">
        <select name="not_apply_loans[]" xm-select="select4">
            <?php if(count($products)): ?>
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <option
                            <?php if(isset($user_model) && in_array($product->id,$user_model->apply_loans)): ?> selected  <?php endif; ?>
                            <?php if(old('not_apply_loans') && in_array($product->id, explode(',',old('not_apply_loans')[0]))): ?> selected = "selected" <?php endif; ?> value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

        </select>
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label">最后活跃时间</label>
    <div class="layui-input-block" >

        <input type="radio" name="last_active_at_type" lay-filter="last_active_at_type"  value="0" title="不限"  <?php if(isset($user_model->last_active_at_type) && $user_model->last_active_at_type == 0): ?> checked <?php endif; ?> <?php if(old('last_active_at_type')==0): ?> checked <?php endif; ?> checked>
        <input type="radio" name="last_active_at_type" lay-filter="last_active_at_type" value="1" title="绝对时间"  <?php if(isset($user_model->last_active_at_type) && $user_model->last_active_at_type == 1): ?> checked <?php endif; ?> <?php if(old('last_active_at_type')==1): ?> checked <?php endif; ?>>
        <input type="radio" name="last_active_at_type" lay-filter="last_active_at_type" value="2" title="相对时间"  <?php if(isset($user_model->last_active_at_type) && $user_model->last_active_at_type == 2): ?> checked <?php endif; ?> <?php if(old('last_active_at_type')==2): ?> checked <?php endif; ?>>
    </div>
    <div class="form-group my_status" id="last_active_at_abstract" <?php if(isset($user_model) && $user_model->last_active_at_type == 1 ): ?> style="display: block" <?php endif; ?> <?php if(old('last_active_at_type')==1): ?> style="display: block" <?php endif; ?>>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" placeholder="开始时间" lay-verify="last_active_at_abstract_start" name="last_active_at_abstract_start" id="last_active_at_abstract_start" value="<?php echo e($user_model->last_active_at_abstract_start??old('last_active_at_abstract_start')?$user_model->last_active_at_abstract_start??old('last_active_at_abstract_start'):''); ?> " autocomplete="off">
        </div>
        <span class="layui-input-inline time"> <= 最后活跃时间 <= </span>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" placeholder="结束时间" lay-verify="last_active_at_abstract_end" name="last_active_at_abstract_end" id="last_active_at_abstract_end" value="<?php echo e($user_model->last_active_at_abstract_end??old('last_active_at_abstract_end')?$user_model->last_active_at_abstract_end??old('last_active_at_abstract_end'):''); ?>" autocomplete="off">
        </div>
    </div>
    <div class="form-group my_status" id="last_active_at_relative" <?php if(isset($user_model) && $user_model->last_active_at_type == 2 ): ?> style="display: block" <?php endif; ?> <?php if(old('last_active_at_type')==2): ?> style="display: block" <?php endif; ?>>
        <div class="layui-input-inline">
            <input type="text" name="last_active_at_relative_num" id="last_active_at_relative_num"  value="<?php echo e($user_model->last_active_at_relative_num??old('last_active_at_relative_num')? $user_model->last_active_at_relative_num??old('last_active_at_relative_num') :null); ?>" lay-verify="last_active_at_relative_num"  class="layui-input" size="300">
        </div>
        <div class="layui-input-inline">
            <select name="last_active_at_relative_unit" >
                <option value="day" <?php if(isset($user_model) && $user_model->last_active_at_relative_unit == 'day'): ?> selected <?php endif; ?> <?php if(old('last_active_at_relative_unit')=='day'): ?> selected <?php endif; ?>>天</option>
                <option value="week" <?php if(isset($user_model) && $user_model->last_active_at_relative_unit == 'week'): ?> selected <?php endif; ?> <?php if(old('last_active_at_relative_unit')=='week'): ?> selected <?php endif; ?>>周</option>
                <option value="month" <?php if(isset($user_model) && $user_model->last_active_at_relative_unit == 'month'): ?> selected <?php endif; ?> <?php if(old('last_active_at_relative_unit')=='month'): ?> selected <?php endif; ?>>月</option>
                <option value="year" <?php if(isset($user_model) && $user_model->last_active_at_relative_unit == 'year'): ?> selected <?php endif; ?> <?php if(old('register_at_relative_unit')=='year'): ?> selected <?php endif; ?>>年</option>
            </select>
        </div>
        <div class="layui-input-inline">
            <select name="last_active_at_relative_type" >
                <option value="1" <?php if(isset($user_model) && $user_model->last_active_at_relative_type == '1'): ?> selected <?php endif; ?>  <?php if(old('last_active_at_relative_type')=='1'): ?> selected <?php endif; ?>>以前</option>
                <option value="2" <?php if(isset($user_model) && $user_model->last_active_at_relative_type == '2'): ?> selected <?php endif; ?>  <?php if(old('last_active_at_relative_type')=='2'): ?> selected <?php endif; ?>>以内</option>
            </select>
        </div>
    </div>
</div>




<div class="layui-form-item">
    <label class="layui-form-label">最后登录平台</label>
    <div class="layui-input-block">
        <select name="last_login_platforms[]" xm-select="select5">
            <option <?php if(isset($user_model) && in_array('android',$user_model->last_login_platforms)): ?> selected  <?php endif; ?> <?php if(old('last_login_platforms') && in_array('android', explode(',',old('last_login_platforms')[0]))): ?> selected = "selected" <?php endif; ?> value="android">android</option>
            <option <?php if(isset($user_model) && in_array('ios',$user_model->last_login_platforms)): ?> selected  <?php endif; ?> <?php if(old('last_login_platforms') && in_array('ios', explode(',',old('last_login_platforms')[0]))): ?> selected = "selected" <?php endif; ?> value="ios">ios</option>
            <option <?php if(isset($user_model) && in_array('pc',$user_model->last_login_platforms)): ?> selected  <?php endif; ?> <?php if(old('last_login_platforms') && in_array('pc', explode(',',old('last_login_platforms')[0]))): ?> selected = "selected" <?php endif; ?> value="pc">pc</option>
            <option <?php if(isset($user_model) && in_array('wap',$user_model->last_login_platforms)): ?> selected  <?php endif; ?> <?php if(old('last_login_platforms') && in_array('wap', explode(',',old('last_login_platforms')[0]))): ?> selected = "selected" <?php endif; ?> value="wap">wap</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">最后申请产品</label>
    <div class="layui-input-block">
        <select name="last_apply_loans[]" xm-select="select6">
            <?php if(count($products)): ?>
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option
                            <?php if(isset($user_model) && in_array($product->id,$user_model->last_apply_loans)): ?> selected  <?php endif; ?>
                            <?php if(old('last_apply_loans') && in_array($product->id, explode(',',old('last_apply_loans')[0]))): ?> selected = "selected" <?php endif; ?> value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">最后申请产品时间</label>
    <div class="layui-input-block" >
        <input type="radio" name="last_apply_loan_at_type" lay-filter="last_apply_loan_at_type"  value="0" title="不限" <?php if(isset($user_model->last_apply_loan_at_type) && $user_model->last_apply_loan_at_type == 0): ?> checked <?php endif; ?> <?php if(old('last_apply_loan_at_type')==0): ?> checked <?php endif; ?> checked>
        <input type="radio" name="last_apply_loan_at_type" lay-filter="last_apply_loan_at_type"  value="1" title="绝对时间" <?php if(isset($user_model->last_apply_loan_at_type) && $user_model->last_apply_loan_at_type == 1): ?> checked <?php endif; ?> <?php if(old('last_apply_loan_at_type')==1): ?> checked <?php endif; ?>>
        <input type="radio" name="last_apply_loan_at_type" lay-filter="last_apply_loan_at_type"  value="2" title="相对时间" <?php if(isset($user_model->last_apply_loan_at_type) && $user_model->last_apply_loan_at_type == 2): ?> checked <?php endif; ?> <?php if(old('last_apply_loan_at_type')==2): ?> checked <?php endif; ?>>
    </div>
    <div class="form-group my_status" id="last_apply_loan_at_abstract" <?php if(isset($user_model) && $user_model->last_apply_loan_at_type == 1 ): ?> style="display: block" <?php endif; ?> <?php if(old('last_apply_loan_at_type')=='1'): ?> style="display: block" <?php endif; ?>>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" placeholder="开始时间" lay-verify="last_apply_loan_at_abstract_start" name="last_apply_loan_at_abstract_start" id="last_apply_loan_at_abstract_start" value="<?php echo e($user_model->last_apply_loan_at_abstract_start??old('last_apply_loan_at_abstract_start')?$user_model->last_apply_loan_at_abstract_start??old('last_apply_loan_at_abstract_start'):null); ?>" autocomplete="off">
        </div>
        <span class="layui-input-inline time"> <= 最后申请产品时间 <= </span>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" placeholder="结束时间" lay-verify="last_apply_loan_at_abstract_end" name="last_apply_loan_at_abstract_end" id="last_apply_loan_at_abstract_end" value="<?php echo e($user_model->last_apply_loan_at_abstract_end??old('last_apply_loan_at_abstract_end')?$user_model->last_apply_loan_at_abstract_end??old('last_apply_loan_at_abstract_end'):null); ?>" autocomplete="off">
        </div>
    </div>
    <div class="form-group my_status" id="last_apply_loan_at_relative" <?php if(isset($user_model) && $user_model->last_apply_loan_at_type == 2 ): ?> style="display: block" <?php endif; ?> <?php if(old('last_apply_loan_at_type') =='2'): ?> style="display: block" <?php endif; ?>>
        <div class="layui-input-inline">
            <input type="text" name="last_apply_loan_at_relative_num" id="last_apply_loan_at_relative_num"  value="<?php echo e($user_model->last_apply_loan_at_relative_num??old('last_apply_loan_at_relative_num')? $user_model->last_apply_loan_at_relative_num??old('last_apply_loan_at_relative_num') : null); ?>" lay-verify="last_apply_loan_at_relative_num"  class="layui-input" size="300">
        </div>
        <div class="layui-input-inline">
            <select name="last_apply_loan_at_relative_unit" >
                <option value="day" <?php if(isset($user_model) && $user_model->last_apply_loan_at_relative_unit == 'day'): ?> selected <?php endif; ?> <?php if(old('last_apply_loan_at_relative_unit')=='day'): ?> selected <?php endif; ?>>天</option>
                <option value="week" <?php if(isset($user_model) && $user_model->last_apply_loan_at_relative_unit == 'week'): ?> selected <?php endif; ?> <?php if(old('last_apply_loan_at_relative_unit')=='week'): ?> selected <?php endif; ?>>周</option>
                <option value="month" <?php if(isset($user_model) && $user_model->last_apply_loan_at_relative_unit == 'month'): ?> selected <?php endif; ?> <?php if(old('last_apply_loan_at_relative_unit')=='month'): ?> selected <?php endif; ?>>月</option>
                <option value="year" <?php if(isset($user_model) && $user_model->last_apply_loan_at_relative_unit == 'year'): ?> selected <?php endif; ?> <?php if(old('last_apply_loan_at_relative_unit')=='year'): ?> selected <?php endif; ?>>年</option>
            </select>
        </div>
        <div class="layui-input-inline">
            <select name="last_apply_loan_at_relative_type" >
                <option value="1" <?php if(isset($user_model) && $user_model->last_apply_loan_at_relative_type == '1'): ?> selected <?php endif; ?>  <?php if(old('last_apply_loan_at_relative_type')=='1'): ?> selected <?php endif; ?>>以前</option>
                <option value="2" <?php if(isset($user_model) && $user_model->last_apply_loan_at_relative_type == '2'): ?> selected <?php endif; ?>  <?php if(old('last_apply_loan_at_relative_type')=='2'): ?> selected <?php endif; ?>>以内</option>
            </select>
        </div>
    </div>
</div>




<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="<?php echo e(route('admin.userModel')); ?>" >返 回</a>
    </div>
</div>