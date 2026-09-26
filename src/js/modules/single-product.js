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

    // 4. Responsive Product Tabs & Mobile Accordion Handler
    const tabLinks = document.querySelectorAll('.single-product-tabs-section ul.tabs li a');
    const accordionToggles = document.querySelectorAll('.mobile-accordion-toggle');

    // On Desktop: Activate first tab by default if none active
    if (tabLinks.length > 0 && window.innerWidth >= 768) {
        const activeLink = document.querySelector('.single-product-tabs-section ul.tabs li.active a') || tabLinks[0];
        if (activeLink) {
            activeLink.parentElement.classList.add('active');
            const targetId = activeLink.getAttribute('href');
            document.querySelectorAll('.woocommerce-Tabs-panel').forEach(p => p.style.display = 'none');
            const panel = targetId ? document.querySelector(targetId) : null;
            if (panel) panel.style.display = 'block';
        }
    }

    // Desktop Tab Switching
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

    // Mobile Accordion Toggle (All closed by default)
    if (accordionToggles.length > 0) {
        accordionToggles.forEach(toggle => {
            toggle.addEventListener('click', (e) => {
                e.preventDefault();
                const parentItem = toggle.closest('.product-tab-accordion-item');
                const targetSelector = toggle.getAttribute('data-target');
                const panel = parentItem ? parentItem.querySelector(targetSelector) : null;

                if (!parentItem || !panel) return;

                const isOpen = parentItem.classList.contains('is-open');

                // Close other accordion items on mobile to keep page neat
                accordionToggles.forEach(otherToggle => {
                    const otherParent = otherToggle.closest('.product-tab-accordion-item');
                    if (otherParent && otherParent !== parentItem) {
                        otherParent.classList.remove('is-open');
                        otherToggle.setAttribute('aria-expanded', 'false');
                        const otherPanel = otherParent.querySelector(otherToggle.getAttribute('data-target'));
                        if (otherPanel && window.innerWidth < 768) {
                            otherPanel.style.display = 'none';
                        }
                    }
                });

                if (isOpen) {
                    parentItem.classList.remove('is-open');
                    toggle.setAttribute('aria-expanded', 'false');
                    panel.style.display = 'none';
                } else {
                    parentItem.classList.add('is-open');
                    toggle.setAttribute('aria-expanded', 'true');
                    panel.style.display = 'block';
                }
            });
        });

        // Window resize sync between desktop tabs and mobile accordion
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                const activeLink = document.querySelector('.single-product-tabs-section ul.tabs li.active a') || tabLinks[0];
                if (activeLink) {
                    activeLink.parentElement.classList.add('active');
                    const targetId = activeLink.getAttribute('href');
                    document.querySelectorAll('.woocommerce-Tabs-panel').forEach(p => p.style.display = 'none');
                    const panel = targetId ? document.querySelector(targetId) : null;
                    if (panel) panel.style.display = 'block';
                }
            } else {
                document.querySelectorAll('.product-tab-accordion-item').forEach(item => {
                    const panel = item.querySelector('.woocommerce-Tabs-panel');
                    if (panel) {
                        panel.style.display = item.classList.contains('is-open') ? 'block' : 'none';
                    }
                });
            }
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

        // ─── Color Swatch Circle Dot Enhancer ───
        const colorGradients = {
            'red': 'radial-gradient(circle at 35% 35%, #FF5555, #DC2626 60%, #991B1B 100%)',
            'green': 'radial-gradient(circle at 35% 35%, #4ADE80, #16A34A 60%, #14532D 100%)',
            'gray': 'radial-gradient(circle at 35% 35%, #9CA3AF, #4B5563 60%, #1F2937 100%)',
            'grey': 'radial-gradient(circle at 35% 35%, #9CA3AF, #4B5563 60%, #1F2937 100%)',
            'yellow': 'radial-gradient(circle at 35% 35%, #FDE047, #EAB308 60%, #854D0E 100%)',
            'blue': 'radial-gradient(circle at 35% 35%, #60A5FA, #2563EB 60%, #1E3A8A 100%)',
            'pink': 'radial-gradient(circle at 35% 35%, #F472B6, #EC4899 60%, #831843 100%)',
            'black': 'radial-gradient(circle at 35% 35%, #4B5563, #111827 60%, #000000 100%)',
            'white': 'radial-gradient(circle at 35% 35%, #FFFFFF 0%, #F1F5F9 70%, #CBD5E1 100%)',
            'orange': 'radial-gradient(circle at 35% 35%, #FB923C, #EA580C 60%, #7C2D12 100%)',
            'purple': 'radial-gradient(circle at 35% 35%, #C084FC, #9333EA 60%, #581C87 100%)',
            'violet': 'radial-gradient(circle at 35% 35%, #C084FC, #7C3AED 60%, #4C1D95 100%)',
            'brown': 'radial-gradient(circle at 35% 35%, #A16207, #78350F 60%, #451A03 100%)',
            'gold': 'linear-gradient(135deg, #FFE259 0%, #FFA751 100%)',
            'golden': 'linear-gradient(135deg, #FFE259 0%, #FFA751 100%)',
            'silver': 'linear-gradient(135deg, #E0E0E0 0%, #F5F5F5 50%, #9E9E9E 100%)',
            'bronze': 'radial-gradient(circle at 35% 35%, #F97316, #C2410C 60%, #7C2D12 100%)',
            'copper': 'radial-gradient(circle at 35% 35%, #F97316, #C2410C 60%, #7C2D12 100%)',
            'beige': 'radial-gradient(circle at 35% 35%, #FEF3C7, #FDE68A 60%, #D97706 100%)',
            'clear': 'radial-gradient(circle at 35% 35%, #FFFFFF 0%, #E2E8F0 60%, #94A3B8 100%)',
            'transparent': 'radial-gradient(circle at 35% 35%, #FFFFFF 0%, #E2E8F0 60%, #94A3B8 100%)',
            'maroon': 'radial-gradient(circle at 35% 35%, #991B1B, #7F1D1D 60%, #450A0A 100%)',
            'navy': 'radial-gradient(circle at 35% 35%, #1E3A8A, #1E1B4B 60%, #0F172A 100%)',
            'teal': 'radial-gradient(circle at 35% 35%, #2DD4BF, #0D9488 60%, #115E59 100%)',
            'cyan': 'radial-gradient(circle at 35% 35%, #22D3EE, #0891B2 60%, #164E63 100%)',
            'multicolor': 'conic-gradient(#FF0000, #FFFF00, #00FF00, #00FFFF, #0000FF, #FF00FF, #FF0000)',
            'multi': 'conic-gradient(#FF0000, #FFFF00, #00FF00, #00FFFF, #0000FF, #FF00FF, #FF0000)'
        };

        function enhanceColorSwatches() {
            const form = document.querySelector('form.variations_form');
            if (!form) return;

            const rows = form.querySelectorAll('.variation-row, tr, .wvs-attribute-behavior, .variations tbody tr');
            rows.forEach(row => {
                const labelText = (row.querySelector('label, th')?.textContent || '').toLowerCase();
                const isColorAttr = labelText.includes('color') || labelText.includes('colour') || (row.dataset?.attribute_name && row.dataset.attribute_name.includes('color'));

                const items = row.querySelectorAll('li.variable-item, .wvs-radio-variable-item');
                items.forEach(item => {
                    const rawVal = (item.dataset.value || item.dataset.title || item.getAttribute('aria-label') || item.textContent || '').trim().toLowerCase();
                    if (!rawVal) return;

                    let bgStyle = colorGradients[rawVal];
                    if (!bgStyle) {
                        for (const [cKey, cGrad] of Object.entries(colorGradients)) {
                            if (rawVal.includes(cKey)) {
                                bgStyle = cGrad;
                                break;
                            }
                        }
                    }

                    if (isColorAttr || bgStyle) {
                        item.classList.add('color-swatch-wrap');
                        let dot = item.querySelector('.color-swatch-dot');
                        const contents = item.querySelector('.variable-item-contents') || item;
                        contents.classList.add('color-swatch-wrap');
                        if (!dot) {
                            dot = document.createElement('span');
                            dot.className = 'color-swatch-dot';
                            const spanTag = contents.querySelector('span') || contents.firstChild;
                            if (spanTag) {
                                contents.insertBefore(dot, spanTag);
                            } else {
                                contents.appendChild(dot);
                            }
                        }

                        if (!bgStyle) {
                            bgStyle = `radial-gradient(circle at 35% 35%, ${rawVal}, #444444)`;
                        }

                        dot.style.background = bgStyle;
                        if (rawVal === 'white' || rawVal === 'clear' || rawVal === 'transparent') {
                            dot.style.borderColor = '#CBD5E1';
                        }
                    }
                });
            });
        }

        enhanceColorSwatches();
        setTimeout(enhanceColorSwatches, 100);
        setTimeout(enhanceColorSwatches, 300);
        setTimeout(enhanceColorSwatches, 800);
        $(document).on('woocommerce_variation_has_changed wvs_items_rendered updated_wc_div check_variations', enhanceColorSwatches);

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
