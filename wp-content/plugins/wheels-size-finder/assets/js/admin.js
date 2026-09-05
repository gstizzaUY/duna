jQuery(document).ready(function($) {
    var preview = $('#wsf-preview');

    if (!preview.length) {
        return;
    }

    var fieldVars = {
        wsf_primary_color: '--wsf-primary',
        wsf_accent_color: '--wsf-accent',
        wsf_button_bg: '--wsf-btn-bg',
        wsf_button_text: '--wsf-btn-text',
        wsf_button_hover: '--wsf-btn-hover',
        wsf_button_border: '--wsf-btn-border',
        wsf_bg_color: '--wsf-bg',
        wsf_card_bg: '--wsf-card',
        wsf_input_bg: '--wsf-input',
        wsf_text_color: '--wsf-text',
        wsf_option_bg: '--wsf-option-bg',
        wsf_option_text: '--wsf-option-text',
        wsf_arrow_color: '--wsf-arrow',
        wsf_result_color: '--wsf-result-color',
        wsf_label_color: '--wsf-label',
        wsf_border_color: '--wsf-border'
    };

    function setVar(name, value) {
        if (value) {
            preview[0].style.setProperty(name, value);
        } else {
            preview[0].style.removeProperty(name);
        }
    }

    function hexToRgb(hex) {
        var m = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return m ? { r: parseInt(m[1], 16), g: parseInt(m[2], 16), b: parseInt(m[3], 16) } : null;
    }

    function updateScheme(hex) {
        var rgb = hexToRgb(hex);
        if (rgb) {
            var luminance = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
            setVar('--wsf-scheme', luminance > 128 ? 'light' : 'dark');
        } else {
            preview[0].style.removeProperty('--wsf-scheme');
        }
    }

    $('.wsf-color-picker').each(function() {
        var varName = fieldVars[this.id];
        if (!varName) {
            return;
        }

        $(this).wpColorPicker({
            defaultColor: $(this).data('default-color'),
            clearable: false,
            change: function(event, ui) {
                var hex = ui.color ? ui.color.toString() : '';
                setVar(varName, hex);
                if (this.id === 'wsf_input_bg') {
                    updateScheme(hex);
                }
            },
            clear: function() {
                setVar(varName, '');
                if (this.id === 'wsf_input_bg') {
                    updateScheme('');
                }
            }
        });
    });

    $('.wsf-color-clear').on('click', function() {
        var id = $(this).data('target');
        var $input = $('#' + id);
        var varName = fieldVars[id];
        var $container = $input.closest('.wp-picker-container');

        $container.find('.wp-color-picker').val('').trigger('change');
        $container.find('.wp-color-result').css('background-color', '');
        $input.val('');

        if (varName) {
            setVar(varName, '');
        }
        if (id === 'wsf_input_bg') {
            preview[0].style.removeProperty('--wsf-scheme');
        }
    });

    $('#wsf-reset-styles').on('click', function() {
        $('.wsf-preview-toolbar .wsf-color-picker').each(function() {
            var $container = $(this).closest('.wp-picker-container');
            $container.find('.wp-color-picker').val('').trigger('change');
            $container.find('.wp-color-result').css('background-color', '');
            $(this).val('');
        });

        $('#wsf_font_family').val('');
        $('#wsf_input_font_size').val('');
        $('#wsf_input_border_radius').val('');
        $('#wsf_input_padding').val('');
        $('#wsf_result_size').val('');
        $('#wsf_button_radius').val('');

        preview[0].style.removeProperty('--wsf-font');
        preview[0].style.removeProperty('--wsf-input-font-size');
        preview[0].style.removeProperty('--wsf-radius');
        preview[0].style.removeProperty('--wsf-input-pad');
        preview[0].style.removeProperty('--wsf-result-size');
        preview[0].style.removeProperty('--wsf-btn-radius');
        preview[0].style.removeProperty('--wsf-scheme');

        $('#wsf_title_tag').val('h2');
        updatePreviewTitle();
    });

    $('#wsf_font_family').on('input change', function() {
        setVar('--wsf-font', $(this).val().trim());
    });

    $('#wsf_input_font_size').on('input change', function() {
        var v = $(this).val().trim();
        setVar('--wsf-input-font-size', v ? v + 'px' : '');
    });

    $('#wsf_input_border_radius').on('input change', function() {
        var v = $(this).val().trim();
        setVar('--wsf-radius', v ? v + 'px' : '');
    });

    $('#wsf_input_padding').on('input change', function() {
        var v = $(this).val().trim();
        setVar('--wsf-input-pad', v ? v + 'px' : '');
    });

    $('#wsf_result_size').on('input change', function() {
        var v = $(this).val().trim();
        setVar('--wsf-result-size', v ? v + 'px' : '');
    });

    $('#wsf_button_radius').on('input change', function() {
        var v = $(this).val().trim();
        setVar('--wsf-btn-radius', v ? v + 'px' : '');
    });

    function getPreviewTitle() {
        return preview.find('.wsf-title');
    }

    function updatePreviewTitle() {
        var text = $('#wsf_title').val().trim();
        var tag = $('#wsf_title_tag').val() || 'h2';
        var extra = ($('#wsf_title_classes').val() || '').trim();
        var $h = getPreviewTitle();

        if (!text) {
            if ($h.length) {
                $h.remove();
            }
            return;
        }

        if (!$h.length) {
            $h = $('<' + tag + '>').addClass('wsf-title');
            preview.prepend($h);
        }

        if ($h.prop('tagName').toLowerCase() !== tag) {
            var $new = $('<' + tag + '>').attr('class', $h.attr('class')).text($h.text());
            $h.replaceWith($new);
            $h = getPreviewTitle();
        }

        $h.text(text);
        $h.attr('class', 'wsf-title' + (extra ? ' ' + extra : ''));
    }

    $('#wsf_title').on('input', updatePreviewTitle);
    $('#wsf_title_tag').on('change', updatePreviewTitle);
    $('#wsf_title_classes').on('input', updatePreviewTitle);

    function fillSelect(selector, values) {
        var $sel = preview.find(selector);
        if (!$sel.length) {
            return;
        }
        var html = '<option value="">--</option>';
        $.each(values, function(i, v) {
            html += '<option value="' + v + '">' + v + '</option>';
        });
        $sel.html(html).prop('disabled', false).removeAttr('disabled');
    }

    fillSelect('.wsf-width-select', ['205', '215', '225', '235', '245']);
    fillSelect('.wsf-profile-select', ['40', '45', '50', '55', '60', '65']);
    fillSelect('.wsf-rim-select', ['15', '16', '17', '18', '19', '20']);
    fillSelect('.wsf-brand-select', ['BMW', 'FORD', 'TOYOTA', 'VOLKSWAGEN']);
    fillSelect('.wsf-model-select', ['Serie 1', 'Serie 3', 'Serie 5']);
    fillSelect('.wsf-year-select', ['2020', '2021', '2022', '2023', '2024']);
    fillSelect('.wsf-version-select', ['1.6', '2.0', '3.0']);

    preview.find('.wsf-search-btn').removeClass('wsf-hidden');
    preview.find('.wsf-result-preview').each(function() {
        $(this).html('<div class="wsf-tire-size">225/45R17</div>');
    });
});
