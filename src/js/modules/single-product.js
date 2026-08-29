/**
 * Single Product Interactive Module
 * Gallery thumbnails, quantity counter, and tabs support.
 *
 * @package Dharmgyan
 */

export function initSingleProduct() {
    // 1. Gallery Thumbnail Switcher
    const mainImage = document.getElementById('gallery-main-image');
    const zoomTrigger = document.getElementById('gallery-zoom-trigger');
    const thumbButtons = document.querySelectorAll('.gallery-thumb-item');

    if (mainImage && thumbButtons.length > 0) {
        thumbButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const largeSrc = btn.dataset.largeSrc;
                const fullSrc = btn.dataset.fullSrc;

                if (largeSrc) {
                    mainImage.style.opacity = '0.3';
                    setTimeout(() => {
                        mainImage.src = largeSrc;
                        if (zoomTrigger && fullSrc) {
                            zoomTrigger.href = fullSrc;
                        }
                        mainImage.style.opacity = '1';
                    }, 120);
                }

                // Update active state
                thumbButtons.forEach(b => {
                    b.classList.remove('active-thumb', 'border-[#111111]');
                    b.classList.add('border-[#E5E5E5]', 'opacity-75');
                });
                btn.classList.add('active-thumb', 'border-[#111111]');
                btn.classList.remove('border-[#E5E5E5]', 'opacity-75');
            });
        });
    }

    // 2. Quantity Counter (+ / -)
    document.addEventListener('click', (e) => {
        const target = e.target;
        if (!target) return;

        if (target.classList.contains('plus') || target.classList.contains('minus')) {
            e.preventDefault();
            const qtyContainer = target.closest('.quantity');
            if (!qtyContainer) return;

            const qtyInput = qtyContainer.querySelector('input.qty');
            if (!qtyInput) return;

            let currentVal = parseFloat(qtyInput.value) || 1;
            const maxVal = parseFloat(qtyInput.max) || 9999;
            const minVal = parseFloat(qtyInput.min) || 1;
            const step = parseFloat(qtyInput.step) || 1;

            if (target.classList.contains('plus')) {
                if (currentVal + step <= maxVal) {
                    qtyInput.value = currentVal + step;
                }
            } else if (target.classList.contains('minus')) {
                if (currentVal - step >= minVal) {
                    qtyInput.value = currentVal - step;
                }
            }

            // Dispatch change event
            const event = new Event('change', { bubbles: true });
            qtyInput.dispatchEvent(event);
        }
    });

    // 3. Fallback Tab Switching if WC Tabs JS is not active
    const tabLinks = document.querySelectorAll('.single-product-tabs-section ul.tabs li a');
    if (tabLinks.length > 0) {
        tabLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = link.getAttribute('href');
                if (!targetId || !targetId.startsWith('#')) return;

                // Deactivate all tabs
                tabLinks.forEach(l => l.parentElement.classList.remove('active'));
                document.querySelectorAll('.woocommerce-Tabs-panel').forEach(p => p.style.display = 'none');

                // Activate selected tab
                link.parentElement.classList.add('active');
                const targetPanel = document.querySelector(targetId);
                if (targetPanel) {
                    targetPanel.style.display = 'block';
                }
            });
        });
    }
}
