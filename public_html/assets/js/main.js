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
                    el.textContent = Math.floor(progress * target);
                    if (progress < 1) {
                        requestAnimationFrame(step);
                    } else {
                        el.textContent = target;
                    }
                }
                requestAnimationFrame(step);
                counterObserver.unobserve(el);
            });
        }, { threshold: 0.4 });
        counters.forEach(function (el) { counterObserver.observe(el); });
    }

    // Fixed "Enquire" widget
    var enquireWidget = document.getElementById('enquire-widget');
    var enquireTab = document.getElementById('enquire-tab');
    var enquirePanel = document.getElementById('enquire-panel');
    var enquireClose = document.getElementById('enquire-close');

    if (enquireWidget && enquireTab && enquirePanel) {
        var setEnquireOpen = function (open) {
            enquirePanel.classList.toggle('hidden', !open);
            enquirePanel.classList.toggle('flex', open);
            enquireTab.setAttribute('aria-expanded', open ? 'true' : 'false');
        };

        enquireTab.addEventListener('click', function () {
            setEnquireOpen(enquirePanel.classList.contains('hidden'));
        });

        if (enquireClose) {
            enquireClose.addEventListener('click', function () {
                setEnquireOpen(false);
            });
        }

        document.addEventListener('click', function (event) {
            if (!enquireWidget.contains(event.target)) {
                setEnquireOpen(false);
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                setEnquireOpen(false);
            }
        });

        // Swap the tab to a light color whenever it overlaps a dark
        // bg-brand-gradient hero band, so it never blends into the
        // background as the page scrolls; transition-colors on the
        // button animates the swap.
        var heroSection = document.querySelector('.bg-brand-gradient');
        if (heroSection && 'IntersectionObserver' in window) {
            var heroObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    enquireTab.classList.toggle('bg-white', entry.isIntersecting);
                    enquireTab.classList.toggle('text-brand-blue-900', entry.isIntersecting);
                    enquireTab.classList.toggle('bg-brand-gradient', !entry.isIntersecting);
                    enquireTab.classList.toggle('text-white', !entry.isIntersecting);
                });
            }, { rootMargin: '-50% 0px -50% 0px', threshold: 0 });
            heroObserver.observe(heroSection);
        }
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

    // Testimonial marquee: pause the auto-scroll while hovered or a card is open
    var testimonialTrack = document.querySelector('[data-testimonial-track]');
    if (testimonialTrack) {
        testimonialTrack.addEventListener('mouseenter', function () {
            testimonialTrack.style.animationPlayState = 'paused';
        });
        testimonialTrack.addEventListener('mouseleave', function () {
            testimonialTrack.style.animationPlayState = 'running';
        });
    }

    // Testimonial "read more" modal
    var testimonialModal = document.getElementById('testimonial-modal');
    if (testimonialModal) {
        var tModalPhoto = document.getElementById('testimonial-modal-photo');
        var tModalQuote = document.getElementById('testimonial-modal-quote');
        var tModalName = document.getElementById('testimonial-modal-name');
        var tModalRole = document.getElementById('testimonial-modal-role');
        var tModalClose = document.getElementById('testimonial-modal-close');

        var openTestimonialModal = function (card) {
            var photo = card.getAttribute('data-photo');
            if (photo) {
                tModalPhoto.src = photo;
                tModalPhoto.alt = card.getAttribute('data-name') || '';
                tModalPhoto.setAttribute('data-lightbox-src', photo);
                tModalPhoto.classList.remove('hidden');
            } else {
                tModalPhoto.classList.add('hidden');
                tModalPhoto.removeAttribute('data-lightbox-src');
                tModalPhoto.src = '';
            }
            tModalQuote.textContent = '“' + (card.getAttribute('data-quote') || '') + '”';
            tModalName.textContent = card.getAttribute('data-name') || '';
            var role = card.getAttribute('data-role') || '';
            tModalRole.textContent = role;
            tModalRole.classList.toggle('hidden', !role);

            testimonialModal.classList.remove('hidden');
            testimonialModal.classList.add('flex');
            if (testimonialTrack) {
                testimonialTrack.style.animationPlayState = 'paused';
            }
        };

        var closeTestimonialModal = function () {
            testimonialModal.classList.add('hidden');
            testimonialModal.classList.remove('flex');
            if (testimonialTrack) {
                testimonialTrack.style.animationPlayState = 'running';
            }
        };

        document.querySelectorAll('[data-testimonial-open]').forEach(function (card) {
            card.addEventListener('click', function () {
                openTestimonialModal(card);
            });
        });

        if (tModalClose) {
            tModalClose.addEventListener('click', closeTestimonialModal);
        }
        testimonialModal.addEventListener('click', function (event) {
            if (event.target === testimonialModal) {
                closeTestimonialModal();
            }
        });
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeTestimonialModal();
            }
        });
    }

    // Lightbox for zoomable images (gallery photos, testimonial photos, etc.)
    // Delegated so it also picks up elements whose data-lightbox-src is set
    // dynamically after load (e.g. the testimonial modal photo).
    var lightbox = document.getElementById('lightbox');
    if (lightbox) {
        var lightboxImg = document.getElementById('lightbox-img');
        // Capture phase: runs before the click reaches a card's own
        // click-to-open-modal listener, so stopPropagation actually
        // prevents that listener from firing too.
        document.addEventListener('click', function (event) {
            var thumb = event.target.closest('[data-lightbox-src]');
            if (!thumb) return;
            event.stopPropagation();
            lightboxImg.src = thumb.getAttribute('data-lightbox-src');
            lightbox.classList.remove('hidden');
        }, true);
        lightbox.addEventListener('click', function () {
            lightbox.classList.add('hidden');
            lightboxImg.src = '';
        });
    }
})();
