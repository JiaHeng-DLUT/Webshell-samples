<?php $__env->startSection('content'); ?>
    <div class="layui-card">
        <div class="layui-card-header">信用卡添加</div>
        <div class="layui-card-body" style="padding: 15px;">
            <form class="layui-form" method="post">
                <?php echo e(csrf_field()); ?>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label"><strong class="item-required">*</strong>信用卡图片</label>
                    <div class="layui-input-block">
                        <div class="layui-upload">
                            <button type="button" class="layui-btn" id="app"><i class="layui-icon">&#xe67c;</i>图片上传</button>
                            <span class="help">请上传1M以内的png、jpg、jpeg格式的图片,尺寸建议276*174</span>
                            <div class="layui-upload-list" >
                                <ul id="layui-upload-box2" class="layui-clear">
                                    <?php if(isset($info->logo)): ?>
                                        <li><img src="<?php echo e(env('IMG_URL').$info->logo); ?>" style="width: 100px;height: 100px;"/><p>上传成功</p></li>
                                    <?php endif; ?>
                                </ul>
                                <input type="hidden" name="qrcode_app" id="qrcode_app" value="<?php echo e($info->logo??''); ?>" style="width: 100px;height: 100px;" lay-verify="qrcode_app">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><strong class="item-required">*</strong>信用卡名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" lay-verify="name" autocomplete="off" placeholder="请输入信用卡名称" class="layui-input" value="<?php echo e($info->name??''); ?>" maxlength="15">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label"><strong class="item-required">*</strong>发卡行</label>
                    <div class="layui-input-block">
                        <select name="credit_bank_id" lay-verify="bank">
                            <option value="" <?php if(!isset($info)): ?>  checked="checked" <?php endif; ?>>请选择发卡行</option>
                            <?php if($result['banks']): ?>
                                <?php $__currentLoopData = $result['banks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>" <?php if( isset($info) && $info->credit_bank_id &&$info->credit_bank_id == $item->id ): ?> selected <?php endif; ?>><?php echo e($item->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">营销角标</label>
                    <div class="layui-input-block">
                        <?php if($result['corner']): ?>
                            <?php $__currentLoopData = $result['corner']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="radio" name="corner_id" value="<?php echo e($item['id']); ?>" title="<?php echo e($item['name']); ?>"  lay-verify="" <?php if(isset($info) && $info->corner_id == $item->id ): ?> checked="checked"  <?php endif; ?>  >
                                <div class="layui-unselect layui-form-radio layui-form-radioed">
                                    <i class="layui-anim layui-icon"></i><div><?php echo e($item['name']); ?></div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <input type="radio" name="corner_id" value="0" title="不使用"  lay-verify="" <?php if(isset($info) && $info->corner_id == 0 ): ?> checked="checked"  <?php endif; ?>  >
                                <div class="layui-unselect layui-form-radio layui-form-radioed">
                                    <i class="layui-anim layui-icon"></i><div>不使用</div>
                                </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label"><strong class="item-required">*</strong>特权</label>
                    <div class="layui-input-block">
                        <textarea name="introduce" placeholder="请输入特权内容" class="layui-textarea" lay-verify="introduce" maxlength="200"  id="replyContent" ><?php echo e($info->introduce??''); ?></textarea>
                        <span class="count" ><span id="count"><?php if(isset($info)): ?> <?php echo e(mb_strlen($info->introduce)); ?> <?php else: ?> 0 <?php endif; ?></span>/200</span>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><strong class="item-required">*</strong>卡等级</label>
                    <div class="layui-input-block">
                        <select name="credit_level_id" lay-verify="level">
                            <option value="" <?php if(!isset($info)): ?>  checked="checked" <?php endif; ?>>请选择卡等级</option>
                            <?php if($result['level']): ?>
                                <?php $__currentLoopData = $result['level']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>" <?php if(isset($info) && $info->credit_level_id == $item->id ): ?> selected <?php endif; ?>><?php echo e($item->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><strong class="item-required">*</strong>卡组织</label>
                    <div class="layui-input-block">
                        <select name="credit_organization_id" lay-verify="organization">
                            <option value="">请选择卡组织</option>
                            <?php if($result['category']): ?>
                                <?php $__currentLoopData = $result['category']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>" <?php if(isset($info) && $info->credit_organization_id == $item->id ): ?> selected <?php endif; ?>><?php echo e($item->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><strong class="item-required">*</strong>年费</label>
                    <div class="layui-input-block">
                        <input type="text" name="year_fee" lay-verify="year_fee" autocomplete="off" placeholder="请输入年费" class="layui-input" value="<?php echo e($info->year_fee??''); ?>" maxlength="30">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><strong class="item-required">*</strong>申请链接</label>
                    <div class="layui-input-block">
                        <input type="text" name="redirect_url" lay-verify="url" autocomplete="off" placeholder="请输入申请链接" class="layui-input" value="<?php echo e($info->redirect_url??''); ?>" maxlength="1000">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><strong class="item-required">*</strong>免息期</label>
                    <div class="layui-input-block">
                        <input type="text" name="free_period" lay-verify="free_period" autocomplete="off" placeholder="请输入免息期" class="layui-input" value="<?php echo e($info->free_period??''); ?>" maxlength="15">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><strong class="item-required">*</strong>取现额度</label>
                    <div class="layui-input-block">
                        <input type="text" name="cash_amount" lay-verify="cash_amount" autocomplete="off" placeholder="请输入取现额度" class="layui-input" value="<?php echo e($info->cash_amount??''); ?>" maxlength="15">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><strong class="item-required">*</strong>上下架</label>
                    <div class="layui-input-block">
                        <input type="radio" name="status" value="1" title="上架" <?php if(!isset($info) || $info->status == 1 ): ?> checked  <?php endif; ?> >
                        <div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i>
                            <div>上架</div>
                        </div>
                        <input type="radio" name="status" value="0" title="下架" <?php if(isset($info) && $info->status == 0 ): ?> checked <?php endif; ?>>
                        <div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i>
                            <div>下架</div>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><strong class="item-required">*</strong>申请基数</label>
                    <div class="layui-input-block">
                        <input type="text" name="base_apply_num" lay-verify="required|number|base_apply_num" autocomplete="off" placeholder="请输入申请基数" class="layui-input" value="<?php echo e($info->base_apply_num??''); ?>" maxlength="5">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><strong class="item-required">*</strong>排序值</label>
                    <div class="layui-input-block">
                        <input type="text" name="sort" lay-verify="required|number|sort" autocomplete="off" placeholder="请输入排序值" class="layui-input" value="<?php echo e($info->sort??''); ?>" maxlength="4" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">系统推荐</label>
                   
                    <div class="layui-input-block">
                        <input type="checkbox" name="guess_like" title="信用卡详情页-猜你喜欢" lay-skin="primary" value="1" <?php if(isset($info) &&  $info->guess_like == 1 ): ?> checked <?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">控量</label>
                    <div class="layui-input-block">
                        <input type="radio" name="control_volume" value="no" title="不控量" lay-filter="control_volume"
                               <?php if(isset($info) && $info->control_volume == 'no'): ?> checked <?php else: ?> checked <?php endif; ?>>
                        <input type="radio" name="control_volume" value="yes" title="控量" lay-filter="control_volume"
                               <?php if(isset($info->control_volume) && $info->control_volume == 'yes'): ?> checked  <?php endif; ?>>
                    </div>
                </div>
                <div class="layui-form-item" <?php if((isset($info->control_volume) && $info->control_volume  === 'no') || !isset($info)): ?>
                style="display: none;" <?php endif; ?>  id="control_volume1">
                    <label for="" class="layui-form-label"><strong class="item-required">*</strong>数量</label>
                    <div class="layui-input-block" style="width: 25%">
                        <input type="number" name="auto_down_sale_num" oninput="if(value.length>5)value=value.slice(0,5)" value="<?php echo e($info->auto_down_sale_num ??old('auto_down_sale_num',1)); ?>" lay-verify="required|number|auto_down_sale_num" class="layui-input" placeholder="请填写自动申请下架数,范围1~99999" id="auto_down_sale_num">
                    </div>
                </div>
                <div class="layui-form-item" <?php if((isset($info->control_volume) && $info->control_volume  === 'no') || !isset($info)): ?>
                style="display: none;" <?php endif; ?> id="control_volume2">
                    <label for="" class="layui-form-label"><strong class="item-required">*</strong>自动上架时间</label>
                    <div class="layui-input-block" style="width: 25%">
                        <input type="text" name="auto_up_date"  id="auto_up_date" lay-verify="auto_up_date" class="layui-input"
                               <?php if(isset($info->auto_up_date)): ?>  value="<?php echo e($info->auto_up_date); ?>" <?php else: ?> value="" <?php endif; ?>
                        >
                    </div>
                </div>


                <div class="layui-form-item layui-layout-admin">
                    <div class="layui-input-block">
                        <div class="layui-footer" style="left: 0;">
                            <button class="layui-btn" lay-submit lay-filter="*">立即提交</button>
                            <?php if(isset($info)): ?>
                                <button type="reset" class="layui-btn " onclick="redirectToPage('<?php echo e(route('admin.credit')); ?>')">返回</button>
                            <?php else: ?>
                                <button type="reset" class="layui-btn " onclick="redirectToPage('<?php echo e(route('admin.credit')); ?>')">返回</button>
                                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <style>
        #layui-upload-box1 li{
            width: 120px;
            height: 100px;
            float: left;
            position: relative;
            overflow: hidden;
            margin-right: 10px;
            border:1px solid #ddd;
        }
        #layui-upload-box1 li img{
            width: 100%;
        }
        #layui-upload-box1 li p{
            width: 100%;
            height: 22px;
            font-size: 12px;
            position: absolute;
            left: 0;
            bottom: 0;
            line-height: 22px;
            text-align: center;
            color: #fff;
            background-color: #333;
            opacity: 0.6;
        }
        #layui-upload-box1 li i{
            display: block;
            width: 20px;
            height:20px;
            position: absolute;
            text-align: center;
            top: 2px;
            right:2px;
            z-index:999;
            cursor: pointer;
        }
        #layui-upload-box2 li{
            width: 120px;
            height: 100px;
            float: left;
            position: relative;
            overflow: hidden;
            margin-right: 10px;
            border:1px solid #ddd;
        }
        #layui-upload-box2 li img{
            width: 100%;
        }
        #layui-upload-box2 li p{
            width: 100%;
            height: 22px;
            font-size: 12px;
            position: absolute;
            left: 0;
            bottom: 0;
            line-height: 22px;
            text-align: center;
            color: #fff;
            background-color: #333;
            opacity: 0.6;
        }
        #layui-upload-box2 li i{
            display: block;
            width: 20px;
            height:20px;
            position: absolute;
            text-align: center;
            top: 2px;
            right:2px;
            z-index:999;
            cursor: pointer;
        }
    </style>
    <script>
          var hour_mintues = $("#auto_up_date").val();
            if(!hour_mintues){
                hour_mintues = '00:00'
            }
        $("#replyContent").on("input propertychange", function () {
            var $this = $(this),
                    _val = $this.val(),
                    count = "";
            if (_val.length > 500) {
                $this.val(_val.substring(0, 500));
            }
            count = $this.val().length;
            $("#count").text(count);
        });
