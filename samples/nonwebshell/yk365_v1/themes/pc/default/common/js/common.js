// 搜索js
$(function(){
  $(".search-head li").on("click",function(){
      $(this).children('a').addClass("blue-bg");
      $(this).siblings("li").children('a').removeClass('blue-bg');
  });	
});

$(function(){
  // .search-title:hover .search-other{display:block;cursor:pointer;} 
  $(".search-title").on("mouseover",function(){
     $(".search-other").show();
     return false;
  });
    $(".search-title").on("mouseout",function(){
     $(".search-other").hide();
     return false;
  });
});

$(function(){
     
// 设置初始化搜索方式：
         var v= $("#mod").attr('name');
            if(v){
            $("#mod").val('search');
            $("#type").val('name');
           }else{
              $(".search-keywords").before('<input name="mod" type="hidden" id="mod" value="search" /><input name="type" type="hidden" id="type" value="name" />');
           }
          
         $(".keywords").attr("name","query");
         $(".search_form1").attr("action","/home/search.html");



	    $(".search-other li").on("click",function(){
     var name = $(this).attr("data-name");
      var s = $(this).html();
     $(".search-title h4").html(s);
     $(".search-title h4").attr("data-name",name);

     if(name == 'baidu'){
         $(".search_form1").attr("action","https://www.baidu.com/baidu");
         $(".keywords").attr("name","word");
         $(".submit").val('百度一下');
         $(".search-head li").eq(0).attr('data-cate','webpage').find('a').html('网页');
         $(".search-head li").eq(1).attr('data-cate','news').find('a').html('新闻');
         $(".search-head li").eq(2).attr('data-cate','video').find('a').html('视频');
         $(".search-head li").eq(3).attr('data-cate','image').find('a').html('图片');
         $(".search-head li").eq(4).attr('data-cate','music').find('a').html('音乐');
         $(".search-head li").eq(5).attr('data-cate','zhidao').find('a').html('知道');
         $(".search-head li").eq(6).attr('data-cate','wenku').find('a').html('文库');
          $(".search-other").hide();
      }else if(name =='360'){
      	 $(".keywords").attr("name","q");
         $(".submit").val('搜一下');
         $(".search_form1").attr("action","http://www.so.com/s");
         $(".search-head li").eq(0).attr('data-cate','webpage').find('a').html('网页');
         $(".search-head li").eq(1).attr('data-cate','news').find('a').html('新闻');
         $(".search-head li").eq(2).attr('data-cate','video').find('a').html('视频');
         $(".search-head li").eq(3).attr('data-cate','image').find('a').html('图片');
         $(".search-head li").eq(4).attr('data-cate','music').find('a').html('音乐');
         $(".search-head li").eq(5).attr('data-cate','wenda').find('a').html('问答');
         $(".search-head li").eq(6).attr('data-cate','liangyi').find('a').html('良医');
          $(".search-other").hide();
      }else if(name =='sogo'){
      	 $(".keywords").attr("name","query");
         $(".submit").val('搜狗搜索');
         $(".search_form1").attr("action","http://www.sogou.com/web");
         $(".search-head li").eq(0).attr('data-cate','webpage').find('a').html('网页');
         $(".search-head li").eq(1).attr('data-cate','news').find('a').html('新闻');
         $(".search-head li").eq(2).attr('data-cate','video').find('a').html('视频');
         $(".search-head li").eq(3).attr('data-cate','image').find('a').html('图片');
         $(".search-head li").eq(4).attr('data-cate','music').find('a').html('音乐');
         $(".search-head li").eq(5).attr('data-cate','weixin').find('a').html('微信');
         $(".search-head li").eq(6).attr('data-cate','zhihu').find('a').html('知乎');
          $(".search-other").hide();
      }else if(name =='site'){
        $(".submit").val('搜 索');
        var v= $("#mod").attr('name');
            if(v){
            $("#mod").val('search');
            $("#type").val('name');
           }else{
              $(".search-keywords").before('<input name="mod" type="hidden" id="mod" value="search" /><input name="type" type="hidden" id="type" value="name" />');
           }
          
         $(".keywords").attr("name","query");
         $(".search_form1").attr("action","/home/search.html");
       
         $(".search-head li").eq(0).attr('data-cate','name').find('a').html('网站名称');
         $(".search-head li").eq(1).attr('data-cate','siteurl').find('a').html('网站地址');
         $(".search-head li").eq(2).hide();
         $(".search-head li").eq(3).hide();
         $(".search-head li").eq(4).hide();
         $(".search-head li").eq(5).hide();
         $(".search-head li").eq(6).hide();
          $(".search-other").hide();
      }

	});

});
$(function(){
	$(".search-head li").on("click",function(){
   var name = $(".search-title h4").attr("data-name");
   var  a = $(this).index();
    if(name =='baidu'){

       if(a == 0){
       	//网页
         $(".search_form1").attr("action","https://www.baidu.com/baidu");
       }else if(a == 1){
       	//新闻
         $(".search_form1").attr("action","http://news.baidu.com/ns");
       }else if(a == 2){
        //视频
       	$(".search_form1").attr("action","http://v.baidu.com/v");
       }
       else if(a == 3){
       	//图片
       	 $(".search_form1").attr("action","http://image.baidu.com/search/index?tn=baiduimage");
       }
       else if(a == 3){
       	//音乐
       	$(".search_form1").attr("action","http://mp3.baidu.com/m");
       }else if(a == 4){
       	//知道
       	$(".search_form1").attr("action","https://zhidao.baidu.com/search");
       }else if(a == 5){
       	//文库
       	$(".search_form1").attr("action","https://wenku.baidu.com/search");
       }
    }else if(name =='360'){
       if(a == 0){
       	//网页
         $(".search_form1").attr("action","http://www.so.com/s");
       }else if(a == 1){
       	//新闻
         $(".search_form1").attr("action","http://news.so.com/ns");
       }else if(a == 2){
        //视频
       	$(".search_form1").attr("action","http://video.so.com/v");
       }else if(a == 3){
       	//图片
       	 $(".search_form1").attr("action","http://image.so.com/i");
       }else if(a == 4){
       	//音乐
       	$(".search_form1").attr("action","http://s.music.so.com/s");
       }else if(a == 5){
       	//问答
       	$(".search_form1").attr("action","http://wenda.so.com/search");
       }else if(a == 5){
       	//良医
       	$(".search_form1").attr("action","http://ly.so.com/s");
       }



    }else if(name =='sogo'){
       if(a == 0){
       	//网页
         $(".search_form1").attr("action","http://www.sogou.com/web");
       }else if(a == 1){
       	//新闻
         $(".search_form1").attr("action","http://news.sogou.com/news");
       }else if(a == 2){
        //视频
       	$(".search_form1").attr("action","http://v.sogou.com/v");
       }else if(a == 3){
       	//图片
       	 $(".search_form1").attr("action","http://pic.sogou.com/pics");
       }else if(a == 4){
       	//音乐
       	$(".search_form1").attr("action","http://news.sogou.com/news");
       }else if(a == 5){
       	//微信
       	$(".search_form1").attr("action","http://weixin.sogou.com/weixin");
       }else if(a == 6){
       	//知乎
       	$(".search_form1").attr("action","http://zhihu.sogou.com/zhihu");
       }
    }else if(name =='site'){
      if(a == 0){
            $("#mod").val('search');
            $("#type").val('name');
        
       }else if(a == 1){
            $("#mod").val('search');
            $("#type").val('url');
      
       }else if(a == 2){
            $("#mod").val('search');
            $("#type").val('tags');
       
       }else if(a == 3){
            $("#mod").val('search');
            $("#type").val('intro');
       
       }

    }

});
});
// 返回顶部
$(function(){
  $('#roll_top').hide();
  $(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
      $('#roll_top').fadeIn(0);//当滑动栏向下滑动时，按钮渐现的时间
    } else {
      $('#roll_top').fadeOut(0);//当页面回到顶部第一屏时，按钮渐隐的时间
    }
  });
  $('#roll_top').click(function () {
    $('html,body').animate({
      scrollTop : '0px'
    }, 500);//返回顶部所用的时间 返回顶部也可调用goto()函数
  });
});
function goto(selector){
  $.scrollTo ( selector , 1000);  
};





