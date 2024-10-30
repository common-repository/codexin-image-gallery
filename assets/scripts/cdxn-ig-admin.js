"use strict";

(function ($) {
  'use strict';
  /**
   * All of the code for your Dashboard-specific JavaScript source
   * should reside in this file.
   *
   * Note that this assume you're going to use jQuery, so it prepares
   * the $ function reference to be used within the scope of this
   * function.
   *
   * From here, you're able to define handlers for when the DOM is
   * ready:
   *
   * $(function() {
   *
   * });
   *
   * Or when the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and so on.
   *
   * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
   * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
   * be doing this, we should try to minimize doing that in our own work.
   */

  function copyToClipboard(selector) {
    var str = selector.value;
    var tooltip = selector.previousElementSibling;
    var el = document.createElement('textarea');
    el.value = str;
    el.setAttribute('readonly', '');
    el.style.position = 'absolute';
    el.style.left = '-9999px';
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    tooltip.innerHTML = "Copied!";
    document.body.removeChild(el);
  } // Click button


  var copyButton = document.querySelectorAll(".copy_shortcode");

  if (copyButton) {
    copyButton.forEach(function (item) {
      item.addEventListener('click', function () {
        item.style.color = '#0073aa';
        item.style.borderColor = '#0073aa';
        copyToClipboard(item);
      });
      item.addEventListener('mouseout', function () {
        var tooltip = item.previousElementSibling;
        tooltip.innerHTML = "Copy to clipboard";
        item.style.color = '';
        item.style.borderColor = '';
      });
    });
  }

  function hover_select() {
    var cdxn_ig_thumb_wrapper = $('body').find('.cdxn-ig-thumb-wrapper');
    var imageColor = $('body').find('.image-hover-color').find("input");
    var border_radius = $('body').find('.border-radius').find("input");
    var border_width = $('body').find('.border-width-selector').find("input");
    var border_style = $('body').find('.border-style-selector').find("select");
    var border_color = $('body').find('.border-color-selector').find("input");
    var display_icon = $('body').find('.display-image-icon').find("input:checked");
    var border_color_value = border_color.val() ? border_color.val() : '#fff'; // // console.log( 'Border color: '+ border_color_value );
    // console.log( 'Border color: '+ border_color_value );

    var border = border_width.val() + 'px ' + border_style.val() + ' ' + border_color_value;
    var icon = 'no-icon';
    var iconColor = '';

    if ('yes' === display_icon.val()) {
      icon = $('body').find('.icon-images').find("input:checked").val();
      iconColor = $('body').find('.icon-color-selector').find("input").val();
      iconColor = iconColor ? iconColor : '#fff';
    } // console.log( display_icon.val() );


    cdxn_ig_thumb_wrapper.each(function () {
      var icon_class = $(this).find('.cdxn-ig-icon');
      icon_class.removeClass();
      icon_class.addClass('cdxn-ig-icon ' + icon);

      if ('no-icon' === icon) {
        $(this).addClass('hover-no-icon');
      } else {
        $(this).removeClass('hover-no-icon');
      }

      $(this).get(0).style.setProperty('--custom-border', border);
      $(this).get(0).style.setProperty('--image_hover_color', imageColor.val());
      $(this).get(0).style.setProperty('--icon-color', iconColor);
      $(this).get(0).style.setProperty('--border-radius', border_radius.val() + 'px');
    });
  }

  $('body').on('click focusout', '.hover-selector, .cf-color__reset,  #carbon-color-picker-wrapper', function (e) {
    setTimeout(function () {
      hover_select();
    }, 5);
  });
  $('body').on('change', "input, select", function (e) {
    setTimeout(function () {
      hover_select();
    }, 5);
  });
  $('body').on('mousemove', "#carbon-color-picker-wrapper", function (e) {
    setTimeout(function () {
      hover_select();
    }, 5);
  });
  $(window).load(function () {
    hover_select();
  });
  /**
   * Admin code for dismissing notifications.
   *
   */

  $('.cdxn-ig-notice').on('click', '.notice-dismiss, .cdxn-ig-notice-action', function () {
    var $this = $(this);
    var admin_ajax = admin_js_script.admin_ajax;
    var parents = $(this).parents('.cdxn-ig-notice');
    var dismiss_type = $(this).data('dismiss');
    var notice_type = parents.data('notice');

    if (!dismiss_type) {
      dismiss_type = '';
    }

    var data = {
      action: 'rate_the_plugin',
      dismiss_type: dismiss_type,
      notice_type: notice_type,
      cx_nonce: admin_js_script.ajx_nonce
    };
    jQuery.ajax({
      type: 'POST',
      url: admin_ajax,
      data: data,
      success: function success(response) {
        // console.log(response);
        if (response) {
          $this.parents('.cdxn-ig-notice').remove();
        }
      }
    });
  });
})(jQuery);