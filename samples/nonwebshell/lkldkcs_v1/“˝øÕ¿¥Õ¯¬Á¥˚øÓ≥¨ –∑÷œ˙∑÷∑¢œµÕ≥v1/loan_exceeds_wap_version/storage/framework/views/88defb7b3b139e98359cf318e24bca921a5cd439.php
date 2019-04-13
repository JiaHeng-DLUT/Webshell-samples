<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>登录</title>
    <link rel="stylesheet" href="pkg/lib.css">
    
    <link rel="stylesheet" href="pkg/common.css">
    <style>
        .loginWraper{
            background: none;
            background-color: #fff;
            position: absolute;
            width: 100%;
            left: 0;
            top: 0;
            bottom: 0;
            right: 0;
        }
        .loginWraper>div{
            float: left;
            width: 50%;
            height: 100%;
            position: relative;
        }
        .banner_ img{
            width: 100%;
            height: 100%;
        }
        .loginWraper h3{
            font-size: 50px;
            letter-spacing: 2px;
            color: #1b203e;
            text-align: center;
            margin-top: 100px;
        }
        .loginBox{
            background: none;
            position: absolute;
            width: 617px;
            height: 330px;
            left: 50%;
            top: 50%;
            margin-left: -309px;
            margin-top: -184px;
            padding-top: 38px;
        }
        .form_item{
            width: 400px;
            margin: 0 auto 80px;
            border-bottom: 1px solid #ccc;
            line-height: 1.6;
            /* padding-bottom: 10px; */
        }
        .form_item input,
        .form_item input:hover{
            outline:none;
            border: none;
            font-size: 16px;
            height: 41px;
            padding: 8px;
            width: 360px;
        }
        .action{
            text-align: center;
        }
        .action input,
        .action input:hover{
            width: 200px;
            height: 60px;
            background-color: #004ae0;
            color: #fff;
            font-size: 20px;
            letter-spacing: 10px;
            text-align: center;
        }
    </style>
</head>
<body class="login_tg_bg">
<div class="loginWraper">
    <div class="banner_">
        <img src="/images/20190322121225.jpg" alt="">
    </div>
    <div>
        <h3>后台管理系统登录</h3>
        <div id="loginform" class="loginBox">
            <form class="form form-horizontal" action="<?php echo e(url('login')); ?>" method="post">
                <?php echo csrf_field(); ?>

                <div class="form_item">
                    <img src="/images/zhanghu.png" alt="">
                    <input type="text" class="txt" name="username" value="<?php echo e(old('username')); ?>" placeholder="输入您的账号">
                    <span></span>
                </div>
                <div class="form_item">
                    <img src="/images/mima.png" alt="">
                    <input type="password" class="txt" name="password" value="<?php echo e(old('password')); ?>" placeholder="输入您的密码">
                    <span></span>
                </div>
                <div class="form_item">
                    <img src="/images/yanzhengma.png" alt="">
                    <input type="text" class="txt txt1" name="captcha" value="" style="width:200px;" placeholder="输入验证码">
                    <img src="<?php echo e(captcha_src('flat')); ?>" class="yzm" title="点击更换验证码">
                    <a id="login-captcha" href="javascript:;" ></a>
                </div>
                <div class="action">
                    <input type="submit" value="登&nbsp;录" class="btn">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- <footer class="footer_login">
    ©2018 贷贷狐 版权所有 总部地址:成都市XXXX
</footer> -->
<script src="pkg/lib.js"></script>
<script src="pkg/common.js"></script>
<script>


    <?php if(count($errors) > 0): ?>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($key==0): ?>
                layer.msg("<?php echo e($error); ?>", {icon: 2, time: 2000});
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>


    $(function(){
        $(".yzm").click(function(){
            $(this).attr("src", "<?php echo e(captcha_src('flat')); ?>?_t" + Math.random());
        });
    });
</script>
</body>
</html>