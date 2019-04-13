 


$(function(){
 
	coolmb001faq();
	coolmb001Slider();
})


		
	  function coolmb001faq() {  
	  
	     $('.faq').each(function () {
             $(this).find('.single-item').on('click', function () {
                $(this).find('.content').slideToggle();
                $(this).toggleClass('active');
            });
        });

	  }	  
  function coolmb001Slider() { 
       
            heroSlider = $('.hero-slider');
            heroSlider.addClass('owl-carousel');
            heroSlider.owlCarousel({
                items: 1,
                autoplay: true,
                animateIn: 'fadeIn',
                animateOut: 'fadeOutLeft',
                loop: true,
                autoplayHoverPause: true,
                nav: true,
                autoHeight:true,
                navText: [
                    '<i class="fa fa-angle-left"></i>',
                    '<i class="fa fa-angle-right"></i>'
                ]
            });

            tstSlider = $('.testimonial-slider');
            tstSlider.addClass('owl-carousel');
            tstSlider.owlCarousel({
                items: 3,
                autoplay: true,
                loop: true,
                margin: 30,
                dots: false,
                nav: true,
                navText: [
                    '<i class="fa fa-arrow-left"></i>',
                    '<i class="fa fa-arrow-right"></i>'
                ],
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    992: {
                        items: 3
                    }
                }
            });
       
    } 


 