// 首页左侧图片轮播
$(function(){
        var $banner=$('.banner');
        var $banner_ul=$('.banner-img');
        var $btn=$('.banner-btn');
        var $btn_a=$btn.find('a')
        var v_width=$banner.width();
        
        var page=1;
        
        var timer=null;
        var btnClass=null;

        var page_count=$banner_ul.find('li').length;//把这个值赋给小圆点的个数
        
        var banner_cir="<li class='selected' href='#'><a></a></li>";
        for(var i=1;i<page_count;i++){
                //动态添加小圆点
                banner_cir+="<li><a href='#'></a></li>";
                }
        $('.banner-circle').append(banner_cir);
        
        var cirLeft=$('.banner-circle').width()*(-0.5);
        $('.banner-circle').css({'marginLeft':cirLeft});
        
        $banner_ul.width(page_count*v_width);
        
        function move(obj,classname){
                //手动及自动播放
        if(!$banner_ul.is(':animated')){
                if(classname=='prevBtn'){
                        if(page==1){
                                        $banner_ul.animate({left:-v_width*(page_count-1)});
                                        page=page_count; 
                                        cirMove();
                        }
                        else{
                                        $banner_ul.animate({left:'+='+v_width},"slow");
                                        page--;
                                        cirMove();
                        }        
                }
                else{
                        if(page==page_count){
                                        $banner_ul.animate({left:0});
                                        page=1;
                                        cirMove();
                                }
                        else{
                                        $banner_ul.animate({left:'-='+v_width},"slow");
                                        page++;
                                        cirMove();
                                }
                        }
                }
        }
        
        function cirMove(){
                //检测page的值，使当前的page与selected的小圆点一致
                $('.banner-circle li').eq(page-1).addClass('selected')
                 .siblings().removeClass('selected');
        }
        
        $banner.mouseover(function(){
                $btn.css({'display':'block'});
                clearInterval(timer);
                                }).mouseout(function(){
                $btn.css({'display':'none'});                
                clearInterval(timer);
                timer=setInterval(move,3000);
                                }).trigger("mouseout");//激活自动播放

        $btn_a.mouseover(function(){
                //实现透明渐变，阻止冒泡
                        $(this).animate({opacity:0.6},'fast');
                        $btn.css({'display':'block'});
                         return false;
                }).mouseleave(function(){
                        $(this).animate({opacity:0.3},'fast');
                        $btn.css({'display':'none'});
                         return false;
                }).click(function(){
                        //手动点击清除计时器
                        btnClass=this.className;
                        clearInterval(timer);
                        timer=setInterval(move,3000);
                        move($(this),this.className);
                });
                
        $('.banner-circle li').on('click',function(){
                        var index=$('.banner-circle li').index(this);
                        $banner_ul.animate({left:-v_width*index},'slow');
                        page=index+1;
                        cirMove();
                });
});

