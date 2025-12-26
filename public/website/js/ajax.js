/**
 * LeCharme - AJAX Handlers
 * With DoS/DDoS protection (frontend throttling)
 */

(function($) {
    'use strict';

    // CSRF Setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Request tracking for throttling
    const pendingFavorites = new Set();
    const THROTTLE_DELAY = 1000;

    // ===============================
    // WISHLIST (FAVORITE)
    // ===============================
    $(document).on('click', '.product__slider__card__wishlist', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const btn = $(this);
        const icon = btn.find('i');
        const productId = btn.data('id');

        if (!productId) {
            return;
        }

        // Prevent duplicate/spam requests
        if (pendingFavorites.has(productId)) {
            return;
        }

        pendingFavorites.add(productId);
        btn.prop('disabled', true);

        $.ajax({
            url: '/favorite/' + productId,
            type: 'POST',
            success: function() {
                icon.toggleClass('bi-heart bi-heart-fill');
                btn.toggleClass('active');
            },
            error: function(xhr) {
                // Handle rate limit (429)
                if (xhr.status === 429) {
                    console.warn('Rate limited - too many requests');
                }
            },
            complete: function() {
                btn.prop('disabled', false);
                // Release throttle after delay
                setTimeout(function() {
                    pendingFavorites.delete(productId);
                }, THROTTLE_DELAY);
            }
        });
    });

})(jQuery);
