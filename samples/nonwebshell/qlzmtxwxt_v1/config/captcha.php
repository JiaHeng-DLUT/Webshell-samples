<?php
return [
       // 验证码位数
      'length'   => 4, 
       // 验证码字体大小
      'fontSize' => 30,
      //过期时间
      'expire'   => 60, 
       // 是否画混淆曲线
      'useCurve'=> false,
        // 关闭验证码杂点
      'useNoise' => false,
      // 使用背景图片
      'useImgBg' => false,
      // 使用中文验证码
      // 'useZh'    => true,
      // 设置验证码字符
      // 'zhSet'    =>'合肥奇乐网络科技有限公司', 
      // 验证码背景颜色
      'bg'       => [254,254, 254,1],
    ];