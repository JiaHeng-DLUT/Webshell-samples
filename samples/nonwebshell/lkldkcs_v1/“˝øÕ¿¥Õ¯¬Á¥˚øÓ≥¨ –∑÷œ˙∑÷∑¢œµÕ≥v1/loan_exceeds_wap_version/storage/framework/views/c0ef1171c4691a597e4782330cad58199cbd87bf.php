<?php echo e(csrf_field()); ?>


<link href="/static/admin/limit_district/css/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/static/admin/limit_district/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/admin/limit_district/js/City_data.js"></script>
<script type="text/javascript" src="/static/admin/limit_district/js/areadata.js"></script>
<script type="text/javascript" src="/static/admin/limit_district/js/auto_area.js"></script>


<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>产品logo</label>
    <div class="layui-input-inline">
        <button type="button" class="layui-btn" id="logo">上传图片</button>
        <button type="button" class="layui-btn layui-btn-danger layui-btn-sm" style="display: none" id="logoRemove">移除</button>
        <div class="layui-upload-list">
            <img class="layui-upload-img" id="logoImg" style="width: 100px;height: 100px" <?php if($product->logo): ?> src="<?php echo e(iAsset($product->logo)); ?>" <?php endif; ?>>
            <input type="hidden" name="logo" value="<?php echo e($product->logo); ?>" lay-verify="logo">
            <p id="logoText"></p>
        </div>
        <span>建议尺寸 : 98*98</span>
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>产品名称</label>
    <div class="layui-input-inline">
        <input type="text" name="name" maxlength="10" value="<?php echo e($product->name??old('name')); ?>" lay-verify="required" class="layui-input" placeholder="请填写产品名称">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">营销元素</label>
    <div class="layui-input-block">
        <input type="checkbox" name="market_element[]" title="火" lay-skin="primary" value="fire" <?php echo e(in_array('fire',$product->market_element)?'checked':''); ?>>
        <input type="checkbox" name="market_element[]" title="红包" lay-skin="primary" value="money" <?php echo e(in_array('money',$product->market_element)?'checked':''); ?>>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">产品角标</label>
    <div class="layui-input-inline">
        <select name="corner_id" id="">
            <option value="0">不使用</option>
            <?php if($corners->count()): ?>
                <?php $__currentLoopData = $corners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $corner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($corner->id); ?>" <?php echo e($corner->id==$product->corner_id?'selected':''); ?>><?php echo e($corner->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">产品标签</label>
    <div class="layui-input-block">
        <?php if($labels->count()): ?>
            <?php $__currentLoopData = $labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <input type="checkbox" name="label[]" lay-filter="label" class="product_label" title="<?php echo e($label->name); ?>" lay-skin="primary" value="<?php echo e($label->id); ?>" <?php echo e(in_array($label->id,$product->label->pluck('id')->all())?'checked':''); ?>>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">所属类目</label>
    <div class="layui-input-block">
        <?php if($categories->count()): ?>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <input type="checkbox" name="category[]" lay-filter="category" class="product_category" title="<?php echo e($category->name); ?>" lay-skin="primary" value="<?php echo e($category->id); ?>" <?php echo e(in_array($category->id,$product->category->pluck('id')->all())?'checked':''); ?>>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">所属栏目</label>
    <div class="layui-input-block">
        <?php if($columns->count()): ?>
            <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <input type="checkbox" name="column[]" lay-filter="column" class="product_column" title="<?php echo e($column->name); ?>" lay-skin="primary" value="<?php echo e($column->id); ?>" <?php echo e(in_array($column->id,$product->column->pluck('id')->all())?'checked':''); ?>>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</div>


