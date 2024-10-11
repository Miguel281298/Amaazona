var swiper = new Swiper(".slide-container", {
    spaceBetween: 20,
    slidesPerGroup: 1,
    loop: true,
    centerSlide: true,
    speed: 1500, 
    autoplay: {
        delay: 4000,
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
        },
        520: {
            slidesPerView: 2,
        },
        769: {
            slidesPerView: 3,
        },
        1000: {
            slidesPerView: 4,
        },
    }
});
