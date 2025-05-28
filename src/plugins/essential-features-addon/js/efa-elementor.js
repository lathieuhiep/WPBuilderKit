(function ($) {
    // merge the default options with the user defined options
    const swiperOptions = (options, $slider) => {
        let defaults = {
            loop: true,
            speed: 800,
            autoplay: false,
            navigation: false,
            pagination: false
        };

        // Merge options
        let config = $.extend({}, defaults, options);

        // check pagination
        if (config.pagination) {
            if ($slider.find('.swiper-pagination').length) {
                config.pagination = {
                    el: $slider.find('.swiper-pagination')[0],
                    clickable: true
                };
            } else {
                config.pagination = false;
            }
        }

        // check navigation
        if (config.navigation) {
            if ($slider.find('.swiper-button-next').length && $slider.find('.swiper-button-prev').length) {
                config.navigation = {
                    nextEl: $slider.find('.swiper-button-next')[0],
                    prevEl: $slider.find('.swiper-button-prev')[0]
                };
            } else {
                config.navigation = false;
            }
        }

        // check autoplay
        if(config.autoplay && typeof config.autoplay === 'object'){
            // Do not change
        } else if(config.autoplay === true){
            config.autoplay = { delay: 4000, disableOnInteraction: false };
        } else {
            config.autoplay = false;
        }

        return config;
    }

    // setting owlCarousel
    const owlCarouselOptions = (options) => {
        let defaults = {
            loop: true,
            smartSpeed: 800,
            autoplaySpeed: 800,
            navSpeed: 800,
            dotsSpeed: 800,
            dragEndSpeed: 800,
            navText: ['<i class="efa-icon-mask efa-icon-mask-angle-left"></i>','<i class="efa-icon-mask efa-icon-mask-angle-right"></i>'],
        }

        // extend options
        return $.extend(defaults, options)
    }

    /* Start Carousel slider */
    let ElementCarouselSlider = function ($scope, $) {
        let slider = $scope.find('.custom-owl-carousel');

        if ( slider.length ) {
            const options = slider.data('settings-owl');
            slider.owlCarousel(owlCarouselOptions(options))
        }
    };

    const EFAInitCarouselSliders = ($scope) => {
        let $slider = $scope.find('.custom-swiper-slider');

        if ( $slider.length && !$slider.hasClass('swiper-initialized') ) {
            // Lấy config từ data attribute
            let options = $slider.data('settings-swiper');
            let config = swiperOptions(options, $slider);

            // Khởi tạo Swiper
            new Swiper($slider.get(0), config);

            // Đánh dấu đã init
            $slider.addClass('swiper-initialized');
        }
    }

    $(window).on('elementor/frontend/init', function () {
        /* Element slider */
        elementorFrontend.hooks.addAction('frontend/element_ready/efa-slides.default', ElementCarouselSlider);

        /* Element post carousel */
        elementorFrontend.hooks.addAction('frontend/element_ready/efa-post-carousel.default', ElementCarouselSlider);

        /* Element testimonial slider */
        elementorFrontend.hooks.addAction('frontend/element_ready/efa-testimonial-slider.default', EFAInitCarouselSliders);

        /* Element carousel images */
        elementorFrontend.hooks.addAction('frontend/element_ready/efa-carousel-images.default', ElementCarouselSlider);
    });

})(jQuery);