<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>产品摘要</label>
    <div class="layui-input-block" style="width: 40%">
        <input type="text" name="slogan" maxlength="15" value="<?php echo e($product->slogan??old('slogan')); ?>" lay-verify="required" class="layui-input" placeholder="请填写产品摘要">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>利率</label>
    <div class="layui-input-inline">
        <input type="number" name="rate_value"  oninput="if(value.length>6)value=value.slice(0,6)" value="<?php echo e($product->rate_value??old('rate_value')); ?>" lay-verify="required|rate_value" class="layui-input" placeholder="请填写产品利率">
    </div>
    <div class="layui-input-inline">
        <select name="rate_unit" id="" lay-verify="required">
            <option value="">请选择利率单位</option>
            <option value="day" <?php echo e($product->rate_unit=='day'?'selected':''); ?>>日</option>
            <option value="month" <?php echo e($product->rate_unit=='month'?'selected':''); ?>>月</option>
            <option value="year" <?php echo e($product->rate_unit=='year'?'selected':''); ?>>年</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>还款周期</label>
    <div class="layui-inline">
        <div class="layui-input-inline" style="width: 100px;">
            <input type="number" name="repay_min" oninput="if(value.length>3)value=value.slice(0,3)" value="<?php echo e($product->repay_min); ?>"  placeholder="前值" autocomplete="off" class="layui-input" lay-verify="required|repay_min">
        </div>
        <div class="layui-form-mid">~</div>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="number" name="repay_max" oninput="if(value.length>3)value=value.slice(0,3)" value="<?php echo e($product->repay_max); ?>" placeholder="后值" autocomplete="off" class="layui-input" lay-verify="required|repay_max">
        </div>
    </div>
    <div class="layui-inline">
        <select name="repay_unit" id="" lay-verify="required">
            <option value="">请选择还款周期单位</option>
            <option value="day" <?php echo e($product->repay_unit=='day'?'selected':''); ?>>日</option>
            <option value="month" <?php echo e($product->repay_unit=='month'?'selected':''); ?>>月</option>
            <option value="year" <?php echo e($product->repay_unit=='year'?'selected':''); ?>>年</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>贷款额度</label>
    <div class="layui-inline">
        <div class="layui-input-inline" style="width: 100px;">
            <input type="number" name="quota_min" oninput="if(value.length>6)value=value.slice(0,6)" value="<?php echo e($product->quota_min); ?>"  placeholder="前值" autocomplete="off" class="layui-input" lay-verify="required|quota_min">
        </div>
        <div class="layui-form-mid">~</div>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="number" name="quota_max" oninput="if(value.length>6)value=value.slice(0,6)" value="<?php echo e($product->quota_max); ?>" placeholder="后值" autocomplete="off" class="layui-input" lay-verify="required|quota_max">
        </div>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>最快放款时间</label>
    <div class="layui-input-inline">
        <input type="number" name="fast_lend_value"  oninput="if(value.length>3)value=value.slice(0,3)" value="<?php echo e($product->fast_lend_value??old('fast_lend_value')); ?>" lay-verify="required|fast_lend_value" class="layui-input" placeholder="请填写最快放款时间">
    </div>
    <div class="layui-input-inline">
        <select name="fast_lend_unit" id="" lay-verify="required">
            <option value="">请选择放款时间单位</option>
            <option value="minute" <?php echo e($product->fast_lend_unit=='minute'?'selected':''); ?>>分钟</option>
            <option value="hour" <?php echo e($product->fast_lend_unit=='hour'?'selected':''); ?>>小时</option>
            <option value="day" <?php echo e($product->fast_lend_unit=='day'?'selected':''); ?>>天</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>成功率</label>
    <div class="layui-input-inline">
        <input type="number" name="success_rate" oninput="if(value.length>3)value=value.slice(0,3)" value="<?php echo e($product->success_rate??old('success_rate',100)); ?>" lay-verify="required|number|success_rate" class="layui-input" placeholder="请填写成功率">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>跳转申请地址</label>
    <div class="layui-input-block" style="width: 40%">
        <input type="text" name="redirect_url" maxlength="1000" value="<?php echo e($product->redirect_url??old('redirect_url')); ?>" lay-verify="required|url" class="layui-input" placeholder="请填写跳转申请地址">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>上线平台</label>
    <div class="layui-input-block" id="platform">
        <input type="checkbox" name="platform[]" title="android" lay-skin="primary" value="android" <?php echo e(in_array('android',$product->platform()->pluck('platform')->all())?'checked':''); ?>>
        <input type="checkbox" name="platform[]" title="ios" lay-skin="primary" value="ios" <?php echo e(in_array('ios',$product->platform()->pluck('platform')->all())?'checked':''); ?> >
        <input type="checkbox" name="platform[]" title="wap" lay-skin="primary" value="wap" <?php echo e(in_array('wap',$product->platform()->pluck('platform')->all())?'checked':''); ?> >
        <input type="checkbox" name="platform[]" title="pc" lay-skin="primary" value="pc" <?php echo e(in_array('pc',$product->platform()->pluck('platform')->all())?'checked':''); ?> >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>申请条件</label>
    <div class="layui-input-block">
        <textarea name="apply_condition" maxlength="999" style="width: 43%" rows="10" onkeyup="words_deal();" required lay-verify="required" placeholder="请输入申请条件" class="layui-textarea"><?php echo e($product->apply_condition); ?></textarea>
        <p class="text-count"><span id="textCount"><?php echo e(mb_strlen($product->apply_condition)?mb_strlen($product->apply_condition):0); ?></span>/999（最多999个字）</p>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">个人资质</label>
    <div class="layui-input-block">
        <?php if($materials->count()): ?>
            <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <input type="checkbox" name="material[]" title="<?php echo e($material->name); ?>" lay-skin="primary" value="<?php echo e($material->id); ?>" <?php echo e(in_array($material->id,$product->material->pluck('id')->all())?'checked':''); ?>>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">产品限制地区</label>
    <div class="layui-input-block">
        <input type="text" name="district_limit" readonly value="<?php echo e($product->district_limit?$product->district_limit:''); ?>"  class="layui-input area-duoxuan" data-value="<?php echo e($product->district_code); ?>" placeholder="">
        <input type="hidden" name="district_code" value="<?php echo e($product->district_code); ?>">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">控量</label>
    <div class="layui-input-block">
        <input type="radio" name="control_volume" value="no" title="不控量" lay-filter="control_volume"   <?php if($product->control_volume == 'no' || !isset($product->control_volume)): ?> checked  <?php endif; ?>>
        <input type="radio" name="control_volume" value="yes" title="控量" lay-filter="control_volume"   <?php if($product->control_volume == 'yes'): ?> checked  <?php endif; ?>>
    </div>
