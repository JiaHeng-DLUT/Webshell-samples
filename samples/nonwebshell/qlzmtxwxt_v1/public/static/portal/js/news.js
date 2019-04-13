/**
 
 @Name: layuiSimpleNews - 极简新闻资讯模板
 @Author: star1029
 @Copyright
 
 */


layui.define(['element', 'form', 'laypage', 'upload', 'carousel'], function(exports){
  var $ = layui.$
  ,element = layui.element
  ,form = layui.form
  ,laypage = layui.laypage
  ,carousel = layui.carousel;

  //头部——点击切换
  // var headNav = $(".news-header").find(".header-nav")
  // $(".news-header").find("#switch").on('click', function(){
  //   if(headNav.hasClass("close")){
  //     $(".news-header").children(".layui-container").height(60 + headNav.height());
  //     headNav.removeClass("close");
  //   }else{
  //     $(".news-header").children(".layui-container").height(50);
  //     headNav.addClass("close");
  //   };
  // });
  $("#logout").on('click',function(){
    var url = $(this).attr('data-url');
    $.get(url,function(json){
         layer.msg(json.msg);
         location.href="/";
    });
  });

  //头部——搜索框
  $(".news-header").find(".header-search").children("input").on('keydown', function(e){
    if(e.keyCode === 13){
      e.preventDefault();  
      var keywords = $("#keywords").val();     
      window.location.href = "/search.html?keywords="+keywords;
    };
  });
  //底部——微信、微博
  $(".news-footer").find("#wechat").hover(
    function(){ $(".news-footer").find("#code").fadeIn(); },
    function(){ $(".news-footer").find("#code").fadeOut(); }
  );
  $(".news-footer").find("#weibo").hover(
    function(){ $(".news-footer").find("#code").fadeIn(); },
    function(){ $(".news-footer").find("#code").fadeOut(); }
  );
  //初始化
  var scrChange = function(){
    var scr = $(document).scrollTop()
    ,height = document.body.offsetHeight - 140 + $(document).scrollTop();  
    if(document.body.clientWidth >= 751){
      $(".news-detail").find("#detail-handel").css("top", scr);
      $("#silde").css("top", height);
    }else{
      $(".news-detail").find("#detail-handel").css("top", 70);
      $("#silde").css("top", "auto");
    }
  }
  ,liAppend = function(){
    var navLi = $(".news-header").find(".header-nav").children(".more").find(".hida");
    if(document.body.clientWidth >= 751){
      $(".news-header").find(".header-nav").children("li").children(".hida").parent("li").remove();
    }else{
      if($(".news-header").find(".header-nav").children("li").children("a").hasClass("hida")){ }
      else{
        navLi.clone().appendTo( $(".news-header").find(".header-nav") ).wrap('<li class="layui-nav-item"></li>');
      }
    }
  };
  $(function(){
    scrChange();
    liAppend();
    $("#silde").children("#refresh").on('click', function(){
      window.location.reload();
    });
    $("#silde").children("#scroll").on('click', function(){
      $("html,body").animate({scrollTop: 0}, 500);
    });
    $(".news-user").find(".userCont").children(".layui-tab-content").find(".article").children("li").each(function(index){
       if(index%2 != 0){
        $(this).addClass("even");
       }
    });
  });
  //侧边栏固定
  $(window).resize(function(){   
    scrChange();
    liAppend();
  });
  window.onscroll = scrChange;
  //首页——轮播
  carousel.render({
    elem: '#newsIndex'
    ,width: '100%'
    ,height: '400px'
    ,arrow: 'none' 
  });
  //详情页——跳转评论
  $(".news-detail").find("#detail-handel").find(".review").on('click', function(){
    var height = $(".news-detail").find(".detail-comment").offset().top - 20;
    $('html,body').animate({scrollTop: height}, 800);
    $(".news-detail").find(".detail-comment").find("textarea").focus();
  });
  //详情页——关注
  $(".news-detail").find(".detail-side").find(".follow").on('click', function(){
    var obj =$(this);
    var uid =obj.attr('data-uid');
    var url =obj.attr('data-url');
    $.post(url,{uid:uid},function(json){
      if(json.code ==0){
        if(obj.html() == '关注'){
                 obj.html('取消关注');
                 obj.addClass('layui-btn-disabled');
                 obj.removeClass('focusOn');
        }else if(obj.html() == '取消关注'){
                 obj.html('关注');
                 obj.removeClass('layui-btn-disabled');
                 obj.addClass('focusOn');
        }
  
      }else{
          layer.msg(json.msg);
      }

    });
    
    
  });
  //详情页——喜欢
  $(".news-detail").find("#detail-handel").find(".collect").on('click', function(){
    var url =$(this).attr('data-url');
    var id = $(this).attr('data-id');
    var  obj = $(this);
      $.post(url,{id:id},function(json){
          if(json.code ==1000){
              //收藏成功
               obj.find("i")[0].style.color = '#F66';
               layer.msg(json.msg);
                var v = obj.find('span').html();
                obj.find('span').html(parseInt(v)+1);
               return;
          }else if(json.code ==1001){
             //取消收藏
               obj.find("i")[0].style.color = '#ccc';
               layer.msg(json.msg);
               var v = obj.find('span').html();
                obj.find('span').html(parseInt(v)-1);
               return;

          }else{
              
               layer.msg(json.msg);
              
               return;
          }

        }); 


  });
  //详情页——回复点赞
  $(".news-detail").find("#replyCont").children("li").each(function(){
    $(this).find("span").filter(".goods").children("i").on('click', function(){
       var obj =$(this);
       var id  =obj.attr('data-id');
       var url =obj.attr('data-url');
       if(!url){
        return;
       }
       // var obj2 =.parents('.goods').find("span").html();
      $.post(url,{id:id},function(json){
          if(json.code ==1000){
             var v =obj.parents('.goods').find("span").html();
             v = parseInt(v)+1; //累加点赞数量
             obj.parents('.goods').find("span").html(v);
             obj.css('color','#fbac81');          
             obj.addClass('layui-btn-disabled');
             obj.removeClass('focusOn');
             layer.msg('已点赞！');
             return;
          }else if(json.code ==1001){
              //取消点赞
         var v =obj.parents('.goods').find("span").html();
             v = parseInt(v)-1; //累加点赞数量
             obj.parents('.goods').find("span").html(v);

             obj.css('color','#d0d0d0');          
             layer.msg('已取消点赞！');
             return;
          }else{



              layer.msg(json.msg);
              return;
          }

        }); 
    
    });
    $(this).find("a").filter(".reply").on('click', function(){
       var reply = $(this);
       var id = $(this).attr('data-pid');
       var url =$(this).attr('data-url');
       var  obj =$(this);
       var  pid = id;
      reply.before('<div class="content content-'+id+'"><textarea placeholder="写下您想说的评论吧..." class="layui-textarea"></textarea><div class="btn"><button class="layui-btn btn-revert-'+id+'"  data-url="'+url+'">回复</button></div></div>')
      reply.parent(".readCom").find(".btn-revert-"+id).on('click', function(){

            var aid = obj.attr('data-aid');
            var url = $(this).attr('data-url');
            var content = $(".content-"+id+" .layui-textarea").val();
            if(aid ==''){
                  layer.msg('回复参数错误！');
                  return;
            }
            if(content ==''){
                  layer.msg('请输入回复内容！');
                  return;
            }
            var param = {aid:aid,pid:pid,content:content};
           $.post(url,param,function(json){
            if(json.code ==0){
                layer.msg(json.msg);
                  location.reload();  
            }else{
                  layer.msg(json.msg);
                
            }
   
           });
     


      });
      reply.hide();
    });
  });
  //详情页——分页
  laypage.render({
    elem: 'detailPage'
    ,count: 50
    ,theme: '#627794'
    ,layout: ['page', 'next']
  });
  //搜索页——时间
  var pushDate = new Date()
  ,pushDateYear = pushDate.getFullYear()
  ,pushDateMon = pushDate.getMonth() + 1
  ,pushDateDay = pushDate.getDate()
  ,pushDateHour = pushDate.getHours()
  ,pushDateMin = pushDate.getMinutes()
  $(".news-search").find(".pushTime").html(pushDateYear + '-' + pushDateMon + '-' + pushDateDay + ' ' + pushDateHour + ':' + pushDateMin)
  //搜索页——关注
  $(".news-search").find(".userList").find(".focusOn").each(function(){
    $(this).on('click', function(){
      layer.msg('关注成功！');
      this.innerHTML = '已关注';
    });
  })
  //登录页——弹框
  $(".news-login").find("#getCode").on('click', function(){
    layer.msg('验证码已发送');
  });
  form.on('submit(newsLogin)', function(data){
    window.location.href = "user.html";
  });
  //个人中心——分页——评论
  laypage.render({
    elem: 'userComPage'
    ,count: 50
    ,theme: '#627794'
    ,layout: ['page', 'next']
  });
  //个人中心——分页——文章
  laypage.render({
    elem: 'userArtPage'
    ,count: 50
    ,theme: '#627794'
    ,layout: ['page', 'next']
     ,curr:"{$Request.param.page}" //获取起始页
   // ,hash: 'page' //自定义hash值
   ,jump: function(obj, first){
   
    // //obj包含了当前分页的所有参数，比如：
    // console.log(obj.curr); //得到当前页，以便向服务端请求对应页的数据。
    // console.log(obj.limit); //得到每页显示的条数
 
    //首次不执行
    if(!first){
     var page = "{$Request.param.page}";
    if(obj.curr != page){
       location.href="?page="+obj.curr;
    }
   
    }
  }
  });
  //个人中心——发表新闻
  $(".news-user").find("#pushNews").on('click', function(){
    layer.open({
      type: 2
      ,title: '发布文章'
      ,area: ['720px', '660px']
      ,offset: '170px'
      ,shade: 0.7
      ,skin: 'news-pushCont'
      ,content: 'iframe.html'
      ,success: function(layero, index){
        window['layui-layer-iframe'+ index].layui.form.on('submit(publishNews)', function(data){
          layer.close(index);
        });  
      }
    });
  });
  //个人中心——删除文章
  var userArt =  $(".news-user").children(".userCont").children(".layui-tab-content").find(".article");
  $(".news-user").find("#upDel").on('click', function(){
    $(".news-user").find("#batchDel").toggle();
    $(".news-user").find("#cancelDel").toggle();
    userArt.children("li").each(function(){
      $(this).children(".layui-form-checkbox").toggle();
    });
  });
  $(".news-user").find("#cancelDel").on('click', function(){
    $(".news-user").find("#batchDel").toggle();
    $(".news-user").find("#cancelDel").toggle();
    userArt.children("li").each(function(){
      $(this).children("input")[0].checked = false;
      $(this).children(".layui-form-checkbox").hide();
    });
    form.render('checkbox');
  });
  $(".news-user").find("#batchDel").on('click', function(){
    userArt.children("li").each(function(){
      if($(this).children(".layui-form-checkbox").hasClass("layui-form-checked")){
        $(this).remove();
      }
    });
    userArt.children("li").each(function(index){
      $(this).removeClass("even");
      if(index%2 != 0){
        $(this).addClass("even");
      }
    });
  });
  exports('news', {}); 
})