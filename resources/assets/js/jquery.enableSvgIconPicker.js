;(function($) {

  /**
   * Add the icon picker to the Advanced Custom Field input.
   * 
   * @param  obj $el the input to add the icon picker to.
   * @return `svgIconPicker`
   */
  function enableSvgIconPickerFor($el) {
    $el.find('.acf-svgiconpicker').each(function(){
      if ( !$(this).parents('.acf-clone').length ){
        $(this).svgIconPicker();   
      }
    });
  }

  if (typeof acf == 'function') {
    acf.add_action('ready append', function( $el ){
      enableSvgIconPickerFor($el);
    });
  }

})(jQuery);
