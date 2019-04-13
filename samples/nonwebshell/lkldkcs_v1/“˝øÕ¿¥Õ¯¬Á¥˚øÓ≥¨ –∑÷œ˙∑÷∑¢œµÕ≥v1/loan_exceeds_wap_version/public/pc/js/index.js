
window.onload = function () {
    //初始化 swiper
    var mySwiper = new Swiper('.swiper-container', {
        autoplay: {
            stopOnLastSide: true
        },
        loop: true, // 循环模式选项
        // 如果需要分页器
        pagination: {
            el: '.swiper-pagination',
        },
    })
   
  cutActiveClass(".loans-lf-nav li", "active");
  cutActiveClass("#dlist li", "active");
  cutActiveClass("#qlist li", "active");
}

function cutActiveClass(dom, className){
 $(dom).click(function (e) {
     $(dom).removeClass(className);
     $(this).addClass(className);
 })
}