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

  // Mobile Bottom Bar Category Drawer Triggers
  const bottomCategoriesBtn = document.getElementById('mobile-bottom-nav-categories');
  if (bottomCategoriesBtn) {
    bottomCategoriesBtn.addEventListener('click', openDrawer);
  }
  document.querySelectorAll('.mobile-drawer-open-trigger').forEach((btn) => {
    btn.addEventListener('click', openDrawer);
  });

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

  // ─── Mobile Mini-Cart Drawer Interactions (< 640px) ───────────
  const cartTrigger = document.querySelector('.header-cart-trigger');
  const cartDrawer = document.getElementById('header-mini-cart-drawer');
  const cartBackdrop = document.getElementById('mini-cart-backdrop');
  const cartContainer = document.querySelector('.header-cart-content');
  const siteHeader = document.querySelector('.site-header');

  function openCartDrawer() {
    if (cartDrawer && cartBackdrop) {
      cartDrawer.classList.add('is-open');
      cartBackdrop.classList.add('is-open');
      if (cartContainer) cartContainer.classList.add('is-open');
      if (siteHeader) siteHeader.classList.add('!z-[100000]');
      document.body.classList.add('mini-cart-open');
      document.body.style.overflow = 'hidden';
      const closeBtn = cartDrawer.querySelector('.mini-cart-close-btn');
      if (closeBtn) {
        setTimeout(() => closeBtn.focus(), 50);
      }
    }
  }

  function closeCartDrawer() {
    if (cartDrawer && cartBackdrop) {
      cartDrawer.classList.remove('is-open');
      cartBackdrop.classList.remove('is-open');
      if (cartContainer) cartContainer.classList.remove('is-open');
      if (siteHeader) siteHeader.classList.remove('!z-[100000]');
      document.body.classList.remove('mini-cart-open');
      document.body.style.overflow = '';
      if (cartTrigger) {
        cartTrigger.focus();
      }
    }
  }

  // Header Bag icon click on mobile: slide drawer open
  if (cartTrigger) {
    cartTrigger.addEventListener('click', (e) => {
      if (window.innerWidth <= 639) {
        e.preventDefault();
        openCartDrawer();
      }
    });
  }

  // Mobile Bottom Bar Cart icon: slide drawer open unless already on cart page
  const bottomBarCart = document.querySelector('.mobile-bottom-control-bar a[href*="cart"]');
  if (bottomBarCart) {
    bottomBarCart.addEventListener('click', (e) => {
      if (window.innerWidth <= 639 && !window.location.pathname.includes('/cart')) {
        e.preventDefault();
        openCartDrawer();
      }
    });
  }

  // Close button & backdrop clicks (with event delegation for dynamic fragments)
  document.addEventListener('click', (e) => {
    if (e.target.closest('.mini-cart-close-btn') || e.target.closest('#mini-cart-backdrop')) {
      e.preventDefault();
      closeCartDrawer();
    }
  });

  // Close on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && cartDrawer && cartDrawer.classList.contains('is-open')) {
      closeCartDrawer();
    }
  });

  // Auto-close on viewport resize to desktop
  window.addEventListener('resize', () => {
    if (window.innerWidth > 639 && cartDrawer && cartDrawer.classList.contains('is-open')) {
      closeCartDrawer();
    }
  });

  // Mobile Bottom Bar Scroll Threshold Listener (Reveal after 300px, max-width <= 640px)
  const bottomBar = document.querySelector('.mobile-bottom-control-bar');
  if (bottomBar) {
    let ticking = false;
    const handleBottomBarScroll = () => {
      const isMobile = window.innerWidth <= 640;
      const hasScrolledPast300 = window.scrollY > 300;
      if (isMobile && hasScrolledPast300) {
        bottomBar.classList.add('is-visible');
      } else {
        bottomBar.classList.remove('is-visible');
      }
      ticking = false;
    };

    window.addEventListener('scroll', () => {
      if (!ticking) {
        window.requestAnimationFrame(handleBottomBarScroll);
        ticking = true;
      }
    }, { passive: true });

    window.addEventListener('resize', handleBottomBarScroll, { passive: true });
    handleBottomBarScroll();
  }

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

  // Function to sync header & mobile bottom bar cart badge immediately
  function updateHeaderCartCount(count) {
    const miniCartBadges = document.querySelectorAll('.mini-cart-count');
    miniCartBadges.forEach((badge) => {
      const isBottomBar = badge.closest('.mobile-bottom-control-bar');
      if (typeof count === 'number' && count > 0) {
        badge.textContent = count;
        badge.classList.remove('hidden');
      } else if (typeof count === 'number' && count === 0) {
        badge.textContent = '0';
        if (!isBottomBar) {
          badge.classList.add('hidden');
        } else {
          badge.classList.remove('hidden');
        }
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
