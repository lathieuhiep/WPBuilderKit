(function ($) {
    "use strict";

    $(document).on('click', '.remove-custom-mini-cart', function (e) {
        const btn = $(this);

        // Nếu spinner đã tồn tại thì không làm gì nữa
        if (btn.closest('.item').find('.block-ui-spinner').length === 0) {
            // Thêm spinner phủ lên sản phẩm đang xóa
            btn.closest('.item').append('<div class="block-ui-spinner"></div>');
        }

        // Ngăn click liên tục (opt)
        btn.addClass('is-loading').prop('disabled', true);
    });

})(jQuery);