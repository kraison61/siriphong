/* ═══════════════════════════════════════════════════
   main.js - แยกจาก app.js
   ═══════════════════════════════════════════════════ */

/* ── Mobile nav ── */
function toggleMenu() {
  const menu = document.getElementById('mobile-menu');
  const btn  = document.getElementById('hamburger');
  const icon = document.getElementById('ham-icon');
  if (!menu || !btn || !icon) return; // ✅ เพิ่ม null check

  const open = menu.classList.toggle('hidden') === false;
  menu.classList.toggle('flex', open);
  btn.setAttribute('aria-expanded', open);
  icon.className = open ? 'bi bi-x-lg' : 'bi bi-list';
}

function closeMenu() {
  const menu = document.getElementById('mobile-menu');
  if (!menu) return; // ✅ เพิ่ม null check

  menu.classList.add('hidden');
  menu.classList.remove('flex');

  const hb = document.getElementById('hamburger');
  const icon = document.getElementById('ham-icon');
  if (hb) hb.setAttribute('aria-expanded', 'false');
  if (icon) icon.className = 'bi bi-list';
}

/* ── Service filter ── */
function filterServices(cat) {
  filterSection('services', cat);
}

/* ── Section-scoped catalog filter ── */
function filterSection(sectionId, cat) {
  const section = document.getElementById(sectionId);
  if (!section) return;

  section.querySelectorAll('.filter-btn').forEach(b => {
    const onclick = b.getAttribute('onclick') || '';
    b.setAttribute('aria-pressed', String(onclick.includes(`'${cat}'`)));
  });

  section.querySelectorAll('.catalog-card, .service-card').forEach(card => {
    const show = cat === 'all' || card.dataset.category === cat;
    card.classList.toggle('hidden', !show);
    if (show) {
      card.classList.remove('animate-fade-up');
      void card.offsetWidth;
      card.classList.add('animate-fade-up');
    }
  });
}

/* ── Contact form ── */
function handleSubmit(e) {
  e.preventDefault();
  const btn = e.target.querySelector('button[type=submit]');
  const name = document.getElementById('contact-name')?.value.trim();    // ✅ optional chaining
  const phone = document.getElementById('contact-phone')?.value.trim();  // ✅ optional chaining
  const problem = document.getElementById('contact-problem')?.value.trim(); // ✅ optional chaining

  if (!btn) return;

  if (!name || !phone || !problem) {
    btn.textContent = '⚠ กรุณากรอกข้อมูลให้ครบ';
    btn.classList.remove('bg-orange');
    btn.classList.add('bg-orange-dark');
    setTimeout(() => {
      btn.innerHTML = '<i class="bi bi-send-fill"></i> ส่งรายละเอียด';
      btn.classList.remove('bg-orange-dark');
      btn.classList.add('bg-orange');
    }, 2000);
    return;
  }

  btn.innerHTML = '<i class="bi bi-check2-circle"></i> ส่งสำเร็จ! รอรับสายเร็วๆ นี้';
  btn.classList.remove('bg-orange');
  btn.classList.add('bg-line');
  btn.disabled = true;
}

/* ═══════════════════════════════════════════════════
   ✅ สำคัญมาก! ต้อง expose ฟังก์ชันออกมาที่ window
   เพื่อให้ onclick="" ใน Blade เรียกใช้ได้
   ═══════════════════════════════════════════════════ */
window.toggleMenu     = toggleMenu;
window.closeMenu      = closeMenu;
window.filterServices = filterServices;
window.filterSection  = filterSection;
window.handleSubmit   = handleSubmit;

