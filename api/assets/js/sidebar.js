
if (typeof jQuery === 'undefined') { throw new Error('Social\'s JavaScript requires jQuery'); }

(function($, window, document, undefined) {
  "use strict";

  /* Create the defaults once */
  var SocialSidebar, defaults, pluginName, winWidth;
  pluginName = "socialSidebar";
  defaults = {
    toggle: ".social-navbar .navbar-toggle",
    position: "front",
    reducedWidth: "54px",
    expandedWidth: "200px",
    duration: 200
  };

  /* The actual plugin constructor */
  SocialSidebar = function(element, options) {
    this.settings = $.extend({}, defaults, options);
    this._defaults = defaults;
    this._name = pluginName;
    this.elem = element;
    this.$elem = $(element);
    this.isRTL = $("html").is("[dir]");
    this.HTMLDirAttr = $("html").attr("dir");
    if (typeof this.HTMLDirAttr === "undefined") {
      this.isRTL = false;
    } else {
      this.isRTL = this.HTMLDirAttr.toLowerCase() === "rtl";
    }
    this.init();
  };

  /* */
  SocialSidebar.prototype = {
    init: function() {

      /* Define variables */
      this.$body = $(document.body);
      this.toggle = this.settings.toggle;
      this.$toggle = $(this.settings.toggle);

      /* Call some function */
      this.handleSidebarToggle();
      this.handleAccordionMenu();
      this.handleScrollMenu();
      this.handleHoverSidebar();
      this.handleSidebarChat();
    },

    /* Handle Sidebar for reducing it or expanding it */
    handleSidebarToggle: function() {
      var that;
      that = this;
      $(".main").click(function() {
        if ((winWidth() <= 768) && (that.$body.hasClass("sidebar-offcanvas-front"))) {
          that.$toggle.trigger("click");
        }
      });
      this.$toggle.click(function() {
        var sidebarPosition;
        that.$elem.find(".menu ul.collapse").removeClass("in");
        that.$elem.find(".menu a[data-toggle='collapse']").closest("li").removeClass("open");
        if (winWidth() >= 768) {
          if (that.$body.hasClass("reduced-sidebar")) {
            that.$body.removeClass("reduced-sidebar");
            $(".social-navbar .navbar-header").css("width", "");
            that.$elem.css("width", "");
          } else {
            that.$body.addClass("reduced-sidebar");
          }
        } else {
          if (that.settings.position === "next") {
            sidebarPosition = "sidebar-offcanvas-next";
          } else {
            sidebarPosition = "sidebar-offcanvas-front";
          }
          that.$body.toggleClass(sidebarPosition);
        }
      });
    },

    /* Handle accordion effect for multi-level elements */
    handleAccordionMenu: function() {
      this.$elem.find(".menu ul.in").css("height", "auto");
      $(".menu a[data-toggle='collapse']").on("click", function(e) {
        e.preventDefault();
        $(this).closest("li").toggleClass("open").children("ul").collapse("toggle");
        $(this).closest("li").siblings().removeClass("open").children("ul.in").collapse("hide");
      });
    },

    /* Handle scroll behavior */
    handleScrollMenu: function() {
      var chatHeight, that;
      that = this;
      if (that.$elem.find(".chat").css('display') === "none") {
        chatHeight = 0;
      } else {
        chatHeight = that.$elem.find(".chat").height();
      }
      this.$elem.find(".social-sidebar-content").slimScroll({
        height: (that.$elem.height() - chatHeight) + "px",
        position: (that.isRTL ? "left" : "right")
      });
      $(window).resize(function() {
        var currentHeight;
        if (that.$elem.find(".chat").css('display') === "none") {
          chatHeight = 0;
        } else {
          chatHeight = that.$elem.find(".chat").height();
        }
        currentHeight = that.$elem.height() - chatHeight;
        that.$elem.find("> .slimScrollDiv").css("height", currentHeight + "px");
        that.$elem.find("> .slimScrollDiv > .social-sidebar-content").css("height", currentHeight + "px");
      });
    },

    /* Handle reduced sidebar mode visualization when mouse enters it and leaves it */
    handleHoverSidebar: function() {
      var that;
      that = this;
      this.$elem.off("mouseenter").on("mouseenter", function() {
        if (that.$body.hasClass("reduced-sidebar") && (winWidth() >= 768)) {

          /* */
          $(".social-navbar .navbar-header").stop().animate({
            width: that.settings.expandedWidth
          }, that.settings.duration);

          /* */
          that.$elem.stop().animate({
            width: that.settings.expandedWidth
          }, that.settings.duration, function() {
            var delay;
            delay = setTimeout(function() {
              that.$elem.addClass("on");
            }, that.settings.duration / 4);
          });
        }
      });
      this.$elem.off("mouseleave").on("mouseleave", function() {
        if (that.$body.hasClass("reduced-sidebar") && (winWidth() >= 768)) {

          /* */
          $(".social-navbar .navbar-header").stop().animate({
            width: that.settings.reducedWidth
          }, that.settings.duration);

          /* */
          that.$elem.find(".menu ul.collapse").removeClass("in");
          that.$elem.find(".menu li.open").removeClass("open");
          that.$elem.find(".user").removeClass("open");
          that.$elem.removeClass("on").stop().animate({
            width: that.settings.reducedWidth
          }, that.settings.duration, function() {
            that.$elem.removeClass("on");
          });
        }
      });
    },

    /* Handle interaction for the char section */
    handleSidebarChat: function() {
      var chatScrollOptions, that, usersChat;
      usersChat = this.$elem.find(".chat");
      that = this;
      chatScrollOptions = {
        height: usersChat.find(".users-list").height(),
        size: "8px",
        railColor: "#000",
        wheelStep: 15,
        position: (that.isRTL ? "left" : "right")
      };
      usersChat.find(".users-list").slimscroll(chatScrollOptions);

      /* */
      if (!$().resizable) {
        return;
      }
      usersChat.resizable({
        handles: "n",
        maxHeight: 400,
        minHeight: 110,
        resize: function(event, ui) {
          var currentHeight, padding;
          currentHeight = ui.size.height;
          padding = 3;
          $(this).height(currentHeight);
          $(this).css("top", "auto");
          usersChat.find(".slimScrollDiv, .users-list").height(currentHeight - 70);
          that.$elem.find("> .slimScrollDiv").height($(window).height() - currentHeight - padding);
          that.$elem.find(".social-sidebar-content").height($(window).height() - currentHeight - padding);
        }
      });
    }
  };

  /* Some action when the user resize the windows of the browser */
  $(window).resize(function() {
    if (winWidth() < 768) {
      if ($(document.body).hasClass("reduced-sidebar")) {
        $(document.body).removeClass("reduced-sidebar");
      }
    }
    $(".social-sidebar, .navbar-header").css("width", "");
  });

  /* Cross browser window width
      *Borrowed from jRespond source code
   */
  winWidth = function() {
    var w;
    w = 0;
    if (typeof window.innerWidth !== "number") {
      if (document.documentElement.clientWidth !== 0) {
        w = document.documentElement.clientWidth;
      } else {
        w = document.body.clientWidth;
      }
    } else {
      w = window.innerWidth;
    }
    return w;
  };
  $.fn[pluginName] = function(options) {
    return this.each(function() {
      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new SocialSidebar(this, options));
      }
    });
  };
})(jQuery, window, document);
