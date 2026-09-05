(function ($) {
  'use strict';

  var WSF = {
    init: function () {
      $('.wsf-container').each(function () {
        var container = $(this);
        var nonce = container.data('nonce');

        WSF.initTirePanel(container, nonce);
        WSF.initVehiclePanel(container, nonce);
        WSF.initTabs(container);
        WSF.initSearchButtons(container, nonce);

        var activeTab = container.find('.wsf-tab.wsf-active').first();
        if (activeTab.length) {
          container.find('.wsf-panel').removeClass('wsf-active');
          container.find('.wsf-panel[data-panel="' + activeTab.data('tab') + '"]').addClass('wsf-active');
        }

        container.find('.wsf-select-item select').each(function () {
          WSF.applyColors($(this));
        });
      });

      WSF.initTestimonialsSlider();
      WSF.initLogosMarquee();
    },

    initTestimonialsSlider: function () {
      $('.wsf-testimonials').each(function () {
        var $wrap = $(this);
        var $items = $wrap.children('.wsf-testimonial');
        if ($items.length < 2) return;

        var $track = $('<div class="wsf-testimonials-track"></div>');
        $track.append($items);
        $wrap.prepend($track);

        var index = 0;
        var count = $items.length;
        var visible = $wrap.outerWidth() < 768 ? 1 : 3;
        if (visible > count) visible = count;
        var maxIndex = count - visible;
        var stepPct = 100 / visible;
        var dots = [];

        var $prev = $('<button type="button" class="wsf-ts-arrow wsf-ts-prev" aria-label="Anterior">&lsaquo;</button>');
        var $next = $('<button type="button" class="wsf-ts-arrow wsf-ts-next" aria-label="Siguiente">&rsaquo;</button>');
        var $dots = $('<div class="wsf-testimonials-dots"></div>');
        for (var i = 0; i <= maxIndex; i++) {
          (function (idx) {
            var $d = $('<button type="button"></button>');
            if (idx === 0) $d.addClass('wsf-active');
            $d.on('click', function () { go(idx); });
            $dots.append($d);
            dots.push($d);
          })(i);
        }

        $wrap.append($prev).append($next).append($dots);

        function go(i) {
          index = Math.max(0, Math.min(i, maxIndex));
          $track.css('transform', 'translateX(-' + (index * stepPct) + '%)');
          dots.forEach(function (d, di) { d.toggleClass('wsf-active', di === index); });
        }

        $prev.on('click', function () { go(index - 1); });
        $next.on('click', function () { go(index + 1); });

        var timer = setInterval(function () { go(index + 1); }, 5000);
        $wrap.on('mouseenter', function () { clearInterval(timer); });
        $wrap.on('mouseleave', function () { timer = setInterval(function () { go(index + 1); }, 5000); });
      });
    },

    initLogosMarquee: function () {
      $('.wsf-logos').each(function () {
        var $track = $(this).find('.wsf-logos-track').first();
        if (!$track.length || !$track.children().length) return;
        $track.append($track.children().clone(true));
      });
    },

    applyColors: function (select) {
      var root = getComputedStyle(document.documentElement);
      var input = root.getPropertyValue('--wsf-input').trim();
      var text = root.getPropertyValue('--wsf-text').trim();
      var border = root.getPropertyValue('--wsf-border').trim();
      var scheme = root.getPropertyValue('--wsf-scheme').trim();
      var optionBg = root.getPropertyValue('--wsf-option-bg').trim() || '#0d1117';
      var optionText = root.getPropertyValue('--wsf-option-text').trim() || '#e1e4e8';

      if (input) {
        select[0].style.setProperty('background-color', input, 'important');
      }
      if (text) {
        select[0].style.setProperty('color', text, 'important');
      }
      if (border) {
        select[0].style.setProperty('border-color', border, 'important');
      }
      if (scheme) {
        select[0].style.setProperty('color-scheme', scheme, 'important');
      }

      select[0].style.setProperty('opacity', select.prop('disabled') ? '0.6' : '1', 'important');
      select[0].style.setProperty('visibility', 'visible', 'important');

      select.find('option').each(function () {
        this.style.setProperty('background-color', optionBg, 'important');
        this.style.setProperty('color', optionText, 'important');
      });
    },

    initTabs: function (container) {
      container.find('.wsf-tab').on('click', function () {
        var tab = $(this).data('tab');
        container.find('.wsf-tab').removeClass('wsf-active');
        $(this).addClass('wsf-active');
        container.find('.wsf-panel').removeClass('wsf-active');
        container.find('.wsf-panel[data-panel="' + tab + '"]').addClass('wsf-active');
      });
    },

    initTirePanel: function (container, nonce) {
      var panel = container.find('.wsf-panel[data-panel="tire"]');
      if (!panel.length) return;

      var widthSel = panel.find('.wsf-width-select');
      var profileSel = panel.find('.wsf-profile-select');
      var rimSel = panel.find('.wsf-rim-select');
      var preview = panel.find('.wsf-result-preview');
      var searchBtn = panel.find('.wsf-search-btn');

      WSF.loadSelect(widthSel, wsfData.apiUrl + '/api/tire-widths');

      widthSel.on('change', function () {
        profileSel.prop('disabled', true).html('<option value="">--</option>');
        rimSel.prop('disabled', true).html('<option value="">--</option>');
        searchBtn.addClass('wsf-hidden');
        preview.html('');

        var w = $(this).val();
        if (w) {
          WSF.loadSelect(profileSel, wsfData.apiUrl + '/api/tire-profiles?width=' + encodeURIComponent(w));
        }
      });

      profileSel.on('change', function () {
        rimSel.prop('disabled', true).html('<option value="">--</option>');
        searchBtn.addClass('wsf-hidden');
        preview.html('');

        var w = widthSel.val();
        var p = $(this).val();
        if (w && p) {
          WSF.loadSelect(rimSel, wsfData.apiUrl + '/api/tire-rims?width=' + encodeURIComponent(w) + '&profile=' + encodeURIComponent(p));
        }
      });

      rimSel.on('change', function () {
        var w = widthSel.val();
        var p = profileSel.val();
        var r = $(this).val();
        if (w && p && r) {
          var size = w + '/' + p + 'R' + r;
          preview.html('<div class="wsf-tire-size">' + size + '</div>');
          searchBtn.removeClass('wsf-hidden').data('tire-size', size);
        } else {
          searchBtn.addClass('wsf-hidden');
          preview.html('');
        }
      });
    },

    initVehiclePanel: function (container, nonce) {
      var panel = container.find('.wsf-panel[data-panel="vehicle"]');
      if (!panel.length) return;

      var brandSel = panel.find('.wsf-brand-select');
      var modelSel = panel.find('.wsf-model-select');
      var yearSel = panel.find('.wsf-year-select');
      var versionSel = panel.find('.wsf-version-select');
      var preview = panel.find('.wsf-result-preview');
      var searchBtn = panel.find('.wsf-search-btn');

      WSF.ajaxLoad(brandSel, 'brands', {}, nonce);

      brandSel.on('change', function () {
        WSF.resetSelect(modelSel);
        WSF.resetSelect(yearSel);
        WSF.resetSelect(versionSel);
        searchBtn.addClass('wsf-hidden');
        preview.html('');

        var brand = $(this).val();
        if (brand) {
          WSF.ajaxLoad(modelSel, 'models', { brand: brand }, nonce);
        }
      });

      modelSel.on('change', function () {
        WSF.resetSelect(yearSel);
        WSF.resetSelect(versionSel);
        searchBtn.addClass('wsf-hidden');
        preview.html('');

        var brand = brandSel.val();
        var model = $(this).val();
        if (brand && model) {
          WSF.ajaxLoad(yearSel, 'years', { brand: brand, model: model }, nonce);
        }
      });

      yearSel.on('change', function () {
        WSF.resetSelect(versionSel);
        searchBtn.addClass('wsf-hidden');
        preview.html('');

        var brand = brandSel.val();
        var model = modelSel.val();
        var year = $(this).val();
        if (brand && model && year) {
          WSF.ajaxLoad(versionSel, 'versions', { brand: brand, model: model, year: year }, nonce);
        }
      });

      versionSel.on('change', function () {
        var brand = brandSel.val();
        var model = modelSel.val();
        var year = yearSel.val();
        var version = $(this).val();

        if (brand && model && year && version) {
          preview.html('<span class="wsf-loading">' + wsfData.i18n.loading + '</span>');
          $.post(wsfData.ajaxUrl, {
            action: 'wsf_get_vehicle_data',
            nonce: nonce,
            data_type: 'tire',
            brand: brand,
            model: model,
            year: year,
            version: version
          }, function (resp) {
            if (resp.success && resp.data && resp.data.tires && resp.data.tires.oem && resp.data.tires.oem.size) {
              var size = resp.data.tires.oem.size;
              preview.html('<div class="wsf-tire-size">' + size + '</div>');
              searchBtn.removeClass('wsf-hidden').data('tire-size', size);
            } else {
              preview.html('<div class="wsf-no-size">' + wsfData.i18n.noResults + '</div>');
              searchBtn.addClass('wsf-hidden');
            }
          }).fail(function () {
            preview.html('<div class="wsf-error">' + wsfData.i18n.error + '</div>');
          });
        }
      });
    },

    initSearchButtons: function (container, nonce) {
      container.find('.wsf-search-btn').on('click', function () {
        var btn = $(this);
        var tireSize = btn.data('tire-size');
        var resultsContainer = container.find('.wsf-results-container');

        if (!tireSize) return;

        resultsContainer.removeClass('wsf-hidden').html('<div class="wsf-loading">' + wsfData.i18n.loading + '</div>');

        WSF.loadProducts(container, tireSize, 1, nonce);
      });
    },

    loadProducts: function (container, tireSize, page, nonce) {
      var resultsContainer = container.find('.wsf-results-container');

      $.post(wsfData.ajaxUrl, {
        action: 'wsf_search_products',
        nonce: nonce,
        tire_size: tireSize,
        page: page
      }, function (resp) {
        if (!resp.success) {
          resultsContainer.html('<div class="wsf-error">' + (resp.data && resp.data.message ? resp.data.message : wsfData.i18n.error) + '</div>');
          return;
        }

        var data = resp.data;
        if (!data.products || data.products.length === 0) {
          resultsContainer.html('<div class="wsf-no-results">' + wsfData.i18n.noResults + ' ' + tireSize + '</div>');
          return;
        }

        var html = '<div class="wsf-results-header">';
        html += '<h3>' + tireSize + ' <span>(' + data.total + ' ' + wsfData.i18n.inStock + ')</span></h3>';
        html += '</div>';
        html += '<div class="wsf-products-grid">';

        $.each(data.products, function (i, product) {
          html += '<div class="wsf-product-card">';
          html += '<a href="' + product.permalink + '">';
          html += '<img src="' + product.image + '" alt="' + product.title + '" loading="lazy">';
          html += '</a>';
          html += '<div class="wsf-product-info">';
          html += '<h4><a href="' + product.permalink + '">' + product.title + '</a></h4>';
          if (product.sku) {
            html += '<span class="wsf-product-sku">SKU: ' + product.sku + '</span>';
          }
          html += '<div class="wsf-product-price">' + product.price + '</div>';
          if (product.stock_status === 'instock') {
            html += '<a href="' + product.add_to_cart_url + '" class="wsf-add-to-cart">' + wsfData.i18n.addToCart + '</a>';
          } else {
            html += '<span class="wsf-out-of-stock">' + wsfData.i18n.outOfStock + '</span>';
          }
          html += '</div></div>';
        });

        html += '</div>';

        if (data.pages > 1) {
          html += '<div class="wsf-pagination">';
          html += '<button class="wsf-page-btn" ' + (data.page <= 1 ? 'disabled' : '') + ' data-page="' + (data.page - 1) + '">' + wsfData.i18n.prev + '</button>';
          html += '<span>' + wsfData.i18n.page + ' ' + data.page + ' ' + wsfData.i18n.of + ' ' + data.pages + '</span>';
          html += '<button class="wsf-page-btn" ' + (data.page >= data.pages ? 'disabled' : '') + ' data-page="' + (data.page + 1) + '">' + wsfData.i18n.next + '</button>';
          html += '</div>';
        }

        resultsContainer.html(html);

        resultsContainer.find('.wsf-page-btn').on('click', function () {
          var p = $(this).data('page');
          resultsContainer.html('<div class="wsf-loading">' + wsfData.i18n.loading + '</div>');
          WSF.loadProducts(container, tireSize, p, nonce);
        });
      }).fail(function () {
        resultsContainer.html('<div class="wsf-error">' + wsfData.i18n.error + '</div>');
      });
    },

    loadSelect: function (select, url) {
      select.prop('disabled', true).html('<option value="">' + wsfData.i18n.loading + '</option>');
      WSF.applyColors(select);
      $.getJSON(url, function (data) {
        select.html('<option value="">--</option>');
        if (Array.isArray(data)) {
          $.each(data, function (i, val) {
            select.append('<option value="' + val + '">' + val + '</option>');
          });
          select.prop('disabled', false);
        }
        WSF.applyColors(select);
      }).fail(function () {
        select.html('<option value="">' + wsfData.i18n.error + '</option>');
        WSF.applyColors(select);
      });
    },

    ajaxLoad: function (select, dataType, extraData, nonce) {
      select.prop('disabled', true).html('<option value="">' + wsfData.i18n.loading + '</option>');
      WSF.applyColors(select);
      $.post(wsfData.ajaxUrl, $.extend({ action: 'wsf_get_vehicle_data', nonce: nonce, data_type: dataType }, extraData), function (resp) {
        select.html('<option value="">--</option>');
        if (resp.success && Array.isArray(resp.data)) {
          $.each(resp.data, function (i, val) {
            var label = typeof val === 'string' ? val : (val.label || val.value || val);
            var v = typeof val === 'string' ? val : (val.value || val.label || val);
            select.append('<option value="' + v + '">' + label + '</option>');
          });
          select.prop('disabled', false);
        }
        WSF.applyColors(select);
      }).fail(function () {
        select.html('<option value="">' + wsfData.i18n.error + '</option>');
        WSF.applyColors(select);
      });
    },

    resetSelect: function (select) {
      select.prop('disabled', true).html('<option value="">--</option>');
    },

    restoreSelects: function () {
      $('.wsf-container select').each(function () {
        var $sel = $(this);

        if (typeof $.fn.select2 === 'function' && ($sel.data('select2') || $sel.hasClass('select2-hidden-accessible'))) {
          $sel.select2('destroy');
        }

        WSF.applyColors($sel);
      });
    }
  };

  $(document).ready(function () {
    WSF.init();

    setTimeout(function () {
      WSF.restoreSelects();
    }, 0);
  });

  $(window).on('load', function () {
    WSF.restoreSelects();
  });
})(jQuery);