/* ═══════════════════════════════════════════════════
   ส่วนที่ทำงานกับ DOM → ห่อด้วย DOMContentLoaded
   ═══════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {

  /* ── Scroll reveal ── */
  const revealEls = document.querySelectorAll('[data-reveal]');
  if (revealEls.length) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.dataset.show = 'true';
          observer.unobserve(e.target);
        }
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(el => observer.observe(el));
  }

  /* ── Back to top ── */
  const backTop = document.getElementById('back-top');
  if (backTop) {
    window.addEventListener('scroll', () => {
      backTop.dataset.show = window.scrollY > 500;
    }, { passive: true });
  }

  /* ── Smooth nav link scroll ── */
  document.querySelectorAll('a[href*="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const href = a.getAttribute('href');
      if (!href || !href.includes('#')) return;

      const hash = '#' + href.split('#').slice(1).join('#');
      const target = document.querySelector(hash);
      const isSamePage = href.startsWith('#') || a.pathname === window.location.pathname;
      if (target && isSamePage) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        history.replaceState(null, '', hash);
      }
    });
  });

  /* ── Scroll to hash on load (cross-page anchors) ── */
  if (window.location.hash) {
    const target = document.querySelector(window.location.hash);
    if (target) {
      setTimeout(() => target.scrollIntoView({ behavior: 'smooth', block: 'start' }), 100);
    }
  }

  /* ── Navbar active link on scroll ── */
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('[data-nav]');
  if (sections.length && navLinks.length) {
    window.addEventListener('scroll', () => {
      let current = '';
      sections.forEach(s => {
        if (window.scrollY >= s.offsetTop - 100) current = s.id;
      });
      navLinks.forEach(a => {
        const href = a.getAttribute('href') || '';
        const hash = href.includes('#') ? href.split('#')[1] : '';
        a.dataset.active = hash === current;
      });
    }, { passive: true });
  }

  /* ── Portfolio carousel ── */
  const portfolioCarousel = document.getElementById('portfolio-carousel');
  if (portfolioCarousel) {
    const track = portfolioCarousel.querySelector('.portfolio-carousel-track');
    const slides = [...portfolioCarousel.querySelectorAll('.portfolio-carousel-slide')];
    const viewport = portfolioCarousel.querySelector('.portfolio-carousel-viewport');
    const prevBtn = document.getElementById('portfolio-carousel-prev');
    const nextBtn = document.getElementById('portfolio-carousel-next');
    const dotsContainer = document.getElementById('portfolio-carousel-dots');
    const counterEl = document.getElementById('portfolio-carousel-counter');
    const progressEl = document.getElementById('portfolio-carousel-progress');
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    let currentIndex = 0;
    let autoplayTimer = null;
    let touchStartX = 0;
    let touchDeltaX = 0;

    const getSlidesPerView = () => {
      if (slides.length <= 1) return 1;
      if (window.matchMedia('(min-width: 1024px)').matches) return Math.min(3, slides.length);
      if (window.matchMedia('(min-width: 640px)').matches) return Math.min(2, slides.length);
      return 1;
    };

    const getMaxIndex = () => Math.max(0, slides.length - getSlidesPerView());

    const buildDots = () => {
      if (!dotsContainer) return;
      dotsContainer.innerHTML = '';
      const pages = getMaxIndex() + 1;
      for (let i = 0; i < pages; i++) {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'portfolio-carousel-dot w-2.5 h-2.5 rounded-full bg-slate-300 transition-all duration-300 hover:bg-orange/60 data-[active=true]:w-7 data-[active=true]:bg-orange';
        dot.setAttribute('role', 'tab');
        dot.setAttribute('aria-label', `ไปที่ผลงานหน้า ${i + 1}`);
        dot.dataset.index = String(i);
        dot.addEventListener('click', () => goTo(i));
        dotsContainer.appendChild(dot);
      }
    };

    const updateUI = () => {
      const spv = getSlidesPerView();
      const maxIndex = getMaxIndex();
      currentIndex = Math.max(0, Math.min(currentIndex, maxIndex));

      const gap = parseFloat(getComputedStyle(track).gap) || 16;
      const slideWidth = slides[0]?.offsetWidth || 0;
      track.style.transform = `translateX(-${currentIndex * (slideWidth + gap)}px)`;

      slides.forEach((slide, i) => {
        const isVisible = i >= currentIndex && i < currentIndex + spv;
        slide.dataset.active = String(isVisible);
        slide.setAttribute('aria-hidden', isVisible ? 'false' : 'true');
      });

      dotsContainer?.querySelectorAll('.portfolio-carousel-dot').forEach((dot, i) => {
        dot.dataset.active = String(i === currentIndex);
        dot.setAttribute('aria-selected', String(i === currentIndex));
      });

      if (counterEl) {
        counterEl.textContent = `${currentIndex + 1} / ${maxIndex + 1}`;
      }

      if (progressEl) {
        const progress = maxIndex === 0 ? 100 : (currentIndex / maxIndex) * 100;
        progressEl.style.width = `${progress}%`;
      }

      prevBtn && (prevBtn.disabled = currentIndex === 0);
      nextBtn && (nextBtn.disabled = currentIndex >= maxIndex);
    };

    const goTo = (index) => {
      currentIndex = index;
      updateUI();
      resetAutoplay();
    };

    const step = (direction) => goTo(currentIndex + direction);

    const resetAutoplay = () => {
      if (prefersReducedMotion || slides.length <= getSlidesPerView()) return;
      clearInterval(autoplayTimer);
      autoplayTimer = setInterval(() => {
        const maxIndex = getMaxIndex();
        goTo(currentIndex >= maxIndex ? 0 : currentIndex + 1);
      }, 5000);
    };

    const pauseAutoplay = () => clearInterval(autoplayTimer);

    prevBtn?.addEventListener('click', () => step(-1));
    nextBtn?.addEventListener('click', () => step(1));

    viewport?.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowLeft') { e.preventDefault(); step(-1); }
      if (e.key === 'ArrowRight') { e.preventDefault(); step(1); }
    });

    viewport?.addEventListener('pointerdown', (e) => {
      touchStartX = e.clientX;
      touchDeltaX = 0;
      pauseAutoplay();
    }, { passive: true });

    viewport?.addEventListener('pointermove', (e) => {
      if (touchStartX) touchDeltaX = e.clientX - touchStartX;
    }, { passive: true });

    viewport?.addEventListener('pointerup', () => {
      if (Math.abs(touchDeltaX) > 50) {
        step(touchDeltaX < 0 ? 1 : -1);
      } else {
        resetAutoplay();
      }
      touchStartX = 0;
      touchDeltaX = 0;
    }, { passive: true });

    portfolioCarousel.addEventListener('mouseenter', pauseAutoplay);
    portfolioCarousel.addEventListener('mouseleave', resetAutoplay);
    portfolioCarousel.addEventListener('focusin', pauseAutoplay);
    portfolioCarousel.addEventListener('focusout', resetAutoplay);

    buildDots();
    updateUI();
    resetAutoplay();

    let resizeTimer;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        buildDots();
        updateUI();
      }, 150);
    }, { passive: true });
  }

  /* ── Shared portfolio lightbox helper ── */
  const initPortfolioLightbox = ({ sectionId, lightboxId, triggerSelector, idPrefix }) => {
    const section = document.getElementById(sectionId);
    const lightbox = document.getElementById(lightboxId);
    if (!section || !lightbox) return;

    const photos = JSON.parse(section.dataset.portfolioPhotos || '[]');
    if (!photos.length) return;

    const imageEl = document.getElementById(`${idPrefix}-image`);
    const titleEl = document.getElementById(`${idPrefix}-title`);
    const categoryEl = document.getElementById(`${idPrefix}-category`);
    const counterEl = document.getElementById(`${idPrefix}-counter`);
    const closeBtn = document.getElementById(`${idPrefix}-close`);
    const prevBtn = document.getElementById(`${idPrefix}-prev`);
    const nextBtn = document.getElementById(`${idPrefix}-next`);
    const contentEl = document.getElementById(`${idPrefix}-content`);
    let currentIndex = 0;

    const showPhoto = (index) => {
      currentIndex = (index + photos.length) % photos.length;
      const photo = photos[currentIndex];
      imageEl.src = photo.src;
      imageEl.alt = photo.title;
      titleEl.textContent = photo.title;
      categoryEl.textContent = photo.category || '';
      counterEl.textContent = `${currentIndex + 1} / ${photos.length}`;
    };

    const openLightbox = (index) => {
      showPhoto(index);
      lightbox.hidden = false;
      lightbox.dataset.open = 'true';
      document.body.classList.add('overflow-hidden');
    };

    const closeLightbox = () => {
      lightbox.dataset.open = 'false';
      document.body.classList.remove('overflow-hidden');
      setTimeout(() => {
        if (lightbox.dataset.open !== 'true') {
          lightbox.hidden = true;
          imageEl.src = '';
        }
      }, 300);
    };

    section.querySelectorAll(triggerSelector).forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        openLightbox(Number(btn.dataset.portfolioIndex));
      });
    });

    closeBtn?.addEventListener('click', closeLightbox);
    prevBtn?.addEventListener('click', () => showPhoto(currentIndex - 1));
    nextBtn?.addEventListener('click', () => showPhoto(currentIndex + 1));

    lightbox.addEventListener('click', (e) => {
      if (e.target === lightbox) closeLightbox();
    });

    contentEl?.addEventListener('click', (e) => e.stopPropagation());

    document.addEventListener('keydown', (e) => {
      if (lightbox.dataset.open !== 'true') return;
      if (e.key === 'Escape') closeLightbox();
      if (e.key === 'ArrowRight') showPhoto(currentIndex + 1);
      if (e.key === 'ArrowLeft') showPhoto(currentIndex - 1);
    });
  };

  initPortfolioLightbox({
    sectionId: 'portfolio',
    lightboxId: 'portfolio-lightbox',
    triggerSelector: '.portfolio-lightbox-trigger',
    idPrefix: 'portfolio-lightbox',
  });

  initPortfolioLightbox({
    sectionId: 'portfolio-gallery',
    lightboxId: 'portfolio-gallery-lightbox',
    triggerSelector: '.portfolio-gallery-lightbox-trigger',
    idPrefix: 'portfolio-gallery-lightbox',
  });

  /* ── Portfolio gallery filter + accordion ── */
  const portfolioGallery = document.getElementById('portfolio-gallery');
  if (portfolioGallery) {
    const emptyEl = document.getElementById('portfolio-gallery-empty');
    const cards = [...portfolioGallery.querySelectorAll('.portfolio-case-card')];
    const filterBtns = [...portfolioGallery.querySelectorAll('.portfolio-gallery-filter')];

    const applyFilter = (cat) => {
      filterBtns.forEach(btn => {
        btn.setAttribute('aria-pressed', String(btn.dataset.filter === cat));
      });

      let visible = 0;
      cards.forEach(card => {
        const show = cat === 'all' || card.dataset.category === cat;
        card.classList.toggle('hidden', !show);
        if (show) visible += 1;
      });

      emptyEl?.classList.toggle('hidden', visible > 0);
    };

    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => applyFilter(btn.dataset.filter || 'all'));
    });

    portfolioGallery.querySelectorAll('.portfolio-case-toggle').forEach(btn => {
      btn.addEventListener('click', () => {
        const card = btn.closest('.portfolio-case-card');
        const detail = card?.querySelector('.portfolio-case-detail');
        const label = btn.querySelector('.portfolio-case-toggle-label');
        const icon = btn.querySelector('.portfolio-case-toggle-icon');
        if (!detail) return;

        const willOpen = detail.hidden || detail.classList.contains('hidden');

        // Close other open details
        portfolioGallery.querySelectorAll('.portfolio-case-card').forEach(other => {
          if (other === card) return;
          const otherDetail = other.querySelector('.portfolio-case-detail');
          const otherBtn = other.querySelector('.portfolio-case-toggle');
          const otherLabel = otherBtn?.querySelector('.portfolio-case-toggle-label');
          const otherIcon = otherBtn?.querySelector('.portfolio-case-toggle-icon');
          if (otherDetail) {
            otherDetail.hidden = true;
            otherDetail.classList.add('hidden');
          }
          otherBtn?.setAttribute('aria-expanded', 'false');
          if (otherLabel) otherLabel.textContent = 'ดูรายละเอียด';
          otherIcon?.classList.remove('rotate-180');
        });

        detail.hidden = !willOpen;
        detail.classList.toggle('hidden', !willOpen);
        btn.setAttribute('aria-expanded', String(willOpen));
        if (label) label.textContent = willOpen ? 'ซ่อนรายละเอียด' : 'ดูรายละเอียด';
        icon?.classList.toggle('rotate-180', willOpen);
      });
    });
  }

});
