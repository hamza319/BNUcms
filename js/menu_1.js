var main = function() {
  /* Push the body and the nav over by 285px over */
  $('#menuMain').on('mouseenter',function() {
    $('.menu').animate({
      left: "0px"
    }, 200);

    $('.main').animate({
      left: "200px"
    }, 200);
    
    $('.icon-menu').animate({
      left: "200px"
    }, 200);
  }).on('mouseleave', function(){
      $('.menu').animate({
      left: "-200px"
    }, 200);

    $('.main').animate({
      left: "0px"
    }, 200);
    
    $('.icon-menu').animate({
      left: "0px"
    }, 200);
  });
  
  };
$(document).ready(main);