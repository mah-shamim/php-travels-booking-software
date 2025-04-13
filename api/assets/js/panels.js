/*!
 * Product:        Social - Premium Responsive Admin Template
 * Version:        2.1.3
 * Copyright:      2015 cesarlab.com
 * License:        http://themeforest.net/licenses
 * Live Preview:   http://go.cesarlab.com/SocialAdminTemplate2
 * Purchase:       http://go.cesarlab.com/PurchaseSocial2
 */
if (typeof jQuery === 'undefined') { throw new Error('Social\'s JavaScript requires jQuery'); }

(function($, window, document, undefined) {
  "use strict";
  $.fn.extend({
    panels: function(options) {
      var settings;
      this.defaultOptions = {};
      settings = $.extend({}, this.defaultOptions, options);
      return this.find(".panel").each(function() {
        var $body, $parent, $this;
        $this = $(this);
        $parent = $this.closest(".panel");
        $body = $parent.find(".panel-body");

        /* Handle Collapse action */
        $parent.find(".panel-tools [data-option=\"collapse\"]").click(function(e) {
          var icons;
          e.preventDefault();
          if ($(this).hasClass("fa")) {
            icons = ["fa-chevron-down", "fa-chevron-up"];
          } else if ($(this).hasClass("glyphicon")) {
            icons = ["glyphicon-chevron-down", "glyphicon-chevron-up"];
          } else if ($(this).hasClass("halflings")) {
            icons = ["chevron-down", "chevron-up"];
          }
          if ($(this).hasClass(icons[1])) {
            $(this).removeClass(icons[1]).addClass(icons[0]);
            $body.slideDown("200", function() {});
          } else {
            $(this).removeClass(icons[0]).addClass(icons[1]);
            $body.slideUp("200", function() {});
          }
        });

        /* Handle Remove action */
        $parent.find(".panel-tools [data-dismiss=\"panel\"]").click(function(e) {
          e.preventDefault();
          $parent.remove();
        });
      });
    }
  });
})(jQuery, window, document);
