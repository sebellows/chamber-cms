;(function($) {
  /**
   * AJAX in the icon SVG sprite
   */
  $.get(postJS.icons_url, function(data) {
    var div = document.createElement("div");
    div.innerHTML = new XMLSerializer().serializeToString(data.documentElement);
    document.body.insertBefore(div, document.body.childNodes[0]);
  });
})(jQuery);
