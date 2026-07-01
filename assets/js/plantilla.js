// js de la plantilla, solo las funciones que el sitio usa
// el main.js original llamaba plugins que no estaban cargados y eso daba errores en la consola

(function ($) {
    "use strict";

    // preloader (si existe en la pagina)
    $(window).on('load', function () {
        $('#preloader-active').delay(450).fadeOut('slow');
        $('body').delay(450).css({ 'overflow': 'visible' });
    });

    // header pegajoso y boton de subir
    $(window).on('scroll', function () {
        var scroll = $(window).scrollTop();
        if (scroll < 400) {
            $(".header-sticky").removeClass("sticky-bar");
            $('#back-top').fadeOut(500);
        } else {
            $(".header-sticky").addClass("sticky-bar");
            $('#back-top').fadeIn(500);
        }
    });

    $('#back-top a').on("click", function () {
        $('body,html').animate({ scrollTop: 0 }, 800);
        return false;
    });

    // menu para celular (slicknav)
    var menu = $('ul#navigation');
    if (menu.length && $.fn.slicknav) {
        menu.slicknav({
            prependTo: ".mobile_menu",
            closedSymbol: '+',
            openedSymbol: '-'
        });
    }

    // slider principal (solo si la pagina lo tiene y slick esta cargado)
    var slider = $('.slider-active');
    if (slider.length && $.fn.slick) {
        slider.on('init', function () {
            animarElementos($('.single-slider:first-child').find('[data-animation]'));
        });
        slider.on('beforeChange', function (e, slick, actual, siguiente) {
            animarElementos($('.single-slider[data-slick-index="' + siguiente + '"]').find('[data-animation]'));
        });
        slider.slick({
            autoplay: true,
            autoplaySpeed: 5000,
            dots: false,
            fade: true,
            arrows: false
        });
    }

    function animarElementos(elementos) {
        var eventosFin = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        elementos.each(function () {
            var $el = $(this);
            var retraso = $el.data('delay');
            var tipo = 'animated ' + $el.data('animation');
            $el.css({ 'animation-delay': retraso, '-webkit-animation-delay': retraso });
            $el.addClass(tipo).one(eventosFin, function () {
                $el.removeClass(tipo);
            });
        });
    }

    // selects con estilo (nice-select)
    var selects = $('select.con-estilo');
    if (selects.length && $.fn.niceSelect) {
        selects.niceSelect();
    }

    // fondos definidos con data-background
    $("[data-background]").each(function () {
        $(this).css("background-image", "url(" + $(this).attr("data-background") + ")");
    });

    // animaciones wow (solo si la libreria esta cargada)
    if (typeof WOW === 'function') {
        new WOW().init();
    }

    // galerias emergentes (solo si magnific popup esta cargado)
    var popup = $('.single_gallery_part, .img-pop-up');
    if (popup.length && $.fn.magnificPopup) {
        popup.magnificPopup({ type: 'image', gallery: { enabled: true } });
    }

})(jQuery);
