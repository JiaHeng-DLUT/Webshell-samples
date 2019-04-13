$(document).ready(function() {
 //大视窗看图
    function mouseEnter(e) {
        if ($("#winSelector").css("display") == "none") {
            $("#winSelector,#bigView").show(); 

               //console.log($("#bigView img").width());

        }

        $("#winSelector").css(fixedPosition(e));
        e.stopPropagation();
    }

    //    function mouseMove(e) {
    //        $("#winSelector").css(fixedPosition(e));
    //        e.stopPropagation();
    //    }

    function mouseOut(e) {
        if ($("#winSelector").css("display") != "none") {
            $("#winSelector,#bigView").hide();
        }
        e.stopPropagation();
    }


    $("#large_imgmid").mouseenter(mouseEnter); //中图事件
    $("#large_imgmid,#winSelector").mousemove(mouseEnter).mouseout(mouseOut); //选择器事件

    var $divWidth = $("#winSelector").width(); //选择器宽度
    var $divHeight = $("#winSelector").height(); //选择器高度
    var $imgWidth = $("#large_imgmid").width(); //中图宽度
    var $imgHeight = $("#large_imgmid").height(); //中图高度
    var $viewImgWidth = $viewImgHeight = $height = null; //IE加载后才能得到 大图宽度 大图高度 大图视窗高度



   // function changeViewImg() {
       // $("#bigView img").attr("src", $("#large_imgmid").attr("src").replace("mid", "big"));
   // }
   // changeViewImg();

    $("#bigView").scrollTop(0);
    function fixedPosition(e) {
        if (e == null) {
            return;
        }
       var $imgLeft = $("#large_imgmid").offset().left; //中图左边距
       var $imgTop = $("#large_imgmid").offset().top; //中图上边距

		//	var append = '<p>'+$imgTop+'-left:'+$imgLeft+'</p>';

//$("#vertical").append(append);


        X = e.pageX - $imgLeft - $divWidth / 2; //selector顶点坐标 X
        Y = e.pageY - $imgTop - $divHeight / 2; //selector顶点坐标 Y
        X = X < 0 ? 0 : X;
        Y = Y < 0 ? 0 : Y;
        X = X + $divWidth > $imgWidth ? $imgWidth - $divWidth : X;
        Y = Y + $divHeight > $imgHeight ? $imgHeight - $divHeight : Y;



   
            $viewImgWidth = $("#bigView img").outerWidth();
            $viewImgHeight = $("#bigView img").height();
            if ($viewImgWidth < 600 || $viewImgHeight < 600) {
                $viewImgWidth = $viewImgHeight = 600;
            }
			 
			else if ($viewImgWidth > 1100 || $viewImgHeight > 1100) {
                $viewImgWidth = $viewImgHeight = 1500;
            }
			
			else if ($viewImgWidth > 900 || $viewImgHeight > 900) {
                $viewImgWidth = $viewImgHeight = 1100;
            }
			
			else if ($viewImgWidth > 700 || $viewImgHeight > 700) {
                $viewImgWidth = $viewImgHeight = 1000;
            }
			
			
			
			// console.log($("#bigView img").width());
			
			// console.log($viewImgWidth);
			
            $height = $divHeight * $viewImgHeight / $imgHeight;
           // $("#bigView").width($divWidth * $viewImgWidth / $imgWidth);
           // $("#bigView").height($height);
        

        var scrollX = X * $viewImgWidth / $imgWidth;
        var scrollY = Y * $viewImgHeight / $imgHeight;
		

 
        $("#bigView img").css({ "left": scrollX * -1, "top": scrollY * -1 });
        //确定上边距
        //用户视窗高度
        var viewH = document.documentElement.clientHeight == 0 ? document.body.clientHeight : document.documentElement.clientHeight;
        var top = ((viewH - $height) / 2) + $(document).scrollTop();
        top = top < 360 ? 360 : top;
        var left = 530;
        if ($(window).width() > $(document.body).width()) {
            //left = left - (($(window).width() - $(document.body).width()) / 2);
        }
        //$("#bigView").css({ "top": top, "left": left });


 
		// var append = '<p>'+X+'-y:'+Y+'</p>';

 //$("#vertical").append(append);

        return { left: X, top: Y };
    }
});







 
 $(function() {
    $(".large_list_inc").jCarouselLite({
        btnNext: "#next",
        btnPrev: "#prev", 
		 circular:false,
	 visible: 5
	 
    });

$(".large_list_inc img").mouseover(function() {
 
    $("#large_imgmid img").attr("src", $(this).data("imgmid"));
	 $("#bigView img").attr("src", $(this).data("imgbig"));
})
//-----

$(".large_list_inc img").eq(0).addClass("hover");
$(".large_list_inc img").hover(
  function () {
    $(".large_list_inc img").removeClass("hover");
    $(this).addClass("hover");
	 $("#large_imgmid img").attr("src", $(this).attr("name"));
  },
  function () { 
  }
); 

});//end func
 
 