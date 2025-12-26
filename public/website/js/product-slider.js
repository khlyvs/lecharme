/**
 * LeCharme - Product Slider
 * With DoS/DDoS protection (frontend throttling)
 */

(function() {
    'use strict';

    // Cache selectors
    const SELECTORS = {
        swiper: '#product__slider__swiper',
        addToCart: '.product__slider__card__add-to-cart, #product_detail___btn_cart ',
        wishlist: '.product__slider__card__wishlist',
        basketCount: '.basket-count, #basket-count, [data-basket-count]'
    };

    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

    // Request tracking for throttling (prevents spam clicks)
    const pendingRequests = new Set();
    const THROTTLE_DELAY = 1000; // Minimum 1 second between requests per product

    // Swiper initialization
    const productSwiper = new Swiper(SELECTORS.swiper, {
        slidesPerView: 1,
        spaceBetween: 16,
        loop: true,
        grabCursor: true,
        speed: 600,
        effect: 'slide',
        watchOverflow: true,
        normalizeSlideIndex: true,
        touchEventsTarget: 'container',
        touchRatio: 1,
        touchAngle: 45,
        resistance: true,
        resistanceRatio: 0.85,
        longSwipesRatio: 0.5,
        longSwipesMs: 300,
        followFinger: true,

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
            dynamicBullets: true,
        },

        breakpoints: {
            576: { slidesPerView: 2, spaceBetween: 16 },
            768: { slidesPerView: 3, spaceBetween: 16 },
            1024: { slidesPerView: 4, spaceBetween: 20 },
        },
    });

    /**
     * Button state management
     */
    function setButtonState(btn, state, content) {
        btn.classList.remove('loading', 'added', 'error');
        if (state) btn.classList.add(state);
        btn.innerHTML = content;
        btn.disabled = state === 'loading';
    }

    function resetButton(btn, originalContent, delay = 1500) {
        setTimeout(() => {
            setButtonState(btn, null, originalContent);
        }, delay);
    }

    /**
     * Add to Cart handler with throttling
     */
    async function handleAddToCart(btn) {
        const productId = btn.dataset.id || btn.dataset.productId;
        if (!productId) return;

        // Prevent duplicate/spam requests
        if (pendingRequests.has(productId)) {
            return;
        }

        pendingRequests.add(productId);
        const originalContent = btn.innerHTML;
        setButtonState(btn, 'loading', '<span class="spinner"></span>');

        // Get quantity from product detail input or default to 1
        const qtyInput = document.getElementById('product_detail___qty_input');
        const quantity = qtyInput ? parseInt(qtyInput.value) || 1 : 1;

        try {
            const response = await fetch(`/basket/add/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({ quantity: quantity })
            });

            // Handle rate limit (429 Too Many Requests)
            if (response.status === 429) {
                setButtonState(btn, 'error', '<i class="bi bi-exclamation-circle"></i> <span>Çox sürətli!</span>');
                resetButton(btn, originalContent, 3000);
                return;
            }

            const data = await response.json();

            if (data.status === 'success') {
                setButtonState(btn, 'added', '<i class="bi bi-check2"></i> Əlavə edildi');

                // Update basket count
                const basketCountEl = document.querySelector(SELECTORS.basketCount);
                if (basketCountEl && data.basket_count !== undefined) {
                    basketCountEl.textContent = data.basket_count;
                }

                resetButton(btn, originalContent, 1500);
            } else {
                const errorMsg = data.message || 'Xəta baş verdi';
                setButtonState(btn, 'error', `<i class="bi bi-exclamation-circle"></i> <span>${errorMsg}</span>`);
                resetButton(btn, originalContent, 3000);
            }

        } catch {
            setButtonState(btn, 'error', '<i class="bi bi-exclamation-circle"></i> <span>Bağlantı xətası</span>');
            resetButton(btn, originalContent, 3000);
        } finally {
            // Release throttle after delay
            setTimeout(() => {
                pendingRequests.delete(productId);
            }, THROTTLE_DELAY);
        }
    }

    /**
     * Wishlist toggle handler
     */
    function handleWishlistToggle(btn) {
        const icon = btn.querySelector('i');
        if (!icon) return;

        btn.classList.toggle('active');
        const isActive = btn.classList.contains('active');

        icon.classList.toggle('bi-heart', !isActive);
        icon.classList.toggle('bi-heart-fill', isActive);
    }

    // Event delegation for better performance
    document.addEventListener('click', (e) => {
        const addToCartBtn = e.target.closest(SELECTORS.addToCart);
        if (addToCartBtn) {
            e.preventDefault();
            handleAddToCart(addToCartBtn);
            return;
        }

        const wishlistBtn = e.target.closest(SELECTORS.wishlist);
        if (wishlistBtn) {
            e.preventDefault();
            handleWishlistToggle(wishlistBtn);
        }
    });

})();
