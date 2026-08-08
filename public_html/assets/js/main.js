(function () {
    'use strict';

    // Mobile nav toggle
    var menuBtn = document.getElementById('mobile-menu-btn');
    var menu = document.getElementById('mobile-menu');
    var iconOpen = document.getElementById('menu-icon-open');
    var iconClose = document.getElementById('menu-icon-close');

    if (menuBtn && menu) {
        menuBtn.addEventListener('click', function () {
            var isHidden = menu.classList.contains('hidden');
            menu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
            menuBtn.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
        });
    }

    // Scroll-reveal animations
    var revealEls = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window && revealEls.length) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });
        revealEls.forEach(function (el) { observer.observe(el); });
    } else {
        revealEls.forEach(function (el) { el.classList.add('is-visible'); });
    }

    // Animated stat counters
    var counters = document.querySelectorAll('[data-counter]');
    if ('IntersectionObserver' in window && counters.length) {
        var counterObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                var el = entry.target;
                var target = parseInt(el.getAttribute('data-counter'), 10) || 0;
                var duration = 1200;
                var start = null;

                function step(timestamp) {
                    if (!start) start = timestamp;
                    var progress = Math.min((timestamp - start) / duration, 1);
                    el.textContent = Math.floor(progress * target).toLocaleString();
                    if (progress < 1) {
                        requestAnimationFrame(step);
                    } else {
                        el.textContent = target.toLocaleString();
                    }
                }
                requestAnimationFrame(step);
                counterObserver.unobserve(el);
            });
        }, { threshold: 0.4 });
        counters.forEach(function (el) { counterObserver.observe(el); });
    }

    // Simple accordion (FAQ)
    document.querySelectorAll('[data-accordion-trigger]').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            var panel = document.getElementById(trigger.getAttribute('aria-controls'));
            var expanded = trigger.getAttribute('aria-expanded') === 'true';
            trigger.setAttribute('aria-expanded', String(!expanded));
            if (panel) {
                panel.classList.toggle('hidden', expanded);
            }
            var icon = trigger.querySelector('[data-accordion-icon]');
            if (icon) {
                icon.classList.toggle('rotate-45', !expanded);
            }
        });
    });

    // Lightbox for gallery images
    var lightbox = document.getElementById('lightbox');
    if (lightbox) {
        var lightboxImg = document.getElementById('lightbox-img');
        document.querySelectorAll('[data-lightbox-src]').forEach(function (thumb) {
            thumb.addEventListener('click', function () {
                lightboxImg.src = thumb.getAttribute('data-lightbox-src');
                lightbox.classList.remove('hidden');
            });
        });
        lightbox.addEventListener('click', function () {
            lightbox.classList.add('hidden');
            lightboxImg.src = '';
        });
    }
})();
