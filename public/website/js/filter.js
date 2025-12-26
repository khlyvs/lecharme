/**
 * Filter Page - Optimized & Simplified
 * Real-time filtering (desktop) | Manual filtering (mobile)
 */
(function () {
    'use strict';

    // ═══════════════════════════════════════════════════════════════
    // CONFIG
    // ═══════════════════════════════════════════════════════════════
    const CONFIG = {
        debounceDelay: 400,
        showLoadingDelay: 150,
        minLoadingTime: 300,
        retryAttempts: 2,
        retryDelay: 1000,
    };

    // ═══════════════════════════════════════════════════════════════
    // STATE
    // ═══════════════════════════════════════════════════════════════
    const state = {
        isLoading: false,
        abortController: null,
        timers: {},
        lastFilters: null,
        isMobile: window.innerWidth < 768,
    };

    // ═══════════════════════════════════════════════════════════════
    // DOM
    // ═══════════════════════════════════════════════════════════════
    const page = document.getElementById('filter__page');
    if (!page) return;

    const el = {
        page,
        sidebar: document.getElementById('filter__sidebar'),
        overlay: document.getElementById('filter__overlay'),
        mobileToggle: document.getElementById('filter__mobile-toggle'),
        closeBtn: document.getElementById('filter__close'),
        applyBtn: document.getElementById('filter__apply'),
        clearBtn: document.getElementById('filter__clear'),
        sortSelect: document.getElementById('filter__sort-select'),
        productsGrid: document.getElementById('filter__products-grid'),
        resultsCount: document.getElementById('filter__results-count'),
        pagination: document.getElementById('filter__pagination'),
        priceMin: document.getElementById('filter__price-min'),
        priceMax: document.getElementById('filter__price-max'),
    };

    const baseUrl = page.dataset.filterUrl;

    // ═══════════════════════════════════════════════════════════════
    // UTILS
    // ═══════════════════════════════════════════════════════════════
    const debounce = (fn, wait) => {
        return (...args) => {
            clearTimeout(state.timers.debounce);
            state.timers.debounce = setTimeout(() => fn(...args), wait);
        };
    };

    const sleep = (ms) => new Promise(resolve => setTimeout(resolve, ms));

    const announce = (() => {
        let announcer = document.getElementById('filter__announcer');
        if (!announcer) {
            announcer = Object.assign(document.createElement('div'), {
                id: 'filter__announcer',
                className: 'sr-only',
                setAttribute: (k, v) => announcer[k === 'aria-live' ? 'ariaLive' : k] = v,
            });
            announcer.setAttribute('aria-live', 'polite');
            announcer.setAttribute('aria-atomic', 'true');
            announcer.style.cssText = 'position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;';
            document.body.appendChild(announcer);
        }
        return (msg) => { announcer.textContent = msg; };
    })();

    // ═══════════════════════════════════════════════════════════════
    // FILTERS
    // ═══════════════════════════════════════════════════════════════
    const collectFilters = () => {
        const filters = {};
        const minPrice = parseFloat(el.priceMin?.value?.trim());
        const maxPrice = parseFloat(el.priceMax?.value?.trim());

        if (!isNaN(minPrice) && minPrice >= 0) filters.min_price = minPrice;
        if (!isNaN(maxPrice) && maxPrice >= 0) filters.max_price = maxPrice;

        const subcats = Array.from(document.querySelectorAll('input[name="subcategories[]"]:checked'))
            .map(cb => cb.value);
        if (subcats.length) filters.subcategories = subcats;

        if (document.querySelector('.filter__badge[data-badge="discount"].active')) {
            filters.has_discount = 1;
        }

        const sort = el.sortSelect?.value;
        if (sort && sort !== 'default') filters.sort = sort;

        return filters;
    };

    const hasFiltersChanged = (newFilters) => {
        return !state.lastFilters || JSON.stringify(newFilters) !== JSON.stringify(state.lastFilters);
    };

    // ═══════════════════════════════════════════════════════════════
    // URL
    // ═══════════════════════════════════════════════════════════════
    const buildUrl = (filters, includePage = false) => {
        const url = new URL(baseUrl);
        Object.entries(filters).forEach(([key, value]) => {
            if (key === 'page' && !includePage) return;
            if (Array.isArray(value)) {
                value.forEach(v => url.searchParams.append(`${key}[]`, v));
            } else if (value != null && value !== '') {
                url.searchParams.set(key, value);
            }
        });
        return url.toString();
    };

    const updateUrl = (filters, replace = false) => {
        const url = buildUrl(filters);
        window.history[replace ? 'replaceState' : 'pushState']({ filters }, '', url);
    };

    const parseUrlFilters = () => {
        const params = new URLSearchParams(window.location.search);
        const filters = {};
        if (params.has('min_price')) filters.min_price = parseFloat(params.get('min_price'));
        if (params.has('max_price')) filters.max_price = parseFloat(params.get('max_price'));
        if (params.has('sort')) filters.sort = params.get('sort');
        if (params.has('has_discount')) filters.has_discount = 1;
        if (params.has('page')) filters.page = parseInt(params.get('page'));
        const subcats = params.getAll('subcategories[]');
        if (subcats.length) filters.subcategories = subcats;
        return filters;
    };

    const applyFiltersToForm = (filters) => {
        if (el.priceMin) el.priceMin.value = filters.min_price ?? '';
        if (el.priceMax) el.priceMax.value = filters.max_price ?? '';
        if (el.sortSelect) el.sortSelect.value = filters.sort ?? 'default';
        document.querySelectorAll('input[name="subcategories[]"]').forEach(cb => {
            cb.checked = (filters.subcategories || []).includes(cb.value);
        });
        const badge = document.querySelector('.filter__badge[data-badge="discount"]');
        if (badge) {
            badge.classList.toggle('active', !!filters.has_discount);
            badge.setAttribute('aria-pressed', filters.has_discount ? 'true' : 'false');
        }
    };

    // ═══════════════════════════════════════════════════════════════
    // LOADING
    // ═══════════════════════════════════════════════════════════════
    const showLoading = () => {
        state.isLoading = true;
        el.productsGrid.classList.add('filter__loading');
        el.page.classList.add('filter--loading');
        if (!document.getElementById('filter__skeleton-overlay')) {
            const overlay = Object.assign(document.createElement('div'), {
                id: 'filter__skeleton-overlay',
                className: 'filter__skeleton-overlay',
                innerHTML: '<div class="filter__spinner"></div>',
            });
            el.productsGrid.appendChild(overlay);
        }
    };

    const hideLoading = () => {
        state.isLoading = false;
        el.productsGrid.classList.remove('filter__loading');
        el.page.classList.remove('filter--loading');
        document.getElementById('filter__skeleton-overlay')?.remove();
    };

    const showLoadingDelayed = () => {
        clearTimeout(state.timers.loading);
        state.timers.loading = setTimeout(() => {
            if (state.isLoading) showLoading();
        }, CONFIG.showLoadingDelay);
    };

    // ═══════════════════════════════════════════════════════════════
    // AJAX
    // ═══════════════════════════════════════════════════════════════
    const cancelRequest = () => {
        state.abortController?.abort();
        state.abortController = null;
        clearTimeout(state.timers.loading);
    };

    const fetchProducts = async (url, attempt = 1) => {
        state.abortController = new AbortController();
        try {
            const response = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                signal: state.abortController.signal,
            });
            const data = await response.json();
            if (!response.ok) {
                const error = new Error(data.message || `HTTP ${response.status}`);
                error.status = response.status;
                error.errors = data.errors || {};
                throw error;
            }
            return data;
        } catch (error) {
            if (error.name === 'AbortError' || error.status === 422) throw error;
            if (attempt < CONFIG.retryAttempts) {
                await sleep(CONFIG.retryDelay);
                return fetchProducts(url, attempt + 1);
            }
            throw error;
        }
    };

    const loadProducts = async (filters = {}, options = {}) => {
        const { updateHistory = true, replaceHistory = false, isUserAction = true } = options;

        if (isUserAction && !hasFiltersChanged(filters)) return;

        cancelRequest();
        state.isLoading = true;
        state.lastFilters = { ...filters };
        showLoadingDelayed();

        const startTime = Date.now();
        try {
            const data = await fetchProducts(buildUrl(filters, true));
            const elapsed = Date.now() - startTime;
            if (elapsed < CONFIG.minLoadingTime) await sleep(CONFIG.minLoadingTime - elapsed);

            el.productsGrid.innerHTML = data.html;
            if (el.resultsCount) {
                const countText = `${data.count} məhsul tapıldı`;
                el.resultsCount.textContent = countText;
                announce(countText);
            }
            if (el.pagination) el.pagination.innerHTML = data.pagination || '';
            if (updateHistory) updateUrl(filters, replaceHistory);
            if (state.isMobile && isUserAction) closeMobileSidebar();
        } catch (error) {
            if (error.name !== 'AbortError') {
                console.error('Filter error:', error);
                const message = error.status === 422 && error.errors
                    ? `Validation xətası: ${Object.values(error.errors).flat().join(', ')}`
                    : 'Xəta baş verdi, yenidən cəhd edin';
                announce(message);
                showErrorState(message);
            }
        } finally {
            hideLoading();
        }
    };

    const showErrorState = (message = 'Xəta baş verdi') => {
        el.productsGrid.innerHTML = `
            <div class="filter__error">
                <i class="bi bi-exclamation-triangle"></i>
                <p>${message}</p>
                <button type="button" class="filter__retry-btn" onclick="window.location.reload()">
                    Yenidən cəhd et
                </button>
            </div>
        `;
    };

    // ═══════════════════════════════════════════════════════════════
    // TRIGGERS
    // ═══════════════════════════════════════════════════════════════
    const triggerFilterDebounced = debounce(() => {
        if (!state.isMobile) loadProducts(collectFilters());
    }, CONFIG.debounceDelay);

    const triggerFilterInstant = () => {
        if (!state.isMobile) loadProducts(collectFilters());
    };

    const clearFilters = () => {
        if (el.priceMin) el.priceMin.value = '';
        if (el.priceMax) el.priceMax.value = '';
        if (el.sortSelect) el.sortSelect.value = 'default';
        document.querySelectorAll('input[name="subcategories[]"]').forEach(cb => cb.checked = false);
        document.querySelectorAll('.filter__badge.active').forEach(badge => {
            badge.classList.remove('active');
            badge.setAttribute('aria-pressed', 'false');
        });
        loadProducts({});
    };

    // ═══════════════════════════════════════════════════════════════
    // MOBILE
    // ═══════════════════════════════════════════════════════════════
    const openMobileSidebar = () => {
        el.sidebar?.classList.add('active');
        el.overlay?.classList.add('active');
        document.body.style.overflow = 'hidden';
        el.mobileToggle?.setAttribute('aria-expanded', 'true');
        el.sidebar?.querySelector('button, input, select')?.focus();
    };

    const closeMobileSidebar = () => {
        el.sidebar?.classList.remove('active');
        el.overlay?.classList.remove('active');
        document.body.style.overflow = '';
        el.mobileToggle?.setAttribute('aria-expanded', 'false');
        el.mobileToggle?.focus();
    };

    // ═══════════════════════════════════════════════════════════════
    // EVENTS
    // ═══════════════════════════════════════════════════════════════
    const initEvents = () => {
        el.priceMin?.addEventListener('input', triggerFilterDebounced);
        el.priceMax?.addEventListener('input', triggerFilterDebounced);
        el.sortSelect?.addEventListener('change', triggerFilterInstant);
        document.querySelectorAll('input[name="subcategories[]"]').forEach(cb => {
            cb.addEventListener('change', triggerFilterInstant);
        });
        document.querySelectorAll('.filter__badge').forEach(badge => {
            badge.addEventListener('click', () => {
                const isActive = badge.classList.toggle('active');
                badge.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                triggerFilterInstant();
            });
        });
        el.applyBtn?.addEventListener('click', () => {
            loadProducts(collectFilters());
            if (state.isMobile) closeMobileSidebar();
        });
        el.clearBtn?.addEventListener('click', clearFilters);
        el.mobileToggle?.addEventListener('click', openMobileSidebar);
        el.closeBtn?.addEventListener('click', closeMobileSidebar);
        el.overlay?.addEventListener('click', closeMobileSidebar);
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && el.sidebar?.classList.contains('active')) {
                closeMobileSidebar();
            }
        });
        document.addEventListener('click', (e) => {
            const link = e.target.closest('.filter__pagination a');
            if (link) {
                e.preventDefault();
                const filters = collectFilters();
                filters.page = new URL(link.href).searchParams.get('page');
                loadProducts(filters);
                el.productsGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
        window.addEventListener('popstate', (e) => {
            const filters = e.state?.filters || parseUrlFilters();
            applyFiltersToForm(filters);
            loadProducts(filters, { updateHistory: false, isUserAction: false });
        });
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                state.isMobile = window.innerWidth < 768;
            }, 250);
        });
    };

    // ═══════════════════════════════════════════════════════════════
    // INIT
    // ═══════════════════════════════════════════════════════════════
    const init = () => {
        const initialFilters = parseUrlFilters();
        state.lastFilters = initialFilters;
        applyFiltersToForm(initialFilters);
        initEvents();
        updateUrl(initialFilters, true);
    };

    init();

})();
