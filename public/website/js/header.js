// LeCharme E-Ticaret - Performans Optimize Edilmiş
// - Event delegation ile tek listener
// - Cached DOM queries
// - Passive listeners
// - Memory leak önleme
(function() {
    'use strict';

    // ===== CACHED DOM ELEMENTS =====
    const cache = {
        body: document.body,
        languageSelectors: null,
        userSelectors: null,
        catalogMenu: null,
        hamburgerButtons: null,
        allLangOptions: null,
        searchWrappers: null,
        categoryList: null
    };

    // ===== STATE =====
    let bsOffcanvasInstance = null;
    const menuState = {
        isOpen: false,
        isHovering: false,
        isHoveringMenu: false,
        openTimeout: null,
        closeTimeout: null,
        isTouchDevice: false
    };

    // ===== UTILITIES =====
    const isTouchDevice = () => {
        return 'ontouchstart' in window || navigator.maxTouchPoints > 0;
    };

    const removeBackdrop = () => {
        const backdrop = document.querySelector('.offcanvas-backdrop');
        if (backdrop) backdrop.remove();
        cache.body.classList.remove('modal-open');
        cache.body.style.cssText = '';
    };

    const clearAllTimeouts = () => {
        if (menuState.openTimeout) clearTimeout(menuState.openTimeout);
        if (menuState.closeTimeout) clearTimeout(menuState.closeTimeout);
        menuState.openTimeout = menuState.closeTimeout = null;
    };

    const closeAllLanguage = () => {
        cache.languageSelectors.forEach(sel => sel.classList.remove('active'));
    };

    const closeAllUser = () => {
        cache.userSelectors.forEach(sel => sel.classList.remove('active'));
    };

    // ===== INIT =====
    function init() {
        // Cache all elements once
        cache.languageSelectors = document.querySelectorAll('.language-selector');
        cache.userSelectors = document.querySelectorAll('.user-selector');
        cache.catalogMenu = document.getElementById('catalogMenu');
        cache.hamburgerButtons = document.querySelectorAll('.hamburger-btn');
        cache.allLangOptions = document.querySelectorAll('.lang-option');
        cache.searchWrappers = document.querySelectorAll('.search-wrapper');
        cache.categoryList = document.getElementById('categoryList');

        menuState.isTouchDevice = isTouchDevice();

        // Set default language
        if (cache.allLangOptions.length && !document.querySelector('.lang-option.active')) {
            const fallback = document.querySelector('.lang-option[data-lang="az"]');
            if (fallback) fallback.classList.add('active');
        }

        // ===== SINGLE DOCUMENT CLICK HANDLER (Event Delegation) =====
        document.addEventListener('click', handleDocumentClick, { passive: false });

        // ===== CATEGORY LIST =====
        if (cache.categoryList) {
            cache.categoryList.addEventListener('click', handleCategoryClick, { passive: false });
        }

        // ===== HAMBURGER MENU =====
        initHamburgerMenu();

        // ===== SEARCH =====
        initSearch();

        // ===== KEYBOARD =====
        document.addEventListener('keydown', handleKeydown, { passive: true });
    }

    // ===== DOCUMENT CLICK HANDLER =====
    function handleDocumentClick(e) {
        const target = e.target;

        // Language button
        const langBtn = target.closest('.language-btn, #languageBtn, #languageBtnMobile');
        if (langBtn) {
            e.stopPropagation();
            const selector = langBtn.closest('.language-selector');
            if (selector) {
                closeAllUser();
                cache.languageSelectors.forEach(s => s !== selector && s.classList.remove('active'));
                selector.classList.toggle('active');
            }
            return;
        }

        // Language option
        if (target.closest('.lang-option')) {
            e.stopPropagation();
            const opt = target.closest('.lang-option');
            cache.allLangOptions.forEach(o => o.classList.remove('active'));
            opt.classList.add('active');
            closeAllLanguage();
            closeAllUser();
            return;
        }

        // User button
        const userBtn = target.closest('.user-btn, #userBtn, #userBtnMobile');
        if (userBtn) {
            e.stopPropagation();
            const selector = userBtn.closest('.user-selector');
            if (selector) {
                closeAllLanguage();
                cache.userSelectors.forEach(s => s !== selector && s.classList.remove('active'));
                selector.classList.toggle('active');
            }
            return;
        }

        // User option
        if (target.closest('.user-option')) {
            e.stopPropagation();
            closeAllUser();
            closeAllLanguage();
            return;
        }

        // Hamburger button
        if (target.closest('.hamburger-btn')) {
            e.preventDefault();
            e.stopPropagation();
            clearAllTimeouts();
            menuState.isOpen ? closeMenu() : openMenu();
            return;
        }

        // Click outside - close all dropdowns
        if (!target.closest('.language-selector') && !target.closest('.user-selector')) {
            closeAllLanguage();
            closeAllUser();
        }

        // Click outside menu
        if (menuState.isOpen && cache.catalogMenu && !cache.catalogMenu.contains(target) && !target.closest('.hamburger-btn')) {
            closeMenu();
        }

        // Click outside search - but allow clicks inside dropdown
        cache.searchWrappers.forEach(wrapper => {
            const dropdown = wrapper.querySelector('.search-dropdown');
            const isInsideWrapper = wrapper.contains(target);
            const isInsideDropdown = dropdown && dropdown.contains(target);

            if (!isInsideWrapper && !isInsideDropdown) {
                wrapper.classList.remove('search-active', 'search-focused');
            }
        });
    }

    // ===== CATEGORY CLICK =====
    function handleCategoryClick(e) {
        const link = e.target.closest('.category-link');
        if (!link) return;

        e.preventDefault();
        const item = link.closest('.category-item');
        if (!item) return;

        const isActive = item.classList.contains('active');
        cache.categoryList.querySelectorAll('.category-item').forEach(i => {
            if (i !== item) i.classList.remove('active');
        });
        item.classList.toggle('active', !isActive);
    }

    // ===== HAMBURGER MENU =====
    function initHamburgerMenu() {
        if (!cache.catalogMenu) return;

        const getOffcanvasInstance = () => {
            if (!bsOffcanvasInstance && window.bootstrap?.Offcanvas) {
                bsOffcanvasInstance = new bootstrap.Offcanvas(cache.catalogMenu, {
                    backdrop: false,
                    keyboard: true,
                    scroll: true
                });
            }
            return bsOffcanvasInstance;
        };

        window.openMenu = function() {
            const instance = getOffcanvasInstance();
            if (instance && !menuState.isOpen) {
                instance.show();
                menuState.isOpen = true;
            }
        };

        window.closeMenu = function() {
            const instance = getOffcanvasInstance();
            if (instance && menuState.isOpen) {
                instance.hide();
                menuState.isOpen = false;
            }
        };

        const safeClose = () => {
            clearAllTimeouts();
            menuState.closeTimeout = setTimeout(() => {
                if (!menuState.isHovering && !menuState.isHoveringMenu) {
                    closeMenu();
                }
            }, 400);
        };

        // Hamburger hover (desktop only)
        if (!menuState.isTouchDevice) {
            cache.hamburgerButtons.forEach(btn => {
                btn.addEventListener('mouseenter', () => {
                    menuState.isHovering = true;
                    clearAllTimeouts();
                    menuState.openTimeout = setTimeout(() => {
                        if (menuState.isHovering) openMenu();
                    }, 200);
                }, { passive: true });

                btn.addEventListener('mouseleave', () => {
                    menuState.isHovering = false;
                    safeClose();
                }, { passive: true });
            });

            cache.catalogMenu.addEventListener('mouseenter', () => {
                menuState.isHoveringMenu = true;
                clearAllTimeouts();
            }, { passive: true });

            cache.catalogMenu.addEventListener('mouseleave', () => {
                menuState.isHoveringMenu = false;
                safeClose();
            }, { passive: true });
        }

        // Update hamburger visual state
        const updateHamburgerState = (isOpen) => {
            cache.hamburgerButtons.forEach(btn => btn.classList.toggle('menu-open', isOpen));
        };

        // Bootstrap events
        cache.catalogMenu.addEventListener('shown.bs.offcanvas', () => {
            menuState.isOpen = true;
            updateHamburgerState(true);
            removeBackdrop();
        }, { passive: true });

        cache.catalogMenu.addEventListener('hidden.bs.offcanvas', () => {
            menuState.isOpen = false;
            menuState.isHovering = false;
            menuState.isHoveringMenu = false;
            updateHamburgerState(false);
            removeBackdrop();
        }, { passive: true });

        cache.catalogMenu.addEventListener('hide.bs.offcanvas', removeBackdrop, { passive: true });
    }

    // ===== SEARCH =====
    function initSearch() {
        cache.searchWrappers.forEach(wrapper => {
            const input = wrapper.querySelector('.search-input');
            const dropdown = wrapper.querySelector('.search-dropdown');
            const searchBtn = wrapper.querySelector('.search-btn');

            if (!input || !dropdown) return;

            const sections = {
                popular: dropdown.querySelector('.search-popular'),
                results: dropdown.querySelector('.search-results'),
                noResults: dropdown.querySelector('.search-no-results'),
                loading: dropdown.querySelector('.search-loading')
            };

            const showSection = (type) => {
                sections.popular && (sections.popular.style.display = type === 'popular' ? '' : 'none');
                sections.results && (sections.results.style.display = type === 'results' ? '' : 'none');
                sections.noResults && (sections.noResults.style.display = type === 'no-results' ? '' : 'none');
                sections.loading && (sections.loading.style.display = type === 'loading' ? '' : 'none');
            };

            // Focus
            input.addEventListener('focus', () => {
                wrapper.classList.add('search-active', 'search-focused');
                showSection('popular');
            }, { passive: true });

            // Blur - use timeout to allow click on dropdown items
            input.addEventListener('blur', () => {
                setTimeout(() => {
                    if (!wrapper.contains(document.activeElement)) {
                        wrapper.classList.remove('search-focused');
                    }
                }, 150);
            }, { passive: true });

            // Input
            let searchTimeout;
            input.addEventListener('input', () => {
                const term = input.value.trim();
                clearTimeout(searchTimeout);

                if (term.length === 0) {
                    showSection('popular');
                    return;
                }
                if (term.length < 2) return;

                showSection('loading');

                // Debounced search - Laravel entegrasyonu için
                searchTimeout = setTimeout(() => {
                    // fetch('/api/search?q=' + encodeURIComponent(term))
                    //     .then(r => r.json())
                    //     .then(data => showSection(data.length ? 'results' : 'no-results'));
                    showSection('results'); // Demo
                }, 400);
            }, { passive: true });

            // Enter key
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const term = input.value.trim();
                    if (term) window.location.href = '/search?q=' + encodeURIComponent(term);
                }
            });

            // Search button
            searchBtn?.addEventListener('click', () => {
                const term = input.value.trim();
                if (term) {
                    window.location.href = '/search?q=' + encodeURIComponent(term);
                } else {
                    input.focus();
                }
            }, { passive: true });
        });
    }

    // ===== KEYBOARD =====
    function handleKeydown(e) {
        if (e.key === 'Escape') {
            if (menuState.isOpen) closeMenu();
            closeAllLanguage();
            closeAllUser();
            cache.searchWrappers.forEach(w => w.classList.remove('search-active', 'search-focused'));
        }
    }

    // ===== LARAVEL API =====
    window.LeCharmeSearch = {
        updateResults(wrapperId, html) {
            const wrapper = document.querySelector(wrapperId);
            const results = wrapper?.querySelector('.search-results');
            if (results) {
                results.innerHTML = html;
                results.style.display = '';
            }
        },
        showSection(wrapperId, type) {
            const wrapper = document.querySelector(wrapperId);
            const dropdown = wrapper?.querySelector('.search-dropdown');
            if (!dropdown) return;

            ['popular', 'results', 'no-results', 'loading'].forEach(t => {
                const sec = dropdown.querySelector(`.search-${t}`);
                if (sec) sec.style.display = t === type ? '' : 'none';
            });
        },
        toggle(wrapperId, show) {
            document.querySelector(wrapperId)?.classList.toggle('search-active', show);
        }
    };

    // ===== INIT ON DOM READY =====
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
