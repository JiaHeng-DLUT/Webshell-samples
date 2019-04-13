//定义一个全局系统内置JS、CSS说明
  var qile = new Object;
      //名称：'QILECMS Global Object'; 
      //版本： "1.0.0";
      //时间："2018-8-29";
      qile.url        = window.location.href;  //当前url
      qile.title      = document.title;  //当前网页的标题
      qile.platform   = window.navigator.platform; //硬件平台
      qile.appVersion = window.navigator.appVersion; //浏览器版本
      qile.userAgent  = window.navigator.userAgent; //用户代理


// 可直接调用的方法
      qile.goBack     = function(){
         window.history.back();      //返回上个页面
      }
      //刷新
      qile.reload   =function(){
         window.location.reload();      //刷新
      }
      //tip提示
      qile.tip = function(elem,direction="上",color="#0FA6D8"){
        var index = layer.tips(direction,elem, {
          tips: [1, color] //还可配置颜色
        });
      }
      // 成功提示
      qile.success = function(msg,icon="1"){
           var index =  layer.msg(msg,{
            icon:icon,
            skin: 'layui-layer-molv'
        });
      }
      //错误提示
      qile.error= function(msg,icon="2"){
            var index = layer.msg(msg,{
            icon:icon,
            skin: 'layui-layer-molv'
        });
      }
      //警告提示
      qile.danger = function(msg,icon="0"){
           var index = layer.msg(msg,{
            icon:icon,
            skin: 'layui-layer-molv'
        }); 
      }
      //疑问提示
      qile.question = function(msg,icon="3"){
            var index = layer.msg(msg,{
            icon:icon,
            skin: 'layui-layer-molv'
        }); 
      }
      //锁定提示
      qile.lock = function(msg,icon="4"){
           var index = layer.msg(msg,{
            icon:icon,
            skin: 'layui-layer-molv'
        }); 
      }
      //提示层
      qile.msg = function(msg){
         var index = layer.msg(msg);
      }
      //加载
      qile.load =function(msg){
        var index =layer.msg(msg, {
          icon: 16
          ,shade: 0.01
        });
      }
      // 新窗口打开指定url地址
      qile.open = function(url="",title='信息提示',width='880px',height='90%'){
         var index =  layer.open({
            type: 2,
            title: title,
            shadeClose: true,
            shade: 0.8,
            maxmin: true, //允许全屏最小化
            area: [width,height],
            content:url //iframe的url
          }); 
      }
    qile.alert = function(msg,title=['消息提示'],icon=1,skin='layui-layer-lan'){
    	layer.alert(msg,{icon:icon,
    		btn:false,
    		title:title,
    		skin:skin //样式类名
    	   });
    };


//打开指定窗口信息，常用于编辑，添加等
function edit(url,title="编辑信息",width='880px',height='90%'){
  layer.open({
          type: 2,
          title: title,
          shadeClose:true,
          shade: 0.4,
          maxmin: true, //允许全屏最小化 
          resize:false,
          area: [width,height],
          content: url  //iframe的url
        }); 
}
function add(url,title='添加信息',width='880px',height='90%'){
  layer.open({
          type: 2,
          title: title,
          shadeClose:true,
          shade: 0.4,
          area: [width,height],
          maxmin: true, //允许全屏最小化      
          resize:false,
          content: url  //iframe的url
        }); 
}
//单个删除
function del(url){
  layer.msg('您确定要删除吗？', {
    time: 0 //不自动关闭
    ,btn: ['确定', '取消']
    ,yes: function(index){
      layer.close(index);
            $.get(url,function(json){
                    if(json.code == 0){
                          layer.msg(json.msg);
                            setTimeout(function(){  //使用  setTimeout（）方法设定定时2000毫秒
                            window.location.reload();//页面刷新
                          },1000);
                   }else if(json.code == -1){
                     layer.msg(json.msg, {time: 5000, icon:5});
                   }
               });
    }
  });
}
//新的空白页面打开
function blank(url){
  window.location.href= url;
}
//返回之前页面
function back(){
  javascript:history.go(-1);
}

function audit(obj){
  var url = obj.getAttribute('data-url');
  $.get(url,function(json){
    if(json.code == 0){
      layer.msg(json.msg);
      location.reload();
    }
  });
}