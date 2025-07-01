(function ($) {
    "use strict";

    // event remove product mini cart
    $(document).on('click', '.remove-custom-mini-cart', function (e) {
        const btn = $(this);

        if (btn.closest('.item').find('.block-ui-spinner').length === 0) {
            // Thêm spinner phủ lên sản phẩm đang xóa
            btn.closest('.item').append('<div class="block-ui-spinner"></div>');
        }

        btn.addClass('is-loading').prop('disabled', true);
    });

    // event qty
    const updateQty = (input, delta) => {
        const current = parseFloat(input.val());
        const min = parseFloat(input.attr('min')) || 0;
        const max = parseFloat(input.attr('max')) || Infinity;
        const step = parseFloat(input.attr('step')) || 1;
        let newVal = current + (delta * step);

        if (newVal < min) newVal = min;
        if (newVal > max) newVal = max;

        input.val(newVal).trigger('change');
    }

    $(document).on('click', '.qty-minus', function() {
        const input = $(this).siblings('input.qty');
        updateQty(input, -1);
    });

    $(document).on('click', '.qty-plus', function() {
        const input = $(this).siblings('input.qty');
        updateQty(input, 1);
    });

})(jQuery);