</div>
<div class="layui-form-item" <?php if($product->control_volume === 'no' || !isset($product->control_volume)): ?>  style="display: none;" <?php endif; ?>  id="control_volume1">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>数量</label>
    <div class="layui-input-block" style="width: 25%">
        <input type="number" name="auto_down_sale_num" oninput="if(value.length>5)value=value.slice(0,5)" value="<?php echo e($product->auto_down_sale_num??old('auto_down_sale_num',1)); ?>" lay-verify="required|number|auto_down_sale_num" class="layui-input" placeholder="请填写自动申请下架数,范围1~99999" id="auto_down_sale_num">
    </div>
</div>
<div class="layui-form-item" <?php if($product->control_volume === 'no' || !isset($product->control_volume)): ?>  style="display: none;" <?php endif; ?>  id="control_volume2">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>自动上架时间</label>
    <div class="layui-input-block" style="width: 25%">
        <input type="text" name="auto_up_date"  id="auto_up_date" lay-verify="auto_up_date" class="layui-input" value="<?php echo e($product->auto_up_date); ?>" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>上下架状态</label>
    <div class="layui-input-inline">

        <input type="checkbox" name="status"   lay-skin="switch" lay-text="上架|下架"  value="1"  <?php echo e($product->status == '1' ? 'checked' : $product->status===null?'checked':''); ?>>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>排序值</label>
    <div class="layui-input-inline">
        <input type="number" name="sort" oninput="if(value.length>4)value=value.slice(0,4)" value="<?php echo e($product->sort??old('sort',0)); ?>" lay-verify="required|number|sort" class="layui-input" placeholder="请填写排序值">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">系统推荐</label>
    <div class="layui-input-block">
        <input type="checkbox" name="guess_like[]" title="贷款详情页-猜你喜欢" lay-skin="primary" value="product" <?php echo e(in_array('product',$product->guess_like)?'checked':''); ?>>
        <input type="checkbox" name="guess_like[]" title="发现详情-猜你喜欢" lay-skin="primary" value="article" <?php echo e(in_array('article',$product->guess_like)?'checked':''); ?>>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>结算模式</label>
    <div class="layui-input-inline">
        <select name="deal_type" id="" lay-verify="required">
            <option value="">请选择结算模式</option>
            <option value="cpa" <?php echo e($product->deal_type=='cpa'?'selected':''); ?>>cpa</option>
            <option value="cps" <?php echo e($product->deal_type=='cps'?'selected':''); ?>>cps</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label"><strong class="item-required">*</strong>结算单价</label>
    <div class="layui-input-inline">
        <input type="number" name="deal_price" step="0.01" oninput="if(value.length>6)value=value.slice(0,6)" value="<?php echo e($product->deal_price??old('deal_price')); ?>" lay-verify="required|number|deal_price" class="layui-input" placeholder="请填写结算单价">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">标签</label>
    <div class="layui-input-block">
        <?php if($new_labels->count()): ?>
            <?php $__currentLoopData = $new_labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $new_label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <input type="checkbox" name="new_label[]" lay-filter="label"  title="<?php echo e($new_label->name); ?>" lay-skin="primary" value="<?php echo e($new_label->id); ?>" <?php echo e(in_array($new_label->id,$product->newLabel->pluck('id')->all())?'checked':''); ?>>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">热门推荐（PC）</label>
    <div class="layui-input-block">
        <input type="radio" name="pc_hot" value="1" title="推荐"    <?php if($product->pc_hot == 1 || !isset($product->pc_hot)): ?> checked  <?php endif; ?>>
        <input type="radio" name="pc_hot" value="0" title="不推荐"   <?php if($product->pc_hot == 0): ?> checked  <?php endif; ?>>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">热门推荐（PC）排序值</label>
    <div class="layui-input-inline">
        <input type="number" name="pc_sort" oninput="if(value.length>4)value=value.slice(0,4)" value="<?php echo e($product->pc_sort??old('pc_sort',0)); ?>" lay-verify="required|number|sort" class="layui-input" placeholder="请填写排序值">
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="save">保存</button>
        <a href="<?php echo e(route('admin.product')); ?>" class="layui-btn"  >返 回</a>
    </div>
</div>


