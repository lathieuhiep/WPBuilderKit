(function ($) {
    "use strict";

    $(document).ready(function () {
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

        $('.single_add_to_cart_button').html('<i class="ic-mask ic-mask-cart-plus"></i>');
    });

})(jQuery);