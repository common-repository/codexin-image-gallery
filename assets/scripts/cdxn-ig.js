"use strict";

// jQuery.noConflict();
(function ($) {
  'use strict';
  /**
   * All of the code for your public-facing JavaScript source
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
  // Cdxn gallery additional style

  $(document).ready(function () {
    var container = $('.cdxn-ig-container');

    if (container.length > 0) {
      container.each(function () {
        var $this = $(this);
        var current_node_child = $this.find('.cdxn-ig-thumb-wrapper'),
            thumb_single = current_node_child.find('.cdxn-thumb-single'),
            node_data = $this.data('gallery'),
            column_gap = Number(node_data.column_gap),
            layout = node_data.layout,
            border_radius = node_data.border_radius,
            icon_color = node_data.icon_color,
            image_hover_color = node_data.image_hover_color,
            border = '0px'; // console.log( image_hover_color );
        // console.log( 'SOmething' );

        if ('0px' !== node_data.border_width) {
          border = node_data.border_width + ' ' + node_data.border_style + ' ' + node_data.border_color;
        }

        if ('0px' === node_data.border_width && 'justified-layout' === layout) {
          border = '';
        }

        if (node_data.column_gap >= 0) {
          if ('justified-layout' !== layout) {
            current_node_child.css({
              'margin-left': '-' + column_gap / 2 + 'px',
              'margin-right': '-' + column_gap / 2 + 'px',
              'margin-bottom': '-' + column_gap + 'px'
            });
            thumb_single.css({
              'padding-left': column_gap / 2 + 'px',
              'padding-right': column_gap / 2 + 'px',
              'padding-bottom': column_gap + 'px'
            });
          } else if ('justified-layout' === layout) {
            current_node_child.css({
              'margin-left': '-' + column_gap + 'px',
              'margin-right': '-' + column_gap + 'px',
              // 'margin-top': '-' + column_gap + 'px',
              'margin-bottom': '-' + column_gap + 'px',
              width: 'calc(100% + ' + column_gap * 2 + 'px)'
            });
          }

          if (navigator.userAgent.indexOf('MSIE') != -1 || !!document.documentMode == true) {
            thumb_single.find('a').css({
              'border-radius': border_radius + 'px',
              border: border
            });
            thumb_single.find('.cdxn-ig-icon').css({
              'color': icon_color
            });
            thumb_single.find('.cdxn-ig-content-wraper').css({
              'color': icon_color
            });
          } else {
            current_node_child.get(0).style.setProperty('--custom-border', border);
            current_node_child.get(0).style.setProperty('--border-radius', border_radius + 'px');
            current_node_child.get(0).style.setProperty('--icon-color', icon_color);
            current_node_child.get(0).style.setProperty('--image_hover_color', image_hover_color);
          }
        }
      });
    }
  });

  function grid_layout() {
    if ($('.cdxn-ig-thumb-wrapper.grid-layout .cdxn-thumb-single a').length > 0) {
      $('.cdxn-ig-thumb-wrapper.grid-layout .cdxn-thumb-single a').each(function () {
        var $this_link = $(this);
        var $grid_wraper = $(this).find('.grid-wraper');
        var $this_data = $(this).parents('.cdxn-ig-container').data('gallery');
        var img = $this_link.attr('data-src');
        var obj = {
          backgroundImage: 'url(' + img + ')',
          backgroundSize: 'cover',
          backgroundPosition: 'center center'
        };

        if ($(window).width() > 1024) {
          if ('' !== $this_data.grid_desktop_height) {
            obj.height = $this_data.grid_desktop_height;
            obj.paddingTop = '0px';
          } else {
            obj.height = '';
            obj.paddingTop = '80%';
          }
        } else if ($(window).width() > 767) {
          if ('' !== $this_data.grid_tablet_height) {
            obj.height = $this_data.grid_tablet_height;
            obj.paddingTop = '0px';
          } else {
            obj.height = '';
            obj.paddingTop = '80%';
          }
        } else if ($(window).width() >= 320) {
          if ('' !== $this_data.grid_mobile_height) {
            obj.height = $this_data.grid_mobile_height;
            obj.paddingTop = '0px';
          } else {
            obj.height = '';
            obj.paddingTop = '80%';
          }
        } else {
          obj.height = '';
          obj.paddingTop = '80%';
        }

        $grid_wraper.css(obj);
      });
    }
  }

  function mesonary_layout() {
    // console.log( typeof imagesLoaded );
    if ('function' === typeof imagesLoaded) {
      var $grid = $('.cdxn-ig-thumb-wrapper.masonry-layout').imagesLoaded(function () {
        // init Masonry after all images have loaded
        $grid.masonry({
          // set itemSelector so .grid-sizer is not used in layout
          itemSelector: '.cdxn-thumb-single',
          // use element for option
          columnWidth: '.cdxn-thumb-single',
          percentPosition: true
        }); // $grid.packery(); // pro - version
      });
    }
  }

  if ($('.cdxn-ig-thumb-wrapper.masonry-layout').length > 0) {
    mesonary_layout();
  }

  if ($('.cdxn-ig-thumb-wrapper.justified-layout').length > 0) {
    var gallery_selector = $('.cdxn-ig-thumb-wrapper.justified-layout').parent('.cdxn-ig-container');
    gallery_selector.each(function () {
      var $this = $(this);
      var gallery_dataset = $this.data('gallery');
      var margin = gallery_dataset.column_gap,
          row_height = gallery_dataset.row_height,
          last_row = gallery_dataset.last_row;
      $('.cdxn-ig-thumb-wrapper.justified-layout').justifiedGallery({
        selector: 'figure',
        rowHeight: row_height,
        margins: margin,
        imgSelector: '> div > a > img',
        captions: false,
        lastRow: last_row
      });
    });
  } // layout responsive


  grid_layout();
  $(window).on('resize', function () {
    grid_layout();
    mesonary_layout();
  }); // navigator.userAgent.forEach(element => {
  // console.log( window.navigator.userAgent );
  // });
})(jQuery);