(function ($) {
    "use strict";

    $(document).ready(function () {
        const $form = $('form.variations_form');
        const variations = $form.data('product_variations');
        const $allSwatchGroups = $('.efa-swatch');

        // Lấy các lựa chọn hiện tại (swatch đang chọn)
        function getCurrentSelection() {
            const selection = {};
            $allSwatchGroups.each(function () {
                const $group = $(this);
                const name = $group.data('attribute_name');
                const $selected = $group.find('.efa-swatch-item.is-selected');
                if ($selected.length) {
                    selection[name] = $selected.data('value');
                }
            });
            return selection;
        }

        // Cập nhật trạng thái disabled cho từng swatch
        function updateSwatchState() {
            const currentSelection = getCurrentSelection();

            $allSwatchGroups.each(function () {
                const $group = $(this);
                const attrName = $group.data('attribute_name');

                $group.find('.efa-swatch-item').each(function () {
                    const $item = $(this);
                    const val = $item.data('value');

                    const testSelection = { ...currentSelection, [attrName]: val };

                    const isValid = variations.some(variation => {
                        return Object.entries(testSelection).every(([k, v]) => {
                            return variation.attributes[k] === '' || variation.attributes[k] === v;
                        });
                    });

                    $item.toggleClass('disabled', !isValid);
                });
            });
        }

        // Highlight swatch khi trang load lại có biến thể từ URL
        function restoreSwatchFromSelect() {
            $form.find('select[name^="attribute_"]').each(function () {
                const name = $(this).attr('name');
                const val = $(this).val();
                if (val) {
                    $(`.efa-swatch[data-attribute_name="${name}"] .efa-swatch-item`).removeClass('is-selected');
                    $(`.efa-swatch[data-attribute_name="${name}"] .efa-swatch-item[data-value="${val}"]`).addClass('is-selected');
                }
            });
        }

        // Xử lý khi chọn swatch
        $allSwatchGroups.on('click', '.efa-swatch-item', function () {
            const $itemSwatch = $(this);
            const $groupSwatch = $itemSwatch.closest('.efa-swatch');
            const valueSwatch = $itemSwatch.data('value');
            const attributeName = $groupSwatch.data('attribute_name');

            if ($itemSwatch.hasClass('disabled')) return;

            // Highlight item được chọn
            $groupSwatch.find('.efa-swatch-item').removeClass('is-selected');
            $itemSwatch.addClass('is-selected');

            // Gán vào <select> để WooCommerce xử lý
            const $selectAttr = $form.find('select[name="' + attributeName + '"]');
            $selectAttr.val(valueSwatch).trigger('change');

            // Trigger update cho các trường khác
            updateSwatchState();

            // Trigger WooCommerce để hiển thị ảnh, giá, nút cart
            $form.find('select[name^="attribute_"]').trigger('change');
        });

        // Xử lý nút reset
        $form.on('click', '.reset_variations', function () {
            $('.efa-swatch .efa-swatch-item').removeClass('is-selected disabled');

            // Khôi phục lại các swatch sau reset
            setTimeout(() => {
                restoreSwatchFromSelect();
                updateSwatchState();
            }, 10);
        });

        // Hook vào các sự kiện WooCommerce
        $form.on('woocommerce_variation_has_changed check_variations woocommerce_update_variation_values', function () {
            updateSwatchState();
        });

        // Gọi khi trang load
        restoreSwatchFromSelect();
        updateSwatchState();
    });
})(jQuery);