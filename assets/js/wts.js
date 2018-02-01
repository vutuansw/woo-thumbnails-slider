/**
 * WooCommerce Thumbnails Slider js front-end
 */
jQuery(function ($) {
    'use strict';


    if ($.fn.flexslider && $('.wts_control_nav').length) {

        var data = $('.wts_control_nav').data('options');

        setTimeout(function () {
            $('.wts_control_nav').appendTo('.woocommerce-product-gallery').show();
            $('.wts_control_nav').flexslider(data);
        }, 10);


        $('.variations_form.cart').on('found_variation', function (e, variation) {

            setTimeout(function () {

                var $activeItem = $('.wts_control_nav li img[src="' + variation.image.thumb_src + '"]');

                if ($activeItem.length) {
                    $activeItem.attr('srcset', '');
                    $('.wts_control_nav').flexslider($activeItem.index());
                }

            }, 10);

        });


        $('.variations_form.cart').on('click', '.reset_variations', function (e) {

            $('.wts_control_nav').flexslider(0);

            e.preventDefault();

        })

    }

});