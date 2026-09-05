/**
 * Cart Page Live Quantity & Auto-Update Module
 * Handles +/- quantity stepper buttons, debounced cart updates, and UI synchronization.
 *
 * @package Dharmgyan
 */

let cartUpdateTimeout = null;
let safetyTimeout = null;

export function initCart() {
    const cartWrapper = document.querySelector('.cart-page-wrapper');
    if (!cartWrapper) return;

    // 1. Delegate Click for Quantity Stepper (+ / -) in Cart Form
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.plus, .minus');
        if (!btn) return;

        const cartForm = btn.closest('.woocommerce-cart-form');
        if (!cartForm) return;

        e.preventDefault();

        const qtyContainer = btn.closest('.quantity') || btn.closest('.cart-quantity-stepper') || btn.closest('div');
        if (!qtyContainer) return;

        const qtyInput = qtyContainer.querySelector('input.qty');
        if (!qtyInput) return;

        let currentVal = parseFloat(qtyInput.value) || 1;
        const maxVal = parseFloat(qtyInput.getAttribute('max')) || 9999;
        const minVal = parseFloat(qtyInput.getAttribute('min')) || 1;
        const step = parseFloat(qtyInput.getAttribute('step')) || 1;

        if (btn.classList.contains('plus')) {
            if (currentVal + step <= maxVal) {
                qtyInput.value = currentVal + step;
            }
        } else if (btn.classList.contains('minus')) {
            if (currentVal - step >= minVal) {
                qtyInput.value = currentVal - step;
            }
        }

        // Trigger change & input events so WooCommerce cart.js and our auto-updater detect the change
        dispatchQuantityEvents(qtyInput);
    });

    // 2. Listen for change and input events on quantity fields
    document.addEventListener('change', handleQuantityChange);
    document.addEventListener('input', handleQuantityChange);

    function handleQuantityChange(e) {
        if (!e.target || !e.target.matches('.woocommerce-cart-form input.qty')) return;
        queueCartUpdate();
    }

    function dispatchQuantityEvents(input) {
        input.dispatchEvent(new Event('change', { bubbles: true }));
        input.dispatchEvent(new Event('input', { bubbles: true }));

        if (window.jQuery) {
            window.jQuery(input).trigger('change').trigger('input');
        }
    }

    // 3. Debounced Auto-Update Cart via WooCommerce AJAX
    function queueCartUpdate() {
        clearTimeout(cartUpdateTimeout);
        clearTimeout(safetyTimeout);

        // Visual feedback: show subtle loading opacity on cart form and totals
        const formEl = document.querySelector('.woocommerce-cart-form');
        const totalsEl = document.querySelector('.cart_totals');

        if (formEl) formEl.classList.add('opacity-50', 'pointer-events-none', 'transition-opacity', 'duration-200');
        if (totalsEl) totalsEl.classList.add('opacity-50', 'pointer-events-none', 'transition-opacity', 'duration-200');

        // Safety fallback: reset opacity after 6s in case of connection drop
        safetyTimeout = setTimeout(() => {
            resetLoadingState();
        }, 6000);

        cartUpdateTimeout = setTimeout(() => {
            const updateBtn = document.querySelector('.woocommerce-cart-form button[name="update_cart"]');
            if (updateBtn) {
                updateBtn.disabled = false;
                updateBtn.setAttribute('clicked', 'true');
                if (window.jQuery) {
                    window.jQuery(updateBtn).removeAttr('disabled').attr('clicked', 'true').trigger('click');
                } else {
                    updateBtn.click();
                }
            } else if (formEl) {
                formEl.submit();
            }
        }, 400);
    }

    function resetLoadingState() {
        const formEl = document.querySelector('.woocommerce-cart-form');
        const totalsEl = document.querySelector('.cart_totals');
        if (formEl) formEl.classList.remove('opacity-50', 'pointer-events-none');
        if (totalsEl) totalsEl.classList.remove('opacity-50', 'pointer-events-none');
    }

    // 4. Handle Post-Update Cleanup and Header Counters Sync
    if (window.jQuery) {
        window.jQuery(document.body).on('updated_wc_div updated_cart_totals', () => {
            clearTimeout(cartUpdateTimeout);
            clearTimeout(safetyTimeout);

            resetLoadingState();
            syncCartCounters();
        });
    }

    function syncCartCounters() {
        let totalCount = 0;
        document.querySelectorAll('.woocommerce-cart-form input.qty').forEach((input) => {
            totalCount += parseInt(input.value, 10) || 0;
        });

        // Update page heading count (e.g. "(16 items)")
        const pageCountEl = document.querySelector('.cart-header-count');
        if (pageCountEl) {
            pageCountEl.textContent = `(${totalCount} items)`;
        }

        // Update header mini-cart badge
        const badge = document.querySelector('.mini-cart-count');
        if (badge) {
            if (totalCount > 0) {
                badge.textContent = totalCount;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }

        // Trigger WooCommerce fragment refresh for mini cart flyout
        if (window.jQuery) {
            window.jQuery(document.body).trigger('wc_fragment_refresh');
        }
    }
}
