;(function($) {
  /**
   * AJAX in the icon SVG sprite
   */
  $.get("/app/plugins/chamber-cms/resources/assets/icons/sprite.svg", function(data) {
    var div = document.createElement("div");
    div.innerHTML = new XMLSerializer().serializeToString(data.documentElement);
    document.body.insertBefore(div, document.body.childNodes[0]);
  });
})(jQuery);
