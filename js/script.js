var swiper = new Swiper(".slide-container", {
    spaceBetween: 20,
    loop: true,
    centerSlide: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },

    breakpoints: {
        0: {
            slidesPerView: 1,
            slidesPerGroup: 1,
        },
        520: {
            slidesPerView: 2,
            slidesPerGroup: 2,
        },
        769: {
            slidesPerView: 3,
            slidesPerGroup: 3,
        },
        1000: {
            slidesPerView: 4,
            slidesPerGroup: 4,
        },
    }
});
