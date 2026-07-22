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
  document.querySelectorAll('.filter-btn').forEach(b => {
    const onclick = b.getAttribute('onclick') || ''; // ✅ กัน null
    b.setAttribute('aria-pressed', String(onclick.includes(`'${cat}'`)));
  });

  document.querySelectorAll('.service-card').forEach(card => {
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
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

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
        a.dataset.active = (a.getAttribute('href') === '#' + current);
      });
    }, { passive: true });
  }

  /* ── Portfolio lightbox ── */
  const portfolioSection = document.getElementById('portfolio');
  const lightbox = document.getElementById('portfolio-lightbox');
  if (portfolioSection && lightbox) {
    const photos = JSON.parse(portfolioSection.dataset.portfolioPhotos || '[]');
    if (photos.length) {
      const imageEl = document.getElementById('portfolio-lightbox-image');
      const titleEl = document.getElementById('portfolio-lightbox-title');
      const categoryEl = document.getElementById('portfolio-lightbox-category');
      const counterEl = document.getElementById('portfolio-lightbox-counter');
      const closeBtn = document.getElementById('portfolio-lightbox-close');
      const prevBtn = document.getElementById('portfolio-lightbox-prev');
      const nextBtn = document.getElementById('portfolio-lightbox-next');
      const contentEl = document.getElementById('portfolio-lightbox-content');
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

      portfolioSection.querySelectorAll('.portfolio-lightbox-trigger').forEach(btn => {
        btn.addEventListener('click', () => {
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
    }
  }

});
