// JS for BeforeAfter block
document.addEventListener('DOMContentLoaded', function () {
    const swiper = new Swiper('.before-after-swiper', {
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
        },
        slidesPerView: 1,
        spaceBetween: 30
    });

    document.querySelectorAll('.beer-slider').forEach(function(slider) {
        new BeerSlider(slider);
    });
});