/**
 * Single Product Interactive Module
 * Swiper gallery slider, synchronized thumbnails, fullscreen lightbox modal,
 * quantity counter, and tabs support.
 *
 * @package Dharmgyan
 */

import Swiper from 'swiper';
import { Navigation, Pagination, EffectFade } from 'swiper/modules';

export function initSingleProduct() {
    // 1. Main Gallery Swiper
    const mainGalleryEl = document.querySelector('.productMainSwiper');
    const thumbButtons = document.querySelectorAll('.gallery-thumb-item');
    let mainSwiper = null;

    if (mainGalleryEl) {
        mainSwiper = new Swiper('.productMainSwiper', {
            modules: [Navigation],
            slidesPerView: 1,
            spaceBetween: 0,
            speed: 400,
            navigation: {
                nextEl: '.main-gallery-viewport .product-main-next',
                prevEl: '.main-gallery-viewport .product-main-prev',
            },
            on: {
                slideChange: function () {
                    const activeIndex = this.activeIndex;
                    thumbButtons.forEach((btn, idx) => {
                        if (idx === activeIndex) {
                            btn.classList.add('active-thumb', 'border-[#CC5600]', 'opacity-100');
                            btn.classList.remove('border-[#EAE3DC]', 'opacity-80');
                            btn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                        } else {
                            btn.classList.remove('active-thumb', 'border-[#CC5600]', 'opacity-100');
                            btn.classList.add('border-[#EAE3DC]', 'opacity-80');
                        }
                    });
                }
            }
        });
    }

    // Thumbnail Clicks -> Switch Main Slide
    if (thumbButtons.length > 0 && mainSwiper) {
        thumbButtons.forEach((btn, index) => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                mainSwiper.slideTo(index);
            });
        });
    }

    // 2. Fullscreen Lightbox Modal & Slider
    const lightboxModal = document.getElementById('product-gallery-lightbox');
    const zoomTrigger = document.getElementById('gallery-zoom-trigger');
    const lightboxCloseBtn = document.getElementById('lightbox-close-btn');
    let lightboxSwiper = null;

    function openLightbox(initialIndex = 0) {
        if (!lightboxModal) return;
        lightboxModal.classList.remove('hidden');
        lightboxModal.classList.add('flex');
        document.body.style.overflow = 'hidden';

        if (!lightboxSwiper) {
            lightboxSwiper = new Swiper('.productLightboxSwiper', {
                modules: [Navigation],
                slidesPerView: 1,
                spaceBetween: 20,
                speed: 400,
                navigation: {
                    nextEl: '.productLightboxSwiper .lightbox-next',
                    prevEl: '.productLightboxSwiper .lightbox-prev',
                },
                initialSlide: initialIndex,
            });
        } else {
            lightboxSwiper.update();
            lightboxSwiper.slideTo(initialIndex, 0);
        }
    }

    function closeLightbox() {
        if (!lightboxModal) return;
        lightboxModal.classList.add('hidden');
        lightboxModal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    if (zoomTrigger) {
        zoomTrigger.addEventListener('click', (e) => {
            e.preventDefault();
            const currentIndex = mainSwiper ? mainSwiper.activeIndex : 0;
            openLightbox(currentIndex);
        });
    }

    // Also clicking on main gallery slide images opens lightbox
    document.querySelectorAll('.gallery-slide-img').forEach((img, idx) => {
        img.addEventListener('click', () => {
            openLightbox(idx);
        });
    });

    if (lightboxCloseBtn) {
        lightboxCloseBtn.addEventListener('click', closeLightbox);
    }

    // Close on backdrop click (click outside image)
    if (lightboxModal) {
        lightboxModal.addEventListener('click', (e) => {
            if (e.target === lightboxModal) {
                closeLightbox();
            }
        });
    }

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && lightboxModal && !lightboxModal.classList.contains('hidden')) {
            closeLightbox();
        }
    });

    // 3. Quantity Counter (+ / -)
    document.addEventListener('click', (e) => {
        const target = e.target;
        if (!target) return;

        if (target.classList.contains('plus') || target.classList.contains('minus')) {
            // Cart page has its own dedicated cart auto-update module
            if (target.closest('.woocommerce-cart-form')) return;

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

    // 4. Fallback Tab Switching if WC Tabs JS is not active
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

    // 5. Buy Now Direct Checkout Button Handler
    document.addEventListener('click', (e) => {
        const buyNowBtn = e.target.closest('.buy_now_button');
        if (!buyNowBtn) return;

        const form = buyNowBtn.closest('form.cart');
        if (!form) return;

        // Variable Product validation: ensure variation is selected
        const variationIdInput = form.querySelector('input.variation_id');
        if (variationIdInput) {
            const varId = parseInt(variationIdInput.value, 10);
            if (!varId || varId <= 0) {
                e.preventDefault();
                let notice = form.querySelector('.variation-select-notice');
                if (!notice) {
                    notice = document.createElement('div');
                    notice.className = 'variation-select-notice text-xs font-semibold text-[#DC2626] bg-[#FEF2F2] border border-[#FECACA] rounded-[4px] p-2.5 my-2 animate-pulse';
                    const variationsTable = form.querySelector('.variations');
                    if (variationsTable) {
                        variationsTable.parentNode.insertBefore(notice, variationsTable.nextSibling);
                    } else {
                        form.prepend(notice);
                    }
                }
                notice.textContent = 'Please select all options (Size, Color, Thickness) before checkout.';
                notice.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                return;
            } else {
                const notice = form.querySelector('.variation-select-notice');
                if (notice) notice.remove();
            }
        }

        // Ensure hidden add-to-cart input exists with valid product ID
        let addInput = form.querySelector('input[type="hidden"][name="add-to-cart"]');
        if (!addInput) {
            addInput = document.createElement('input');
            addInput.type = 'hidden';
            addInput.name = 'add-to-cart';
            addInput.value = buyNowBtn.dataset.productId || form.dataset.productId || form.querySelector('.single_add_to_cart_button')?.value || '';
            form.appendChild(addInput);
        }

        // Ensure hidden dharmgyan_buy_now input exists
        let buyNowInput = form.querySelector('input[type="hidden"][name="dharmgyan_buy_now"]');
        if (!buyNowInput) {
            buyNowInput = document.createElement('input');
            buyNowInput.type = 'hidden';
            buyNowInput.name = 'dharmgyan_buy_now';
            buyNowInput.value = '1';
            form.appendChild(buyNowInput);
        } else {
            buyNowInput.value = '1';
        }

        // Visual loading state
        buyNowBtn.classList.add('opacity-80', 'pointer-events-none');
        buyNowBtn.innerHTML = '<span class="inline-flex items-center gap-2"><svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg> Proceeding...</span>';
    });

    // If Add to Cart button is clicked, remove dharmgyan_buy_now input if present
    document.addEventListener('click', (e) => {
        const addBtn = e.target.closest('.single_add_to_cart_button');
        if (!addBtn) return;

        const form = addBtn.closest('form.cart');
        if (!form) return;

        const buyNowInput = form.querySelector('input[name="dharmgyan_buy_now"]');
        if (buyNowInput) {
            buyNowInput.remove();
        }
    });

    // 6. WooCommerce Variations Dynamic Price & Stock Sync
    if (window.jQuery) {
        const $ = window.jQuery;
        const priceRow = document.getElementById('single-product-price-row');
        const defaultPriceHtml = priceRow ? (priceRow.dataset.defaultHtml || priceRow.innerHTML) : '';
        const urgencyWrap = document.querySelector('.stock-urgency-wrap');
        const urgencyQty = document.querySelector('.stock-qty-num');
        const urgencyBadgeQty = document.querySelector('.stock-badge-qty');
        const urgencyBar = document.querySelector('.stock-urgency-bar');
        const defaultQty = urgencyQty ? urgencyQty.textContent.trim() : '41';
        const defaultBarWidth = urgencyBar ? urgencyBar.style.width : '68%';

        // Auto-select first available option of each attribute on page load if nothing is selected
        setTimeout(() => {
            const form = document.querySelector('form.variations_form');
            if (form) {
                const wrappers = form.querySelectorAll('ul.variable-items-wrapper');
                let needTrigger = false;
                wrappers.forEach(wrapper => {
                    const selected = wrapper.querySelector('li.selected');
                    if (!selected) {
                        const firstAvailable = wrapper.querySelector('li.variable-item:not(.disabled):not(.out-of-stock):not(.wvs-disabled)');
                        if (firstAvailable) {
                            firstAvailable.click();
                            needTrigger = true;
                        }
                    }
                });
                if (needTrigger) {
                    $(form).trigger('check_variations');
                }
            }
        }, 150);

        $(document).on('found_variation', 'form.variations_form', function (event, variation) {
            const form = this;
            const notice = form.querySelector('.variation-select-notice');
            if (notice) notice.remove();

            if (priceRow && variation) {
                const displayPrice = variation.display_price;
                const regularPrice = variation.display_regular_price;
                let discountPct = 0;

                if (regularPrice > 0 && displayPrice > 0 && regularPrice > displayPrice) {
                    discountPct = Math.round(((regularPrice - displayPrice) / regularPrice) * 100);
                }

                const formatINR = (num) => '₹' + Math.round(Number(num)).toLocaleString('en-IN');

                let html = `<span class="single-price text-[#CC5600] font-medium text-2xl md:text-[25px] font-body leading-none">${formatINR(displayPrice)}</span>`;
                if (discountPct > 0 && regularPrice > displayPrice) {
                    html += ` <span class="single-regular-price text-[#717171] font-normal text-sm md:text-[15px] line-through font-body leading-none">${formatINR(regularPrice)}</span>`;
                    html += ` <span class="save-discount-badge bg-[#242424] text-white text-[11px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">SAVE ${discountPct}%</span>`;
                }
                priceRow.innerHTML = html;
            }

            if (variation) {
                if (variation.max_qty && variation.max_qty > 0) {
                    const qty = variation.max_qty;
                    if (urgencyQty) urgencyQty.textContent = qty;
                    if (urgencyBadgeQty) urgencyBadgeQty.textContent = qty;
                    if (urgencyBar) {
                        const pct = Math.min(100, Math.max(15, Math.round((qty / 30) * 100)));
                        urgencyBar.style.width = pct + '%';
                    }
                    if (urgencyWrap) urgencyWrap.style.display = 'block';
                } else if (variation.is_in_stock) {
                    if (urgencyQty) urgencyQty.textContent = defaultQty;
                    if (urgencyBadgeQty) urgencyBadgeQty.textContent = defaultQty;
                    if (urgencyBar) urgencyBar.style.width = defaultBarWidth;
                    if (urgencyWrap) urgencyWrap.style.display = 'block';
                } else {
                    if (urgencyWrap) urgencyWrap.style.display = 'none';
                }
            }
        });

        $(document).on('reset_data', 'form.variations_form', function () {
            if (priceRow && defaultPriceHtml) {
                priceRow.innerHTML = defaultPriceHtml;
            }
            if (urgencyQty) urgencyQty.textContent = defaultQty;
            if (urgencyBadgeQty) urgencyBadgeQty.textContent = defaultQty;
            if (urgencyBar) urgencyBar.style.width = defaultBarWidth;
            if (urgencyWrap) urgencyWrap.style.display = 'block';
        });
    }
}
