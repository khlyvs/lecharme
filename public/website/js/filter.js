/**
 * LeCharme - Products Page
 * Sadece UI İşlevleri
 */

(function() {
    'use strict';

    // ============================================
    // Mobile Filter Sidebar
    // ============================================

    const filterToggle = document.getElementById('filter__mobile-toggle');
    const filterSidebar = document.getElementById('filter__sidebar');
    const filterOverlay = document.getElementById('filter__overlay');
    const filterClose = document.getElementById('filter__close');

    function openFilter() {
        if (!filterSidebar || !filterOverlay) return;
        filterSidebar.classList.add('active');
        filterOverlay.classList.add('active');
        filterToggle?.classList.add('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeFilter() {
        if (!filterSidebar || !filterOverlay) return;
        filterSidebar.classList.remove('active');
        filterOverlay.classList.remove('active');
        filterToggle?.classList.remove('hidden');
        document.body.style.overflow = '';
    }

    filterToggle?.addEventListener('click', openFilter);
    filterClose?.addEventListener('click', closeFilter);
    filterOverlay?.addEventListener('click', closeFilter);

    // ESC tuşu ile kapatma
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && filterSidebar?.classList.contains('active')) {
            closeFilter();
        }
    });

    // ============================================
    // Badge Toggle (Görsel)
    // ============================================

    document.querySelectorAll('.filter__badge').forEach(badge => {
        badge.addEventListener('click', () => {
            badge.classList.toggle('active');
        });
    });

    // ============================================
    // Wishlist Toggle (Görsel)
    // ============================================

    document.querySelectorAll('.product__slider__card__wishlist').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            btn.classList.toggle('active');
            const icon = btn.querySelector('i');
            icon.classList.toggle('bi-heart');
            icon.classList.toggle('bi-heart-fill');
        });
    });

})();
