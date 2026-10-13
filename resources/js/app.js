/**
 * Front-end behaviour for the public site. Vanilla JS, no dependencies.
 */

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function initHeader() {
    const header = document.querySelector('[data-header]');

    if (!header) {
        return;
    }

    const update = () => header.classList.toggle('is-scrolled', window.scrollY > 10);
    update();
    window.addEventListener('scroll', update, { passive: true });
}

function initMobileMenu() {
    const menu = document.querySelector('[data-menu]');
    const openButton = document.querySelector('[data-menu-open]');

    if (!menu || !openButton) {
        return;
    }

    const setOpen = (open) => {
        menu.classList.toggle('is-open', open);
        menu.setAttribute('aria-hidden', String(!open));
        openButton.setAttribute('aria-expanded', String(open));
        document.documentElement.classList.toggle('overflow-hidden', open);
    };

    openButton.addEventListener('click', () => setOpen(true));
    menu.querySelectorAll('[data-menu-close]').forEach((el) => el.addEventListener('click', () => setOpen(false)));
    document.addEventListener('keydown', (event) => event.key === 'Escape' && setOpen(false));
    window.matchMedia('(min-width: 1024px)').addEventListener('change', (event) => event.matches && setOpen(false));
}

function initSlider(root) {
    const slides = [...root.querySelectorAll('[data-slide]')];
    const dots = [...root.querySelectorAll('[data-slider-dot]')];

    if (slides.length < 2) {
        return;
    }

    let current = 0;
    let timer = null;

    const show = (index) => {
        current = (index + slides.length) % slides.length;
        slides.forEach((slide, i) => {
            slide.classList.toggle('is-active', i === current);
            slide.inert = i !== current;
        });
        dots.forEach((dot, i) => dot.classList.toggle('is-active', i === current));
    };

    const stop = () => clearInterval(timer);
    const start = () => {
        stop();
        if (!prefersReducedMotion) {
            timer = setInterval(() => show(current + 1), 6500);
        }
    };

    root.querySelector('[data-slider-prev]')?.addEventListener('click', () => { show(current - 1); start(); });
    root.querySelector('[data-slider-next]')?.addEventListener('click', () => { show(current + 1); start(); });
    dots.forEach((dot, i) => dot.addEventListener('click', () => { show(i); start(); }));

    root.addEventListener('mouseenter', stop);
    root.addEventListener('mouseleave', start);

    // Touch swipe
    let touchStartX = null;
    root.addEventListener('touchstart', (event) => { touchStartX = event.touches[0].clientX; }, { passive: true });
    root.addEventListener('touchend', (event) => {
        if (touchStartX === null) {
            return;
        }
        const delta = event.changedTouches[0].clientX - touchStartX;
        if (Math.abs(delta) > 50) {
            show(current + (delta < 0 ? 1 : -1));
            start();
        }
        touchStartX = null;
    });

    show(0);
    start();
}

function initReveal() {
    const items = document.querySelectorAll('.reveal');

    if (prefersReducedMotion || !('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });

    items.forEach((el) => observer.observe(el));
}

initHeader();
initMobileMenu();
document.querySelectorAll('[data-slider]').forEach(initSlider);
initReveal();
