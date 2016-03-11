(function ($) {

Drupal.behaviors.ralaway = {

    attach: function (context, settings) {  

    /*---------Start------------*/     

        $('.nav-main li.dropdown').hover(function() {
          $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(200);
        }, function() {
          $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(200);
        });
        

    /*---------End js------------*/

    

    },

  };

})(jQuery);