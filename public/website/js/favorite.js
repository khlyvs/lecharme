/**
 * LeCharme - Favorites Page
 */

(function() {
    'use strict';

    const grid = document.getElementById('favorites__grid');
    const emptyState = document.getElementById('favorites__empty');
    const countEl = document.getElementById('favorites__count');
    const clearBtn = document.getElementById('favorites__clear-btn');
    const viewBtns = document.querySelectorAll('.favorites__view-btn');

    // View Toggle
    viewBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            viewBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            if (btn.dataset.view === 'list') {
                grid.classList.add('list-view');
            } else {
                grid.classList.remove('list-view');
            }
        });
    });

    // Update Count
    function updateCount() {
        const cards = grid.querySelectorAll('.favorites__card:not(.removing)');
        const count = cards.length;

        if (countEl) {
            countEl.textContent = count;
        }

        if (count === 0) {
            grid.style.display = 'none';
            emptyState.style.display = 'block';
        } else {
            grid.style.display = '';
            emptyState.style.display = 'none';
        }
    }

    // Remove Item
    function removeItem(card) {
        card.classList.add('removing');

        card.addEventListener('animationend', () => {
            card.remove();
            updateCount();
        }, { once: true });
    }

    // Remove Buttons
    document.querySelectorAll('.favorites__card-remove').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const card = btn.closest('.favorites__card');
            if (card) {
                removeItem(card);
            }
        });
    });

    // Clear All
    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            const cards = grid.querySelectorAll('.favorites__card');

            if (cards.length === 0) return;

            if (!confirm('Tüm favorileri silmek istediğinize emin misiniz?')) {
                return;
            }

            cards.forEach((card, index) => {
                setTimeout(() => {
                    removeItem(card);
                }, index * 50);
            });
        });
    }

    // Add to Cart
   

    // Quick View
    document.querySelectorAll('.favorites__quick-view').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const card = btn.closest('.favorites__card');
            const productId = card?.dataset.productId;
            console.log('Quick view:', productId);
        });
    });

    // Init
    updateCount();

})();
