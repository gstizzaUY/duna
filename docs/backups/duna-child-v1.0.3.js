/**
 * Duna Child - tema/aspecto del sitio (jQuery).
 * Toggle claro/oscuro, widget de categorias colapsable,
 * el icono "Mi cuenta" movido a la navbar negra y
 * la sidebar de filtros accesible en movil.
 */
(function ($) {
  'use strict';

  $(function () {
    initThemeToggle();
    initCategoryWidget();
    moveHeaderUser();
    initMobileSidebar();
  });

  function initMobileSidebar() {
    var grid = $('ul.products').first();
    var sidebar = $('.wpb_widgetised_column').first();
    if (!grid.length || !sidebar.length) {
      return;
    }

    var $btn = $('<button type="button" class="wsf-mobile-filters">Filtros</button>');
    var $shell = $('<div class="wsf-mobile-sidebar" aria-hidden="true"></div>');
    var $head = $(
      '<div class="wsf-mobile-sidebar-head"><span>Categorías / Filtros</span>' +
      '<button type="button" class="wsf-mobile-sidebar-close" aria-label="Cerrar">&#10005;</button></div>'
    );
    var $overlay = $('<div class="wsf-mobile-overlay"></div>');
    $shell.append($head);
    $overlay.appendTo('body');
    $shell.appendTo('body');

    var gridParent = grid.closest('.col-md-9, .col-md-8, .col-md-7, .col-md-6, .col-md-12').length
      ? grid.closest('.col-md-9, .col-md-8, .col-md-7, .col-md-6, .col-md-12')
      : grid.parent();
    gridParent.prepend($btn);

    var sidebarEl = sidebar[0];
    var originParent = null;
    var placeholder = null;
    var openState = false;

    var open = function () {
      if (openState) {
        return;
      }
      openState = true;
      originParent = sidebarEl.parentNode;
      placeholder = document.createComment('wsf-mobile-sidebar-origin');
      sidebarEl.parentNode.insertBefore(placeholder, sidebarEl);
      $shell.append(sidebarEl);
      $shell.addClass('open');
      $overlay.addClass('open');
      $('body').addClass('wsf-mobile-scroll-lock');
      $btn.hide();
    };

    var close = function () {
      if (!openState) {
        return;
      }
      openState = false;
      if (placeholder && placeholder.parentNode) {
        placeholder.parentNode.insertBefore(sidebarEl, placeholder);
        placeholder.remove();
      } else if (originParent) {
        originParent.appendChild(sidebarEl);
      }
      $shell.removeClass('open');
      $overlay.removeClass('open');
      $('body').removeClass('wsf-mobile-scroll-lock');
      $btn.show();
    };

    $btn.on('click', open);
    $shell.on('click', '.wsf-mobile-sidebar-close', close);
    $overlay.on('click', close);

    // si vuelve a desktop con el drawer abierto
    var onResize = null;
    var checkResize = function () {
      if (window.innerWidth >= 992 && $shell.hasClass('open')) {
        close();
      }
    };
    $(window).on('resize', function () {
      clearTimeout(onResize);
      onResize = setTimeout(checkResize, 150);
    });
  }

  function moveHeaderUser() {
    var li = $('.stm_mc-nav li.motors-icons-user, .main-menu li.motors-icons-user').first();
    if (!li.length) {
      return;
    }
    var href = li.find('a').attr('href');
    var cart = $('.help-bar-shop').first();
    if (!cart.length || $('.wsf-header-user').length) {
      return;
    }
    var $link = $('<a class="wsf-header-user" aria-label="Mi cuenta"><i></i></a>').attr('href', href);
    cart.parent().prepend($link);
  }

  function initCategoryWidget() {
    var $widget = $('.widget_product_categories');
    if (!$widget.length) {
      return;
    }

    $widget.find('li.cat-parent').each(function () {
      var $li = $(this);
      var $children = $li.children('ul.children');
      if (!$children.length) {
        return;
      }

      var $toggle = $('<button type="button" class="wsf-cat-toggle" aria-expanded="false" aria-label="Subcategorías"><span>&#9656;</span></button>');
      $li.prepend($toggle);

      var active = $li.is('.current-cat, .current-cat-parent') || $li.find('.current-cat, .current-cat-parent').length > 0;
      if (active) {
        $toggle.addClass('open').attr('aria-expanded', 'true');
      } else {
        $children.hide();
      }
    });

    $widget.on('click', '.wsf-cat-toggle', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var $btn = $(this);
      var $ul = $btn.parent().children('ul.children');
      if ($ul.is(':visible')) {
        $ul.slideUp(150);
        $btn.removeClass('open').attr('aria-expanded', 'false');
      } else {
        $ul.slideDown(150);
        $btn.addClass('open').attr('aria-expanded', 'true');
      }
    });
  }

  function initThemeToggle() {
    var isAdmin = $('body').hasClass('wsf-can-toggle');

    if (!isAdmin) {
      $('body').removeClass('wsf-light');
      return;
    }

    var stored = null;
    try { stored = window.localStorage.getItem('wsf-theme'); } catch (e) {}

    var setIcon = function (light) {
      $('.wsf-theme-icon').text(light ? '\u263E' : '\u2600');
    };

    if (stored === 'light') {
      $('body').addClass('wsf-light');
    }
    setIcon(stored === 'light');

    $(document).on('click', '.wsf-theme-toggle', function () {
      var light = $('body').toggleClass('wsf-light').hasClass('wsf-light');
      try { window.localStorage.setItem('wsf-theme', light ? 'light' : 'dark'); } catch (e) {}
      setIcon(light);
    });
  }
})(jQuery);
