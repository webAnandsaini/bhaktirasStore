/**
 * Shop Filter & AJAX Real-Time Query Module
 * Synchronized with Browser URL Query Parameters (history.pushState & popstate).
 *
 * @package Dharmgyan
 */

export function initShopFilter() {
    const productsGrid        = document.getElementById('shop-products-grid');
    const loadingOverlay      = document.getElementById('shop-loading-overlay');
    const paginationWrapper   = document.getElementById('shop-pagination-container');
    const countDisplay        = document.getElementById('shop-products-count');
    const orderbySelect       = document.getElementById('shop-orderby-select');
    const activeChipsContainer= document.getElementById('active-filter-chips');

    // Mobile Drawer Elements
    const drawerToggle        = document.getElementById('mobile-filter-drawer-toggle');
    const drawerClose         = document.getElementById('close-mobile-filter-drawer');
    const drawerBackdrop      = document.getElementById('mobile-filter-backdrop');
    const drawerWrapper       = document.getElementById('mobile-filter-drawer-wrapper');
    const drawerPanel         = document.getElementById('mobile-filter-drawer-panel');

    if (!productsGrid) return; // Exit if not on a shop/archive page

    let currentRequest = null;
    let debounceTimer = null;

    // ─── Mobile Drawer Handling ─────────────────────────────
    function openDrawer() {
        if (!drawerWrapper || !drawerPanel) return;
        drawerWrapper.classList.remove('pointer-events-none', 'opacity-0');
        drawerWrapper.classList.add('pointer-events-auto', 'opacity-100');
        drawerPanel.classList.remove('translate-x-full');
        drawerPanel.classList.add('translate-x-0');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        if (!drawerWrapper || !drawerPanel) return;
        drawerWrapper.classList.remove('pointer-events-auto', 'opacity-100');
        drawerWrapper.classList.add('pointer-events-none', 'opacity-0');
        drawerPanel.classList.remove('translate-x-0');
        drawerPanel.classList.add('translate-x-full');
        document.body.style.overflow = '';
    }

    if (drawerToggle) drawerToggle.addEventListener('click', (e) => {
        e.preventDefault();
        openDrawer();
    });

    if (drawerClose) drawerClose.addEventListener('click', (e) => {
        e.preventDefault();
        closeDrawer();
    });

    if (drawerBackdrop) drawerBackdrop.addEventListener('click', (e) => {
        e.preventDefault();
        closeDrawer();
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeDrawer();
    });

    // ─── Accordions Toggle ──────────────────────────────────
    document.addEventListener('click', (e) => {
        const toggleBtn = e.target.closest('.filter-accordion-toggle');
        if (toggleBtn) {
            e.preventDefault();
            const content = toggleBtn.nextElementSibling;
            const icon = toggleBtn.querySelector('svg');
            if (content) {
                content.classList.toggle('hidden');
                if (icon) {
                    icon.classList.toggle('rotate-180');
                }
            }
        }
    });

    // ─── Price Slider Sync ──────────────────────────────────
    function updateAllSliderFills() {
        document.querySelectorAll('.price-range-slider-input').forEach(slider => {
            const min = parseFloat(slider.min) || 0;
            const max = parseFloat(slider.max) || 25000;
            const val = parseFloat(slider.value) || max;
            const pct = ((val - min) / (max - min)) * 100;
            slider.style.setProperty('--slider-pct', `${pct}%`);
        });
    }
    updateAllSliderFills();

    document.addEventListener('input', (e) => {
        if (e.target.classList.contains('price-range-slider-input')) {
            const val = e.target.value;
            document.querySelectorAll('.filter-max-price-input').forEach(inp => inp.value = val);
            document.querySelectorAll('.price-range-slider-input').forEach(sl => {
                sl.value = val;
            });
            updateAllSliderFills();
            debouncedFilter();
        }

        if (e.target.classList.contains('filter-max-price-input')) {
            const val = e.target.value;
            document.querySelectorAll('.price-range-slider-input').forEach(sl => {
                sl.value = val;
            });
            updateAllSliderFills();
            debouncedFilter();
        }

        if (e.target.classList.contains('filter-min-price-input')) {
            debouncedFilter();
        }
    });

    // ─── Checkbox Changes (with Desktop/Mobile sync) ────────
    document.addEventListener('change', (e) => {
        if (e.target.classList.contains('filter-category-checkbox')) {
            const val = e.target.value;
            const checked = e.target.checked;
            document.querySelectorAll(`.filter-category-checkbox[value="${val}"]`).forEach(cb => {
                cb.checked = checked;
            });
            triggerFilter(1);
        } else if (e.target.classList.contains('filter-type-checkbox')) {
            const val = e.target.value;
            const checked = e.target.checked;
            document.querySelectorAll(`.filter-type-checkbox[value="${val}"]`).forEach(cb => {
                cb.checked = checked;
            });
            triggerFilter(1);
        } else if (e.target.classList.contains('filter-shape-checkbox')) {
            const val = e.target.value;
            const checked = e.target.checked;
            document.querySelectorAll(`.filter-shape-checkbox[value="${val}"]`).forEach(cb => {
                cb.checked = checked;
            });
            triggerFilter(1);
        } else if (e.target.classList.contains('filter-status-in-stock')) {
            const checked = e.target.checked;
            document.querySelectorAll('.filter-status-in-stock').forEach(cb => cb.checked = checked);
            triggerFilter(1);
        } else if (e.target.classList.contains('filter-status-on-sale')) {
            const checked = e.target.checked;
            document.querySelectorAll('.filter-status-on-sale').forEach(cb => cb.checked = checked);
            triggerFilter(1);
        }
    });

    if (orderbySelect) {
        orderbySelect.addEventListener('change', () => {
            triggerFilter(1);
        });
    }

    // ─── Button Actions (Clear All & Apply Filters) ─────────
    document.addEventListener('click', (e) => {
        // Clear All / Reset Button Click
        if (e.target.closest('.btn-clear-all-filters')) {
            e.preventDefault();
            resetAllFilters();
            closeDrawer();
            triggerFilter(1);
        }

        // Apply Filters Button Click (in mobile drawer)
        if (e.target.closest('.btn-apply-filters')) {
            e.preventDefault();
            closeDrawer();
            triggerFilter(1);
        }

        // Pagination Button Click (AJAX)
        const pageBtn = e.target.closest('.shop-ajax-pagination button[data-page], .shop-ajax-pagination .pagination-btn[data-page]');
        if (pageBtn) {
            e.preventDefault();
            const pageNum = parseInt(pageBtn.dataset.page, 10);
            if (pageNum) {
                triggerFilter(pageNum);
                
                // Smooth scroll to top of product grid
                const gridWrapper = document.getElementById('shop-products-grid-wrapper');
                if (gridWrapper) {
                    const yOffset = -120;
                    const y = gridWrapper.getBoundingClientRect().top + window.pageYOffset + yOffset;
                    window.scrollTo({ top: y, behavior: 'smooth' });
                }
            }
        }
    });

    function debouncedFilter() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            triggerFilter(1);
        }, 400);
    }

    function resetAllFilters() {
        document.querySelectorAll('.filter-category-checkbox, .filter-type-checkbox, .filter-shape-checkbox, .filter-status-in-stock, .filter-status-on-sale').forEach(cb => {
            cb.checked = false;
        });

        document.querySelectorAll('.filter-min-price-input').forEach(inp => {
            inp.value = inp.min || '';
        });

        document.querySelectorAll('.filter-max-price-input').forEach(inp => {
            inp.value = inp.max || '';
        });

        document.querySelectorAll('.price-range-slider-input').forEach(slider => {
            slider.value = slider.max || 25000;
        });
        updateAllSliderFills();

        if (orderbySelect) orderbySelect.value = 'menu_order';
    }

    // Gather active filter state
    function getFilterState(pageNum = 1) {
        const categories = Array.from(document.querySelectorAll('.filter-category-checkbox:checked')).map(cb => cb.value);
        const uniqueCategories = [...new Set(categories)];

        const productTypes = Array.from(document.querySelectorAll('.filter-type-checkbox:checked')).map(cb => cb.value);
        const uniqueProductTypes = [...new Set(productTypes)];

        const shapes = Array.from(document.querySelectorAll('.filter-shape-checkbox:checked')).map(cb => cb.value);
        const uniqueShapes = [...new Set(shapes)];

        const minPriceInp = document.querySelector('.filter-min-price-input');
        const maxPriceInp = document.querySelector('.filter-max-price-input');
        const inStockCb   = document.querySelector('.filter-status-in-stock');
        const onSaleCb    = document.querySelector('.filter-status-on-sale');

        return {
            categories: uniqueCategories,
            product_types: uniqueProductTypes,
            shapes: uniqueShapes,
            min_price: minPriceInp ? minPriceInp.value : '',
            max_price: maxPriceInp ? maxPriceInp.value : '',
            in_stock: inStockCb && inStockCb.checked ? '1' : '0',
            on_sale: onSaleCb && onSaleCb.checked ? '1' : '0',
            orderby: orderbySelect ? orderbySelect.value : 'menu_order',
            paged: pageNum,
        };
    }

    // Update URL query parameters
    function updateUrlState(state) {
        const url = new URL(window.location.href);

        if (state.categories.length > 0) {
            url.searchParams.set('product_cat', state.categories.join(','));
        } else {
            url.searchParams.delete('product_cat');
        }

        if (state.product_types.length > 0) {
            url.searchParams.set('product_type', state.product_types.join(','));
        } else {
            url.searchParams.delete('product_type');
        }

        if (state.shapes.length > 0) {
            url.searchParams.set('shape', state.shapes.join(','));
        } else {
            url.searchParams.delete('shape');
        }

        const firstMinInp = document.querySelector('.filter-min-price-input');
        if (state.min_price && (!firstMinInp || state.min_price !== firstMinInp.min)) {
            url.searchParams.set('min_price', state.min_price);
        } else {
            url.searchParams.delete('min_price');
        }

        const firstMaxInp = document.querySelector('.filter-max-price-input');
        if (state.max_price && (!firstMaxInp || state.max_price !== firstMaxInp.max)) {
            url.searchParams.set('max_price', state.max_price);
        } else {
            url.searchParams.delete('max_price');
        }

        if (state.in_stock === '1') {
            url.searchParams.set('in_stock', '1');
        } else {
            url.searchParams.delete('in_stock');
        }

        if (state.on_sale === '1') {
            url.searchParams.set('on_sale', '1');
        } else {
            url.searchParams.delete('on_sale');
        }

        if (state.orderby && state.orderby !== 'menu_order') {
            url.searchParams.set('orderby', state.orderby);
        } else {
            url.searchParams.delete('orderby');
        }

        if (state.paged > 1) {
            url.searchParams.set('paged', state.paged);
        } else {
            url.searchParams.delete('paged');
        }

        window.history.pushState({ filterState: state }, '', url.toString());
        renderActiveChips(state);
    }

    // Render Active Filter Chips
    function renderActiveChips(state) {
        if (!activeChipsContainer) return;
        activeChipsContainer.innerHTML = '';

        const chips = [];

        state.categories.forEach(catSlug => {
            const cb = document.querySelector(`.filter-category-checkbox[value="${catSlug}"]`);
            const label = cb?.closest('label')?.querySelector('span')?.textContent?.trim() || catSlug;
            chips.push({ type: 'category', value: catSlug, label: label });
        });

        state.shapes.forEach(shapeSlug => {
            const cb = document.querySelector(`.filter-shape-checkbox[value="${shapeSlug}"]`);
            const label = cb?.closest('label')?.querySelector('span')?.textContent?.trim() || shapeSlug;
            chips.push({ type: 'shape', value: shapeSlug, label: label });
        });

        const firstMinInp = document.querySelector('.filter-min-price-input');
        const firstMaxInp = document.querySelector('.filter-max-price-input');
        const minBound = firstMinInp?.min || 0;
        const maxBound = firstMaxInp?.max || 25000;

        if ((state.min_price && parseFloat(state.min_price) > minBound) || (state.max_price && parseFloat(state.max_price) < maxBound)) {
            chips.push({ type: 'price', label: `₹${state.min_price || minBound} - ₹${state.max_price || maxBound}` });
        }

        if (state.in_stock === '1') {
            chips.push({ type: 'in_stock', label: 'In Stock' });
        }

        if (state.on_sale === '1') {
            chips.push({ type: 'on_sale', label: 'On Sale' });
        }

        if (chips.length === 0) {
            activeChipsContainer.classList.add('hidden');
            const mobileCountBadge = document.getElementById('mobile-filter-count');
            if (mobileCountBadge) {
                mobileCountBadge.classList.add('hidden');
                mobileCountBadge.classList.remove('inline-flex');
            }
            return;
        }

        activeChipsContainer.classList.remove('hidden');

        chips.forEach(chip => {
            const badge = document.createElement('span');
            badge.className = 'inline-flex items-center gap-1.5 px-3 py-1 bg-[#FFF8F3] border border-[#EAE3DC] text-[#CC5600] text-xs rounded-full shadow-2xs';
            badge.innerHTML = `<span>${chip.label}</span><button type="button" class="remove-chip-btn text-[#CC5600] hover:text-black font-bold focus:outline-none cursor-pointer" data-type="${chip.type}" data-value="${chip.value || ''}">&times;</button>`;
            activeChipsContainer.appendChild(badge);
        });

        const clearBtn = document.createElement('button');
        clearBtn.type = 'button';
        clearBtn.className = 'btn-clear-all-filters text-xs text-[#717171] hover:text-[#CC5600] underline ml-2 cursor-pointer';
        clearBtn.textContent = 'Clear All';
        activeChipsContainer.appendChild(clearBtn);

        const mobileCountBadge = document.getElementById('mobile-filter-count');
        if (mobileCountBadge) {
            if (chips.length > 0) {
                mobileCountBadge.textContent = chips.length;
                mobileCountBadge.classList.remove('hidden');
                mobileCountBadge.classList.add('inline-flex');
            } else {
                mobileCountBadge.classList.add('hidden');
                mobileCountBadge.classList.remove('inline-flex');
            }
        }
    }

    // Remove single chip click
    if (activeChipsContainer) {
        activeChipsContainer.addEventListener('click', (e) => {
            const btn = e.target.closest('.remove-chip-btn');
            if (btn) {
                const type  = btn.dataset.type;
                const value = btn.dataset.value;

                if (type === 'category') {
                    document.querySelectorAll(`.filter-category-checkbox[value="${value}"]`).forEach(cb => cb.checked = false);
                } else if (type === 'shape') {
                    document.querySelectorAll(`.filter-shape-checkbox[value="${value}"]`).forEach(cb => cb.checked = false);
                } else if (type === 'price') {
                    document.querySelectorAll('.filter-min-price-input').forEach(inp => inp.value = inp.min || '');
                    document.querySelectorAll('.filter-max-price-input').forEach(inp => inp.value = inp.max || '');
                    document.querySelectorAll('.price-range-slider-input').forEach(slider => {
                        slider.value = slider.max || 25000;
                    });
                    updateAllSliderFills();
                } else if (type === 'in_stock') {
                    document.querySelectorAll('.filter-status-in-stock').forEach(cb => cb.checked = false);
                } else if (type === 'on_sale') {
                    document.querySelectorAll('.filter-status-on-sale').forEach(cb => cb.checked = false);
                }
                triggerFilter(1);
            }
        });
    }

    // Trigger AJAX Filter Request
    function triggerFilter(pageNum = 1) {
        const state = getFilterState(pageNum);
        updateUrlState(state);

        if (loadingOverlay) loadingOverlay.classList.remove('hidden');

        if (currentRequest) {
            currentRequest.abort();
        }

        const formData = new FormData();
        formData.append('action', 'dharmgyan_filter_products');
        formData.append('nonce', window.dharmgyan_vars?.shop_nonce || '');
        formData.append('min_price', state.min_price);
        formData.append('max_price', state.max_price);
        formData.append('in_stock', state.in_stock);
        formData.append('on_sale', state.on_sale);
        formData.append('orderby', state.orderby);
        formData.append('paged', state.paged);

        state.categories.forEach(cat => {
            formData.append('categories[]', cat);
        });

        state.shapes.forEach(shape => {
            formData.append('shapes[]', shape);
        });

        const controller = new AbortController();
        currentRequest = controller;

        fetch(window.dharmgyan_vars?.ajax_url || '/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: formData,
            signal: controller.signal
        })
        .then(res => res.json())
        .then(data => {
            if (loadingOverlay) loadingOverlay.classList.add('hidden');
            if (data.success) {
                if (productsGrid) productsGrid.innerHTML = data.data.html;
                if (paginationWrapper) paginationWrapper.innerHTML = data.data.pagination_html;
                if (countDisplay) countDisplay.textContent = data.data.count_text;
            }
        })
        .catch(err => {
            if (err.name !== 'AbortError') {
                if (loadingOverlay) loadingOverlay.classList.add('hidden');
                console.error('Filter error:', err);
            }
        });
    }

    // Initial Load: Parse URL params & Pre-select Checkboxes
    function initFromUrl() {
        const params = new URLSearchParams(window.location.search);
        let hasCustomParams = false;

        const catParam = params.get('product_cat') || params.get('category');
        if (catParam) {
            const catSlugs = catParam.split(',');
            catSlugs.forEach(slug => {
                document.querySelectorAll(`.filter-category-checkbox[value="${slug.trim()}"]`).forEach(cb => {
                    cb.checked = true;
                });
                hasCustomParams = true;
            });
        }

        const shapeParam = params.get('shape');
        if (shapeParam) {
            const shapeSlugs = shapeParam.split(',');
            shapeSlugs.forEach(slug => {
                document.querySelectorAll(`.filter-shape-checkbox[value="${slug.trim()}"]`).forEach(cb => {
                    cb.checked = true;
                });
                hasCustomParams = true;
            });
        }

        if (params.get('min_price')) {
            document.querySelectorAll('.filter-min-price-input').forEach(inp => {
                inp.value = params.get('min_price');
            });
            hasCustomParams = true;
        }

        if (params.get('max_price')) {
            document.querySelectorAll('.filter-max-price-input').forEach(inp => {
                inp.value = params.get('max_price');
            });
            document.querySelectorAll('.price-range-slider-input').forEach(sl => {
                sl.value = params.get('max_price');
            });
            updateAllSliderFills();
            hasCustomParams = true;
        }

        if (params.get('in_stock') === '1') {
            document.querySelectorAll('.filter-status-in-stock').forEach(cb => cb.checked = true);
            hasCustomParams = true;
        }

        if (params.get('on_sale') === '1') {
            document.querySelectorAll('.filter-status-on-sale').forEach(cb => cb.checked = true);
            hasCustomParams = true;
        }

        if (params.get('orderby') && orderbySelect) {
            orderbySelect.value = params.get('orderby');
            hasCustomParams = true;
        }

        const state = getFilterState(parseInt(params.get('paged') || 1, 10));
        renderActiveChips(state);

        if (hasCustomParams) {
            triggerFilter(state.paged);
        }
    }

    // Browser Back / Forward History Handler
    window.addEventListener('popstate', () => {
        initFromUrl();
    });

    initFromUrl();
}

export const initShopFilters = initShopFilter;
