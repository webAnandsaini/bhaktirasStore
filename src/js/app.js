import './blocks/slider';
import { initShopFilters } from './modules/shop-filter';
import { initSingleProduct } from './modules/single-product';

document.addEventListener('DOMContentLoaded', () => {
  // Initialize Real-Time Shop & Category Filters
  initShopFilters();

  // Initialize Single Product Interactions (Gallery, Quantity, Tabs)
  initSingleProduct();

  // Mobile Menu Drawer Toggles
  const menuToggleBtn = document.getElementById('mobile-menu-toggle');
  const drawer = document.getElementById('mobile-drawer');
  const backdrop = document.getElementById('mobile-drawer-backdrop');
  const closeBtn = document.getElementById('mobile-drawer-close');

  function openDrawer() {
    if (drawer && backdrop) {
      drawer.classList.remove('-translate-x-full');
      backdrop.classList.remove('opacity-0', 'pointer-events-none');
      backdrop.classList.add('opacity-100', 'pointer-events-auto');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeDrawer() {
    if (drawer && backdrop) {
      drawer.classList.add('-translate-x-full');
      backdrop.classList.remove('opacity-100', 'pointer-events-auto');
      backdrop.classList.add('opacity-0', 'pointer-events-none');
      document.body.style.overflow = '';
    }
  }

  if (menuToggleBtn) {
    menuToggleBtn.addEventListener('click', openDrawer);
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', closeDrawer);
  }

  if (backdrop) {
    backdrop.addEventListener('click', closeDrawer);
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeDrawer();
    }
  });

  // Mobile Category Dropdowns / Accordions
  const categoryToggles = document.querySelectorAll('.mobile-category-toggle');
  categoryToggles.forEach(toggle => {
    toggle.addEventListener('click', () => {
      const sub = toggle.nextElementSibling;
      if (sub) {
        sub.classList.toggle('hidden');
      }
    });
  });

  // ─── 2-Way AJAX Wishlist Toggle (Add / Remove, Zero Redirect) ──
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.dharmgyan-wishlist-toggle-btn');
    if (!btn) return;

    e.preventDefault();
    e.stopPropagation();

    const productId = btn.dataset.productId;
    if (!productId) return;

    const svgHeart = btn.querySelector('.heart-icon');
    const isCurrentlyInWishlist = btn.classList.contains('is-in-wishlist');

    // Optimistic UI update (Instant 0ms visual feedback)
    if (isCurrentlyInWishlist) {
      btn.classList.remove('is-in-wishlist');
      if (svgHeart) {
        svgHeart.setAttribute('fill', 'none');
        svgHeart.setAttribute('stroke', 'currentColor');
      }
    } else {
      btn.classList.add('is-in-wishlist');
      if (svgHeart) {
        svgHeart.setAttribute('fill', '#CC5600');
        svgHeart.setAttribute('stroke', '#CC5600');
      }
    }

    // Send AJAX toggle request
    const formData = new FormData();
    formData.append('action', 'dharmgyan_toggle_wishlist');
    formData.append('product_id', productId);

    fetch(window.dharmgyan_vars?.ajax_url || '/wp-admin/admin-ajax.php', {
      method: 'POST',
      body: formData,
    })
      .then((res) => res.json())
      .then((res) => {
        if (res.success) {
          const inWl = res.data.in_wishlist;
          if (inWl) {
            btn.classList.add('is-in-wishlist');
            if (svgHeart) {
              svgHeart.setAttribute('fill', '#CC5600');
              svgHeart.setAttribute('stroke', '#CC5600');
            }
          } else {
            btn.classList.remove('is-in-wishlist');
            if (svgHeart) {
              svgHeart.setAttribute('fill', 'none');
              svgHeart.setAttribute('stroke', 'currentColor');
            }
          }

          // Update header wishlist badge count
          const headerBadges = document.querySelectorAll('.header-wishlist-badge, .header-badge-count');
          headerBadges.forEach((badge) => {
            if (badge.closest('a[href*="wishlist"]')) {
              if (res.data.count > 0) {
                badge.textContent = res.data.count;
                badge.classList.remove('hidden');
              } else {
                badge.classList.add('hidden');
              }
            }
          });
        }
      })
      .catch((err) => {
        console.error('Wishlist toggle error:', err);
      });
  });

  // ─── Interactive AJAX Add to Cart Feedback Handler ──────────
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.ajax_add_to_cart');
    if (!btn) return;

    const span = btn.querySelector('.btn-text') || btn.querySelector('span');
    if (span && !btn.dataset.originalText) {
      btn.dataset.originalText = span.textContent.trim();
    }

    // Set loading state with spinner
    btn.classList.add('loading');
    btn.classList.remove('is-added', 'added');
    if (span) {
      span.textContent = 'Adding...';
    }
  });

  // WooCommerce jQuery event listeners for AJAX Add to Cart
  if (typeof window.jQuery !== 'undefined') {
    window.jQuery(document.body).on('added_to_cart', function (event, fragments, cart_hash, $button) {
      if ($button && $button.length) {
        const btn = $button[0];
        const span = btn.querySelector('.btn-text') || btn.querySelector('span');
        
        btn.classList.remove('loading');
        btn.classList.add('is-added');
        if (span) {
          span.textContent = 'Added to cart!';
        }

        setTimeout(() => {
          btn.classList.remove('is-added', 'added');
          if (span && btn.dataset.originalText) {
            span.textContent = btn.dataset.originalText;
          }
        }, 2500);
      }
    });

    window.jQuery(document.body).on('adding_to_cart', function (event, $button) {
      if ($button && $button.length) {
        const btn = $button[0];
        const span = btn.querySelector('.btn-text') || btn.querySelector('span');
        if (span && !btn.dataset.originalText) {
          btn.dataset.originalText = span.textContent.trim();
        }
        btn.classList.add('loading');
        if (span) {
          span.textContent = 'Adding...';
        }
      }
    });
  }
});