// 首页左侧导航js
$(function(){

    //关注
    $('.jb').mouseover(function(){
      $("#jb-content").show();
    });
    $('.applist').mouseout(function(){
      $("#jb-content").hide();
    });
});


  $(function(){
  $('.btn').click(function(){
    var side = $(".sidebarContent").offset().left;
    if(side==0){
           $(".sidebarContent").animate({left:"-50px"});
    }else{
           $(".sidebarContent").animate({left:"0"});   
        }
  });
  })


//评论js
$(function(){
  $(".youke_fb").on("click",function(){
    var id = $(this).attr('data-id');
    var content = $('.youke_content').val();
    var type = $(this).attr('data-type');
    var mod = $(this).attr('data-mod');
     $.ajax({
       type:"post",
       url:"?mod=ajax",
       data:{id:id,content:content,type:type,mod:mod},
       success:function(json){
         if(json.status == 1){
           layer.msg(json.msg);
           location.reload();
         }else{
           layer.alert(json.msg);
         }
       },
       dataType:'json',
     });
  });
});



//客服代码
$(function(){
    $("#aFloatTools_Show").click(function(){
      $('#divFloatToolsView').animate({width:'show',opacity:'show'},100,function(){$('#divFloatToolsView').show();});
      $('#aFloatTools_Show').hide();
      $('#aFloatTools_Hide').show();        
    });
    $("#aFloatTools_Hide").click(function(){
      $('#divFloatToolsView').animate({width:'hide', opacity:'hide'},100,function(){$('#divFloatToolsView').hide();});
      $('#aFloatTools_Show').show();
      $('#aFloatTools_Hide').hide();  
    });
  });








