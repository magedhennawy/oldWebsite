$(document).ready(function($) {
  fadeOnScroll();
  smartNavbar();
  mainNavTrigger();
  // var lastScrollTop = 0;
  // var st = 0;
  // var fade = $('.fade');
  // $(window).scroll(function(event) {
  //   st = $(this).scrollTop();
  //   console.log(st);
  //   if (st > 0) {
  //     fade.css({
  //       "opacity": ((1 / st) * 100).toString()
  //     });
  //
  //   }
  //   lastScrollTop = st;
  // });

  function smartNavbar () {
    var lastScrollTop = 0;
    var scrollDirectionCounter = 0;
    window.addEventListener("scroll", function(){ // or window.addEventListener("scroll"....
      var st = window.pageYOffset || document.documentElement.scrollTop; // Credits: "https://github.com/qeremy/so/blob/master/so.dom.js#L426"
      if (st > lastScrollTop && scrollDirectionCounter < 0) {
        scrollDirectionCounter = 0;
      } else if (st < lastScrollTop && scrollDirectionCounter > 0) {
        scrollDirectionCounter = 0;
      }
      if (st > lastScrollTop) {
        scrollDirectionCounter++;
      } else {
        scrollDirectionCounter--
      }
      if (st >= 40) {
        if (st >= 250) {
          $('nav').addClass('detached');
        } else if (st >= 250 && st > lastScrollTop ) {
          $('nav').removeClass('detached');
        }
        if (st > lastScrollTop && Math.abs(scrollDirectionCounter) > 30){
          $('nav').addClass('hidden');
          $('nav').removeClass('visible');
        } else if (st < lastScrollTop && Math.abs(scrollDirectionCounter) > 30) {
          $('nav').removeClass('hidden');
          $('nav').addClass('visible');
        }
      } else {
        $('nav').removeClass('hidden');
        $('nav').addClass('visible');
      }
      if (st <= 0) {
        $('nav').removeClass('detached');
      };
      console.log(scrollDirectionCounter);
      lastScrollTop = st;
    }, false);
  }

  function mainNavTrigger() {
    $('.main-nav-trigger').mouseover(function() {
      $('nav').removeClass('hidden');
      $('nav').addClass('visible');
    });
    $('.main-nav-trigger').mousedown(function() {
      $('nav').removeClass('hidden');
      $('nav').addClass('visible');
    });
  }


  function fadeOnScroll () {
    $(window).load(function() {
      $(".intro h1").addClass("animated fadeInUp");
    });

    // var lastScrollTop = 0;
    // var st = 0;
    // var scrollBottom = 0;
    // var fade = $('.fadeScroll');
    $(window).scroll(function() {
    //   st = $(this).scrollTop();
    //   scrollBottom = $(window).scrollTop() + $(window).height();
    //   console.log(fade.offset().top);
    //   console.log(scrollBottom);
    //   if (fade.scrollTop() < scrollBottom-300) {
    //     fade.addClass("animated fadeInUp");
    
    //   }
    //   lastScrollTop = st;
      $('.fadeScroll').each(function(index){
        var top = $(window).scrollTop();
        var imagePos = $(this).offset().top;

        if (imagePos < top+500) {
          $(this).addClass("animated fadeInUp");;
        }
      });
    });


  }
});
