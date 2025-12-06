/**
 * LeCharme - Product Slider
 */

/**
 * LeCharme - Product Slider
 */

// Swiper
const productSwiper = new Swiper('#product__slider__swiper', {
    slidesPerView: 1,
    spaceBetween: 16,
    loop: true,
    grabCursor: true,

    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
    },

    navigation: {
        nextEl: '.swiper-nav--next',
        prevEl: '.swiper-nav--prev',
    },

    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },

    breakpoints: {
        576: { slidesPerView: 2, spaceBetween: 16 },
        768: { slidesPerView: 3, spaceBetween: 16 },
        1024: { slidesPerView: 4, spaceBetween: 20 },
    },
});

// Add to Cart
document.querySelectorAll('.product__slider__card__add-to-cart').forEach(btn => {
    btn.addEventListener('click', function() {
        const original = this.innerHTML;
        this.classList.add('loading');
        this.innerHTML = '<span class="spinner"></span>';
        this.disabled = true;

        // Simulate API
        setTimeout(() => {
            this.classList.remove('loading');
            this.classList.add('added');
            this.innerHTML = '<i class="bi bi-check2"></i> Eklendi';

            setTimeout(() => {
                this.classList.remove('added');
                this.innerHTML = original;
                this.disabled = false;
            }, 1500);
        }, 500);
    });
});

// Wishlist
document.querySelectorAll('.product__slider__card__wishlist').forEach(btn => {
    btn.addEventListener('click', function() {
        this.classList.toggle('active');
    });
});
