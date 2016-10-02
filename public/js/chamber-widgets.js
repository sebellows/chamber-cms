;(function ($) {

  "use strict";

  jQuery('input[name*="show_thumb"]').on('click', function() {
    if ( jQuery(this).is(':checked') ) {
      jQuery(this).parent().next(jQuery('p')).show();
    }
    else {
      jQuery(this).parent().next(jQuery('p')).hide();
    }
  });

})();
