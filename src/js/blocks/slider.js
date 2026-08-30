import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';

// 1. Hero Auto-Slider (Full 3-card sets)
const heroSwiperEl = document.querySelector('.heroSwiper');
if (heroSwiperEl) {
  new Swiper('.heroSwiper', {
    modules: [Pagination, Autoplay, EffectFade],
    slidesPerView: 1,
    loop: true,
    speed: 800,
    autoplay: {
      delay: 4500,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
    pagination: {
      el: '.hero-swiper-pagination',
      clickable: true,
      bulletClass: 'hero-bullet',
      bulletActiveClass: 'hero-bullet-active',
    },
  });
}

// 2. Discover Divine Energies Full-Width Scroller
const energiesSwiperEl = document.querySelector('.energiesSwiper');
if (energiesSwiperEl) {
  new Swiper('.energiesSwiper', {
    modules: [Autoplay],
    slidesPerView: 2.8,
    spaceBetween: 16,
    loop: true,
    speed: 4000,
    autoplay: {
      delay: 1500,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
    breakpoints: {
      480: { slidesPerView: 2.8, spaceBetween: 18 },
      640: { slidesPerView: 3.5, spaceBetween: 20 },
      768: { slidesPerView: 4.5, spaceBetween: 22 },
      1024: { slidesPerView: 5.5, spaceBetween: 24 },
    },
  });
}

// 3. Product Videos Reels Full-Width Swiper with Playback
const productVideosSwiperEl = document.querySelector('.productVideosSwiper');
if (productVideosSwiperEl) {
  new Swiper('.productVideosSwiper', {
    modules: [Navigation],
    slidesPerView: 1.4,
    spaceBetween: 16,
    loop: true,
    navigation: {
      nextEl: '.productVideosSwiper .swiper-button-next',
      prevEl: '.productVideosSwiper .swiper-button-prev',
    },
    breakpoints: {
      480: { slidesPerView: 2.2, spaceBetween: 18 },
      640: { slidesPerView: 3.2, spaceBetween: 20 },
      768: { slidesPerView: 3.8, spaceBetween: 20 },
      1024: { slidesPerView: 4.6, spaceBetween: 24 },
      1280: { slidesPerView: 5.5, spaceBetween: 24 },
      1536: { slidesPerView: 6.2, spaceBetween: 26 },
    },
  });

  // Video Click-to-Play & Mute Toggle Handler
  document.addEventListener('click', (e) => {
    const card = e.target.closest('.product-reel-card');
    if (!card) return;

    // Ignore clicks on links/buttons inside the card
    if (e.target.closest('a') || e.target.closest('.reel-mute-btn')) return;

    const video = card.querySelector('.reel-video');
    const poster = card.querySelector('.reel-poster');
    const playIndicator = card.querySelector('.reel-play-indicator');
    const playIcon = card.querySelector('.icon-play');
    const pauseIcon = card.querySelector('.icon-pause');
    const muteBtn = card.querySelector('.reel-mute-btn');

    if (!video) return;

    // Pause all other playing reel videos first
    document.querySelectorAll('.reel-video').forEach((otherVideo) => {
      if (otherVideo !== video && !otherVideo.paused) {
        otherVideo.pause();
        const otherCard = otherVideo.closest('.product-reel-card');
        if (otherCard) {
          otherCard.querySelector('.icon-play')?.classList.remove('hidden');
          otherCard.querySelector('.icon-pause')?.classList.add('hidden');
        }
      }
    });

    if (video.paused) {
      // Unhide video and play
      video.classList.remove('hidden');
      if (poster) poster.style.opacity = '0';
      if (muteBtn) {
        muteBtn.classList.remove('opacity-0', 'pointer-events-none');
        muteBtn.classList.add('opacity-100', 'pointer-events-auto');
      }

      video.play().then(() => {
        if (playIcon) playIcon.classList.add('hidden');
        if (pauseIcon) pauseIcon.classList.remove('hidden');
        if (playIndicator) playIndicator.style.opacity = '0';
      }).catch((err) => {
        console.error('Video play error:', err);
      });
    } else {
      // Pause video
      video.pause();
      if (playIcon) playIcon.classList.remove('hidden');
      if (pauseIcon) pauseIcon.classList.add('hidden');
      if (playIndicator) playIndicator.style.opacity = '1';
    }
  });

  // Mute/Unmute toggle
  document.addEventListener('click', (e) => {
    const muteBtn = e.target.closest('.reel-mute-btn');
    if (!muteBtn) return;

    const card = muteBtn.closest('.product-reel-card');
    if (!card) return;

    const video = card.querySelector('.reel-video');
    const iconMuted = muteBtn.querySelector('.icon-muted');
    const iconUnmuted = muteBtn.querySelector('.icon-unmuted');

    if (video) {
      video.muted = !video.muted;
      if (video.muted) {
        iconMuted?.classList.remove('hidden');
        iconUnmuted?.classList.add('hidden');
      } else {
        iconMuted?.classList.add('hidden');
        iconUnmuted?.classList.remove('hidden');
      }
    }
  });
}

// 4. Testimonial Swiper (Figma 5-Card Layout)
const testimonialSwiperEl = document.querySelector('.testimonialSwiper');
if (testimonialSwiperEl) {
  new Swiper('.testimonialSwiper', {
    modules: [Navigation],
    slidesPerView: 1.5,
    spaceBetween: 16,
    navigation: {
      nextEl: '.testimonialSwiper .swiper-button-next',
      prevEl: '.testimonialSwiper .swiper-button-prev',
    },
    breakpoints: {
      640: { slidesPerView: 2.5, spaceBetween: 20 },
      768: { slidesPerView: 3.5, spaceBetween: 20 },
      1024: { slidesPerView: 4, spaceBetween: 24 },
      1280: { slidesPerView: 5, spaceBetween: 24 },
    },
  });
}