/*        function checkNumber(obj,min,max){
            var v = $(obj).val();
            if(v < min){
                layer.msg('最小不能低于：'+min, {icon: 2, time: 2000});
                $(obj).val(min)
            }
            if(v > max){
                layer.msg('最大不能超过：'+max, {icon: 2, time: 2000});
                $(obj).val(max)
            }
        }*/
        layui.use(['upload','form','laydate'],function () {
            var upload = layui.upload
            var laydate = layui.laydate;
            <?php if(session('success')): ?>
            layer.msg('<?php echo e(session('success')); ?>',{icon:6});
            <?php endif; ?>
            //普通图片上传
            /*upload.render({
                elem: '#weixin'
                ,url: '<?php echo e(route("uploadImage")); ?>'
                ,multiple: false
                ,data:{"_token":"<?php echo e(csrf_token()); ?>",maxSize:1,filename:'weixin'}
                // ,method:'post'
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    /!*obj.preview(function(index, file, result){
                     $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                     });*!/
                    obj.preview(function(index, file, result){
                        $('#layui-upload-box1').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                    });

                }
                ,done: function(res){
                    //如果上传失败
                    if(res.code == 0){
                        $("#qrcode_weixin").val(res.url);
                        $('#layui-upload-box1 li p').text('上传成功');
                        return layer.msg(res.msg,{icon:6});
                    }
                    return layer.msg(res.msg,{icon:5});
                }
            });*/
            laydate.render({
                elem: '#auto_up_date' //指定元素
                ,type:'time'
                ,format: 'HH:mm' //可任意组合
                ,value: hour_mintues
            });
            upload.render({
                elem: '#app'
                ,url: '<?php echo e(route("upload")); ?>'
                ,multiple: false
                ,data:{"_token":"<?php echo e(csrf_token()); ?>",maxSize:1,filename:'app'}
                // ,method:'post'
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    /*obj.preview(function(index, file, result){
                     $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                     });*/
                    obj.preview(function(index, file, result){
                        $('#layui-upload-box2').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                    });

                }
                ,done: function(res){
                    //如果上传失败
                    if(res.code == 0){
                        $("#qrcode_app").val(res.url);
                        $('#layui-upload-box2 li p').text('上传成功');
                        return layer.msg(res.msg,{icon:6});
                    }
                    return layer.msg(res.msg,{icon:5});
                }
            });
            var form = layui.form;
                form.on('radio(control_volume)', function(data){
                    if(data.value === 'yes'){
                        $('#control_volume1').show();
                        $('#control_volume2').show();
                    }else {
                        $('#control_volume1').hide();
                        $('#control_volume2').hide();

                    }
                });
                form.verify({
                qrcode_app: function(value, item){ //value：表单的值、item：表单的DOM对象
                    if(value==''){
                        return '请上传信用卡图片';
                    }
                }
                ,name: [
                    /^[\S]{1,15}$/
                    ,'名称必填，字符1到15位，且不能出现空格'
                ]
                ,bank: function(value){ //value：表单的值、item：表单的DOM对象
                    if(!value){
                        return '请选择发卡行';
                    }
                },
                introduce: function(value){ //value：表单的值、item：表单的DOM对象
                    if(!value){
                        return '特权必填，字符1到200位';
                    }
                },
                level: function(value){ //value：表单的值、item：表单的DOM对象
                    if(!value){
                        return '请选择卡等级';
                    }
                },
                organization: function(value){ //value：表单的值、item：表单的DOM对象
                    if(!value){
                        return '请选择卡组织';
                    }
                },
                year_fee: [
                    /^[\S]{1,30}$/
                    ,'年费必填，字符1到30位，且不能出现空格'
                ],
                free_period: [
                    /^[\S]{1,15}$/
                    ,'免息期必填，字符1到15位，且不能出现空格'
                ],
                cash_amount: [
                    /^[\S]{1,15}$/
                    ,'取现额度必填，字符1到15位，且不能出现空格'
                ],
                base_apply_num: function(value, item){ //value：表单的值、item：表单的DOM对象
                    if(value>99999 || value < 0){
                        return '申请基数必填，范围0~99999';
                    }
                },
                sort: function(value, item){ //value：表单的值、item：表单的DOM对象
                    if(value>999 || value < -999){
                        return '排序值必填，范围-999~999';
                    }
                },
                    auto_down_sale_num:function(value,item) {
                        var control_volume_type = $("input[name='control_volume']:checked").val();
                        /* console.log(control_volume_type);
                         return '自动下架申请数取值范围为1~99999';*/
                        if (control_volume_type === 'yes')
                        {
                            if (value < 1 || value > 99999) {
                                return '自动下架申请数取值范围为1~99999';
                            }
                        }
                    },
                    auto_up_date:function(value,item)
                    {
                        var control_volume_type = $("input[name='control_volume']:checked").val();
                        if (control_volume_type === 'yes')
                        {
                            if (value === '') {
                                return '请选择上架时间';
                            }
                        }
                    },
            });
        });
        function redirectToPage(u){
            window.location.href = u;
        }
    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>