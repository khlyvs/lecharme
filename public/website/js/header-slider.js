// Swiper Slider Initialization
document.addEventListener('DOMContentLoaded', function() {
    // Main Slider
    const mainSwiper = new Swiper('.main-slider', {
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        speed: 1000,
        effect: 'slide',

        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            dynamicBullets: true,
        },

        keyboard: {
            enabled: true,
        },

        // Smooth transitions
        fadeEffect: {
            crossFade: true
        },
    });

    // Pause autoplay on hover
    const mainSlider = document.querySelector('.main-slider');
    if (mainSlider) {
        mainSlider.addEventListener('mouseenter', () => {
            mainSwiper.autoplay.stop();
        });

        mainSlider.addEventListener('mouseleave', () => {
            mainSwiper.autoplay.start();
        });
    }

    // Campaign Products Slider with Fade Effect
    const campaignSwiper = new Swiper('.campaign-slider', {
        loop: true,
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        speed: 800,

        pagination: {
            el: '.campaign-pagination',
            clickable: true,
            dynamicBullets: true,
        },

        keyboard: {
            enabled: true,
        },
    });

    // Pause campaign slider autoplay on hover
    const campaignSlider = document.querySelector('.campaign-slider');
    if (campaignSlider) {
        campaignSlider.addEventListener('mouseenter', () => {
            campaignSwiper.autoplay.stop();
        });

        campaignSlider.addEventListener('mouseleave', () => {
            campaignSwiper.autoplay.start();
        });
    }

    // Add click event to cart buttons
    const cartButtons = document.querySelectorAll('.btn-add-cart-icon');
    cartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productName = this.closest('.campaign-item').querySelector('.product-name a').textContent;

            // Store original content
            const originalHTML = this.innerHTML;
            const originalBg = this.style.background;

            // Add success state with animation
            this.innerHTML = '<i class="fas fa-check"></i>';
            this.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
            this.style.pointerEvents = 'none';
            this.style.transform = 'scale(1.1)';

            // Reset after 2 seconds
            setTimeout(() => {
                this.innerHTML = originalHTML;
                this.style.background = originalBg || '';
                this.style.pointerEvents = '';
                this.style.transform = '';
            }, 2000);

            console.log(`${productName} sepete eklendi!`);
        });
    });

    // Countdown Timer
    function updateCountdown() {
        // Set end date (7 days from now)
        const endDate = new Date();
        endDate.setDate(endDate.getDate() + 7);
        endDate.setHours(23, 59, 59, 999);

        const now = new Date().getTime();
        const distance = endDate.getTime() - now;

        if (distance < 0) {
            // Reset to 7 days if expired
            endDate.setDate(endDate.getDate() + 7);
            const newDistance = endDate.getTime() - now;
            updateDisplay(newDistance);
        } else {
            updateDisplay(distance);
        }
    }

    function updateDisplay(distance) {
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        const daysEl = document.getElementById('days');
        const hoursEl = document.getElementById('hours');
        const minutesEl = document.getElementById('minutes');
        const secondsEl = document.getElementById('seconds');

        if (daysEl) daysEl.textContent = String(days).padStart(2, '0');
        if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
        if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
        if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
    }

    // Initialize countdown and update every second
    updateCountdown();
    setInterval(updateCountdown, 1000);
});
