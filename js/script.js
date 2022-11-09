// menu
const menuu = document.querySelector('#menuu');
const showmenu = document.querySelector('#showmenu');

menuu.addEventListener('click', function() {
    menuu.classList.toggle('menuu_active');
    showmenu.classList.toggle('hidden');
});

// swiper


var swiperhero = new Swiper(".one", {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    fade: 'true',
    autoplay: {
        delay: 2000,
    },

    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },

    navigation: {
        nextEl: ".btn-next",
        prevEl: ".btn-prev",
    },

    // breakpoints: {
    //     0: {
    //         slidesPerView: 1,
    //     },
    //     520: {
    //         slidesPerView: 2,
    //     },
    //     756: {
    //         slidesPerView: 3,
    //     },
    //     1000: {
    //         slidesPerView: 3,
    //     },
    // },
});

var swiper = new Swiper(".swiper.two", {
    slidesPerView: 2,
    spaceBetween: 0,
    loop: false,
    centerSlide: 'true',
    fade: 'true',

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
        756: {
            slidesPerView: 2,
        },
        1000: {
            slidesPerView: 3,
        },
    },
});