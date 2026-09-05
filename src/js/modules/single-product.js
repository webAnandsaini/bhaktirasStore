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
}
