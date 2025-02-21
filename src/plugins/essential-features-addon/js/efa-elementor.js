(function ($) {
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

    $(window).on('elementor/frontend/init', function () {
        /* Element slider */
        elementorFrontend.hooks.addAction('frontend/element_ready/efa-slides.default', ElementCarouselSlider);

        /* Element post carousel */
        elementorFrontend.hooks.addAction('frontend/element_ready/efa-post-carousel.default', ElementCarouselSlider);

        /* Element testimonial slider */
        elementorFrontend.hooks.addAction('frontend/element_ready/efa-testimonial-slider.default', ElementCarouselSlider);

        /* Element carousel images */
        elementorFrontend.hooks.addAction('frontend/element_ready/efa-carousel-images.default', ElementCarouselSlider);
    });

})(jQuery);