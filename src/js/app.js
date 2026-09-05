import './blocks/slider';
import { initShopFilters } from './modules/shop-filter';
import { initSingleProduct } from './modules/single-product';
import { initCart } from './modules/cart';

document.addEventListener('DOMContentLoaded', () => {
  // Initialize Real-Time Shop & Category Filters
  initShopFilters();

  // Initialize Single Product Interactions (Gallery, Quantity, Tabs)
  initSingleProduct();

  // Initialize Cart Auto-Update & Stepper Interactions
  initCart();

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
      drawer.setAttribute('aria-hidden', 'false');
      if (menuToggleBtn) {
        menuToggleBtn.setAttribute('aria-expanded', 'true');
      }
      setTimeout(() => {
        if (closeBtn) closeBtn.focus();
      }, 50);
    }
  }

  function closeDrawer() {
    if (drawer && backdrop) {
      drawer.classList.add('-translate-x-full');
      backdrop.classList.remove('opacity-100', 'pointer-events-auto');
      backdrop.classList.add('opacity-0', 'pointer-events-none');
      document.body.style.overflow = '';
      drawer.setAttribute('aria-hidden', 'true');
      if (menuToggleBtn) {
        menuToggleBtn.setAttribute('aria-expanded', 'false');
        menuToggleBtn.focus();
      }
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
    if (e.key === 'Escape' && drawer && !drawer.classList.contains('-translate-x-full')) {
      closeDrawer();
    }
    // Keyboard Focus Trap in Drawer (WCAG 2.1 AA)
    if (e.key === 'Tab' && drawer && !drawer.classList.contains('-translate-x-full')) {
      const focusableEls = drawer.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
      if (focusableEls.length > 0) {
        const firstEl = focusableEls[0];
        const lastEl = focusableEls[focusableEls.length - 1];
        if (e.shiftKey && document.activeElement === firstEl) {
          e.preventDefault();
          lastEl.focus();
        } else if (!e.shiftKey && document.activeElement === lastEl) {
          e.preventDefault();
          firstEl.focus();
        }
      }
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

  // ─── Floating Toast Notification Utility ────────────────────
  function showToast(message, isError = false) {
    let container = document.getElementById('dg-toast-container');
    if (!container) {
      container = document.createElement('div');
      container.id = 'dg-toast-container';
      container.className = 'fixed bottom-5 right-5 z-[99999] flex flex-col gap-2 pointer-events-none';
      document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = `pointer-events-auto flex items-center gap-2.5 px-4 py-3 rounded-lg shadow-xl text-sm font-medium transition-all duration-300 transform translate-y-4 opacity-0 ${
      isError ? 'bg-[#D32F2F] text-white' : 'bg-[#181818] text-white border border-[#333333]'
    }`;
    toast.innerHTML = `
      <span class="w-2 h-2 rounded-full ${isError ? 'bg-white' : 'bg-[#CC5600]'} shrink-0"></span>
      <span>${message}</span>
    `;

    container.appendChild(toast);
    requestAnimationFrame(() => {
      toast.classList.remove('translate-y-4', 'opacity-0');
      toast.classList.add('translate-y-0', 'opacity-100');
    });

    setTimeout(() => {
      toast.classList.add('opacity-0', 'translate-y-2');
      setTimeout(() => toast.remove(), 350);
    }, 2500);
  }

  function revertWishlistUI(btn, svgHeart, wasInWishlist) {
    if (wasInWishlist) {
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
  }

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

          // Update header wishlist badge count across the site
          const headerBadges = document.querySelectorAll('.header-wishlist-badge, .header-badge-count, .header-wishlist-count');
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

          // Show confirmation toast
          showToast(res.data.message || (inWl ? 'Added to Wishlist' : 'Removed from Wishlist'));
        } else {
          revertWishlistUI(btn, svgHeart, isCurrentlyInWishlist);
          showToast(res.data?.message || 'Unable to update wishlist', true);
        }
      })
      .catch((err) => {
        console.error('Wishlist toggle error:', err);
        revertWishlistUI(btn, svgHeart, isCurrentlyInWishlist);
        showToast('Network error, please try again.', true);
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

  // Function to sync header cart badge immediately
  function updateHeaderCartCount(count) {
    const miniCartBadges = document.querySelectorAll('.mini-cart-count');
    miniCartBadges.forEach((badge) => {
      if (typeof count === 'number' && count > 0) {
        badge.textContent = count;
        badge.classList.remove('hidden');
      } else if (typeof count === 'number' && count === 0) {
        badge.textContent = '0';
        badge.classList.add('hidden');
      } else {
        const cur = parseInt(badge.textContent.trim(), 10) || 0;
        badge.textContent = cur + 1;
        badge.classList.remove('hidden');
      }
    });
  }

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

      // Check if fragments provided the updated count
      if (fragments && fragments['a.header-cart-trigger']) {
        const temp = document.createElement('div');
        temp.innerHTML = fragments['a.header-cart-trigger'];
        const badgeInFrag = temp.querySelector('.mini-cart-count');
        if (badgeInFrag) {
          const parsed = parseInt(badgeInFrag.textContent.trim(), 10) || 0;
          updateHeaderCartCount(parsed);
        }
      } else {
        updateHeaderCartCount();
      }

      // Show instant toast confirmation
      showToast('Item added to your shopping bag!');

      // Trigger standard fragments refresh for mini-cart flyout
      window.jQuery(document.body).trigger('wc_fragment_refresh');
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
