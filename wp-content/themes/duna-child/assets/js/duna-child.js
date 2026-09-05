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
    initA11y();
  });

  /**
   * A11y (sesion v1.4.0). Mitigaciones desde el child para fallos del PLUGIN
   * wheels-size-finder, del PARENT Motors y de WooCommerce (regla de oro: no
   * tocar plugin/parent). Todo lo que se agrega es aria/rol SIN cambiar el
   * aspecto visual:
   *   - role="main" en #main (el parent no usa <main>): landmark principal.
   *   - aria-label en iconos sociales del header/footer (enlaces con solo <i>).
   *   - aria-label + aria-current en los dots del slider de testimonios del
   *     plugin (los crea por JS sin nombre).
   *   - labels asociados a los selects del buscador del plugin (.wsf-select-item).
   *   - aria-label en la paginacion del parent (.stm-prev-next con solo icono).
   *   - quita aria-selected de los <a> de los tabs de la ficha (WooCommerce lo
   *     re-aplica; se usa MutationObserver).
   *   - heading-order: ajusta aria-level en la secuencia visible de encabezados.
   *   - dedupe de IDs de ARIA duplicados de los .modal del parent + re-apunta
   *     cada aria-labelledby al titulo de SU modal.
   */
  function initA11y() {
    // 1) Landmark principal: el parent estructura <div id=wrapper><div id=main>
    var $main = $('#main');
    if ($main.length) {
      $main.attr('role', 'main');
    }

    // 2) Iconos sociales (header + footer): <a> con <i> sin texto ni alt.
    $('a[href*="facebook.com"], a[href*="instagram.com"], a[href*="wa.me"], a[href*="whatsapp.com"]').each(function () {
      var $a = $(this);
      if ($a.attr('aria-label') || $a.attr('title') || ($a.text() || '').trim()) {
        return;
      }
      var href = $a.attr('href') || '';
      var label = '';
      if (href.indexOf('facebook.com') !== -1) { label = 'Facebook'; }
      else if (href.indexOf('instagram.com') !== -1) { label = 'Instagram'; }
      else if (href.indexOf('wa.me') !== -1 || href.indexOf('whatsapp.com') !== -1) { label = 'WhatsApp'; }
      if (label) {
        $a.attr('aria-label', label);
      }
    });

    // 3) Dots del slider de testimonios (los crea el plugin por JS sin
    //    aria-label ni texto). Ver tambien CSS del child (touch target >=24px).
    $('.wsf-testimonials').each(function () {
      var $wrap = $(this);
      var $dots = $wrap.find('.wsf-testimonials-dots button');
      $dots.each(function (idx) {
        var $d = $(this);
        if (!$d.attr('aria-label')) {
          $d.attr('aria-label', 'Ir a la p\u00E1gina de testimonios ' + (idx + 1));
        }
        $d.attr('aria-current', $d.hasClass('wsf-active') ? 'true' : 'false');
      });
      // Mantener aria-current sincronizado al cambiar de slide (el plugin
      // togglea .wsf-active en los dots al avanzar).
      if ($dots.length) {
        var mut = new MutationObserver(function () {
          $dots.each(function () {
            $(this).attr('aria-current', $(this).hasClass('wsf-active') ? 'true' : 'false');
          });
        });
        mut.observe($wrap[0], { subtree: true, attributes: true, attributeFilter: ['class'] });
      }
    });

    // 4) Selects del buscador del PLUGIN sin <label> asociado (fallo
    //    select-name): el plugin pinta <label> (visual) dentro de cada
    //    .wsf-select-item pero sin for= ni aria. Se asocia cada select a su
    //    label del .wsf-select-item dandole id y for (y aria-describedby si el
    //    label del item ya existia). Incluye selects re-pintados por el plugin
    //    (wsf-width/profile/rim/brand/model/year/version).
    $('.wsf-select-item select').each(function () {
      var $sel = $(this);
      if ($sel.attr('aria-label') || $sel.attr('aria-labelledby')) { return; }
      var $item = $sel.closest('.wsf-select-item');
      var $lbl = $item.length ? $item.find('label').first() : $();
      if (!$sel.attr('id')) {
        var cls = String($sel.attr('class') || 'select').replace(/[^a-zA-Z0-9_-]/g, '');
        $sel.attr('id', 'wsf-' + cls);
      }
      if ($lbl.length) {
        if (!$lbl.attr('for')) {
          $lbl.attr('for', $sel.attr('id'));
        }
        $sel.removeAttr('aria-label');
        $sel.attr('aria-labelledby', $lbl.attr('id') || $lbl.attr('for'));
      } else {
        var text = ($sel.closest('.wsf-select-item').find('label').text() || $sel.find('option:selected').text() || 'Seleccionar').trim();
        $sel.attr('aria-label', text);
      }
    });

    // 4b) Paginacion de catalogos del PARENT (fallo link-name): el partial
    //     woocommerce/loop/pagination.php (Motors) imprime next/prev como
    //     enlaces de solo icono dentro de .stm-prev-next (duplicando ademas el
    //     href de la pagina numerada -> identical-links-same-purpose). Se les
    //     pone aria-label (y aria-hidden al icono para que no duplique).
    $('.stm-prev-next a').each(function () {
      var $a = $(this);
      if ($a.attr('aria-label') || ($a.text() || '').trim()) { return; }
      var $box = $a.closest('.stm-prev-next');
      var label = $box.hasClass('stm-next-btn') ? 'P\u00E1gina siguiente' : 'P\u00E1gina anterior';
      $a.attr('aria-label', label);
      $a.find('i').attr('aria-hidden', 'true');
    });

    // 4c) Tabs de la ficha de producto (WooCommerce core): los <a> dentro del
    //     <li role=tab> llevan aria-selected (viola aria-allowed-attr porque el
    //     tab es el <li>, no el <a>). WooCommerce lo re-aplica en su init/click
    //     (single-product.js), por lo que una sola pasada no alcanza: se usa un
    //     MutationObserver que lo retira de los anclas cuando aparece.
    var stripTabAria = function () {
      $('.woocommerce-tabs ul.tabs li a[aria-selected]').removeAttr('aria-selected');
    };
    stripTabAria();
    var tabObserver = new MutationObserver(function (muts) {
      var hit = false;
      for (var i = 0; i < muts.length; i++) {
        if (muts[i].type === 'attributes' && muts[i].attributeName === 'aria-selected') { hit = true; break; }
        if (muts[i].type === 'childList' && muts[i].addedNodes.length) { hit = true; break; }
      }
      if (hit) { stripTabAria(); }
    });
    if (document.querySelector('.woocommerce-tabs')) {
      tabObserver.observe(document.body, { subtree: true, attributes: true, attributeFilter: ['aria-selected'], childList: true });
    }

    // 5) heading-order (fallos de Lighthouse): la estructura del PARENT/plugin
    //    salta niveles (h2 -> h4/h5/h6 de icon-box/productos/widgets/sidebar/
    //    footer). CSS no cambia el arbol; se ajusta la SEMANTICA (aria-level)
    //    sin tocar el aspecto: recorrido en orden DOM de los encabezados
    //    VISIBLES, y si uno salta mas de un nivel respecto del anterior se le
    //    asigna aria-level = (nivel anterior)+1 (nunca baja de 2). Asi h4/h5/h6
    //    que siguen a un h2 pasan a nivel 3 (siblings de nivel 3 son validos).
    function headingLevel(el) {
      var tag = el.tagName.toLowerCase();
      var native = parseInt(tag.charAt(1), 10);
      var aria = parseInt(el.getAttribute('aria-level') || '', 10);
      return aria || native;
    }
    var lastLevel = 1;
    var headings = [];
    Array.prototype.forEach.call(document.querySelectorAll('h1,h2,h3,h4,h5,h6'), function (h) {
      if (h.closest('.modal, [aria-hidden=true], .wsf-mobile-sidebar')) { return; }
      var r = h.getBoundingClientRect();
      if (r.width === 0 && r.height === 0) { return; }
      headings.push(h);
    });
    // Recorre en orden de documento.
    headings.forEach(function (h) {
      var level = headingLevel(h);
      if (level > lastLevel + 1) {
        level = Math.max(2, lastLevel + 1);
        h.setAttribute('role', 'heading');
        h.setAttribute('aria-level', String(level));
      }
      lastLevel = level;
    });

    // 6) IDs duplicados de los modales del parent (fallo duplicate-id-aria).
    //    El PARENT imprime los .modal (get-car-price/test-drive/trade-offer)
    //    mas de una vez por pagina (inc/modals.php + contenido/otros) con los
    //    MISMOs ids hardcodeados (#get-car-price, #myModalLabel, #test-drive,
    //    #request-test-drive-form, ...). P1: re-numerar las repeticiones
    //    (2da+ ocurrencia -> id-2, id-3...). P2: re-apuntar el aria-labelledby
    //    de CADA .modal a los h3 de SU modal (por si quedo renumerado).
    var seen = {};
    $('[id]').each(function () {
      var id = this.id;
      if (!id) { return; }
      if (!seen[id]) { seen[id] = []; }
      seen[id].push(this);
    });
    Object.keys(seen).forEach(function (id) {
      var els = seen[id];
      if (els.length < 2) { return; }
      var refs = ['aria-labelledby', 'aria-describedby', 'aria-controls', 'aria-activedescendant'];
      els.forEach(function (el, i) {
        if (i === 0) { return; }
        var newId = id + '-' + (i + 1);
        if (el.id) { el.id = newId; }
        refs.forEach(function (attr) {
          if (el.hasAttribute(attr)) {
            var toks = (el.getAttribute(attr) || '').split(/\s+/);
            toks = toks.map(function (tok) { return (tok === id) ? newId : tok; });
            el.setAttribute(attr, toks.join(' '));
          }
        });
      });
    });
    $('.modal').each(function () {
      var $modal = $(this);
      var $h = $modal.find('.modal-title').first();
      if ($h.length && !$h.attr('id')) {
        $h.attr('id', 'modal-title-' + $modal.index());
      }
      if ($h.length && $modal.attr('aria-labelledby') !== $h.attr('id')) {
        $modal.attr('aria-labelledby', $h.attr('id'));
      }
    });
  }

  function initMobileSidebar() {
    var grid = $('ul.products').first();
    var sidebar = $('.wpb_widgetised_column').first();
    if (!grid.length || !sidebar.length) {
      return;
    }

    var $btn = $('<button type="button" class="wsf-mobile-filters">Filtros</button>');
    var $head = $(
      '<div class="wsf-mobile-sidebar-head"><span>Categorías / Filtros</span>' +
      '<button type="button" class="wsf-mobile-sidebar-close" aria-label="Cerrar">&#10005;</button></div>'
    );
    var $shell = $('<div class="wsf-mobile-sidebar" aria-hidden="true"></div>');
    var $overlay = $('<div class="wsf-mobile-overlay"></div>');
    $shell.append($head);
    $overlay.appendTo('body');
    $shell.appendTo('body');

    // Accesibilidad (F6): el shell vive SIEMPRE en el DOM (cerrado). Mientras
    // esta cerrado no debe exponer su contenido al AT ni dejar el boton
    // "Cerrar" tabulable dentro de un aria-hidden=true (fallo
    // aria-hidden-focus de Lighthouse). Se usa [inert] (soporte Chrome 102+/
    // modernos) + aria-hidden sincronizado con el estado open/close.
    $shell[0].inert = true;
    var setDrawerState = function (isOpen) {
      $shell[0].inert = !isOpen;
      $shell.attr('aria-hidden', isOpen ? 'false' : 'true');
    };
    setDrawerState(false);

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
      setDrawerState(true);
      $shell.find('.wsf-mobile-sidebar-close').trigger('focus');
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
      setDrawerState(false);
      $btn.trigger('focus');
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
    var $root = $(document.documentElement);

    if (!isAdmin) {
      $('body').removeClass('wsf-light');
      $root.removeClass('wsf-light');
      return;
    }

    var stored = null;
    try { stored = window.localStorage.getItem('wsf-theme'); } catch (e) {}

    var setIcon = function (light) {
      $('.wsf-theme-icon').text(light ? '\u263E' : '\u2600');
    };

    // El buscador (wheels-size-finder) pinta sus selects con estilos inline
    // leyendo las variables --wsf-* desde :root (documentElement). Al alternar
    // el tema hay que re-pintarlos con los colores del modo activo (las
    // variables claras viven en html.wsf-light/body.wsf-light del child).
    var applyWsfSelects = function () {
      var rootCs = window.getComputedStyle(document.documentElement);
      var val = function (v) { return rootCs.getPropertyValue(v).trim(); };
      var input = val('--wsf-input');
      var text = val('--wsf-text');
      var border = val('--wsf-border');
      var scheme = val('--wsf-scheme');
      var optionBg = val('--wsf-option-bg');
      var optionText = val('--wsf-option-text');
      $('.wsf-select-item select').each(function () {
        var st = this.style;
        if (input) { st.setProperty('background-color', input, 'important'); }
        if (text) { st.setProperty('color', text, 'important'); }
        if (border) { st.setProperty('border-color', border, 'important'); }
        if (scheme) { st.setProperty('color-scheme', scheme, 'important'); }
        st.setProperty('opacity', '1', 'important');
        st.setProperty('visibility', 'visible', 'important');
        var opts = this.options || [];
        for (var i = 0; i < opts.length; i++) {
          if (optionBg) { opts[i].style.setProperty('background-color', optionBg, 'important'); }
          if (optionText) { opts[i].style.setProperty('color', optionText, 'important'); }
        }
      });
    };

    if (stored === 'light') {
      $('body').addClass('wsf-light');
      $root.addClass('wsf-light');
    }
    setIcon(stored === 'light');
    applyWsfSelects();

    $(document).on('click', '.wsf-theme-toggle', function () {
      var light = $('body').toggleClass('wsf-light').hasClass('wsf-light');
      $root.toggleClass('wsf-light', light);
      try { window.localStorage.setItem('wsf-theme', light ? 'light' : 'dark'); } catch (e) {}
      setIcon(light);
      applyWsfSelects();
    });
  }
})(jQuery);
