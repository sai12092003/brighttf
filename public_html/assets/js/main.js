(function () {
    'use strict';

    // Phone inputs: strip anything that isn't a digit as the user types,
    // since type="tel"/inputmode="numeric" are just keyboard hints and
    // don't actually block letters/symbols on their own.
    document.querySelectorAll('input[name="phone"]').forEach(function (el) {
        el.addEventListener('input', function () {
            el.value = el.value.replace(/\D/g, '').slice(0, el.maxLength > 0 ? el.maxLength : 12);
        });
    });

    // Get Involved: animated Volunteer/Partner switch
    var tabSwitch = document.querySelector('[data-tab-switch]');
    if (tabSwitch) {
        var tabBtns = tabSwitch.querySelectorAll('[data-tab-btn]');
        var tabPanels = document.querySelectorAll('[data-tab-panel]');

        var activateTab = function (name) {
            tabBtns.forEach(function (btn) {
                var isActive = btn.getAttribute('data-tab-btn') === name;
                btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                btn.classList.toggle('bg-white', isActive);
                btn.classList.toggle('text-brand-blue-900', isActive);
                btn.classList.toggle('shadow-soft', isActive);
                btn.classList.toggle('text-brand-neutral-600', !isActive);
            });

            tabPanels.forEach(function (panel) {
                var isTarget = panel.getAttribute('data-tab-panel') === name;
                if (isTarget) {
                    panel.classList.remove('hidden');
                    // Force a reflow so the transition from the starting
                    // opacity/translate state actually animates in.
                    void panel.offsetWidth;
                    panel.classList.remove('opacity-0', '-translate-y-2');
                } else if (!panel.classList.contains('hidden')) {
                    panel.classList.add('opacity-0', '-translate-y-2');
                    setTimeout(function () {
                        panel.classList.add('hidden');
                    }, 300);
                }
            });
        };

        tabBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                if (btn.getAttribute('aria-pressed') === 'true') return;
                activateTab(btn.getAttribute('data-tab-btn'));
            });
        });
    }

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

    // Testimonial marquee: JS-driven (instead of a pure CSS animation) so
    // hovering + scrolling with a trackpad/mouse wheel can nudge the
    // position manually, with ambient auto-scroll resuming from wherever
    // it was left afterward, rather than fighting the user's scroll.
    var testimonialTrack = document.querySelector('[data-testimonial-track][data-loop="1"]');
    var testimonialHovered = false;
    var testimonialModalOpen = false;
    var testimonialManualPauseUntil = 0;
    if (testimonialTrack) {
        var tPosition = 0;
        var tLastTime = null;
        var tSpeed = 40; // px/second ambient auto-scroll speed
        var tHalfWidth = testimonialTrack.scrollWidth / 2;

        var tStep = function (timestamp) {
            if (tLastTime === null) tLastTime = timestamp;
            var dt = (timestamp - tLastTime) / 1000;
            tLastTime = timestamp;

            if (!testimonialHovered && !testimonialModalOpen && timestamp >= testimonialManualPauseUntil) {
                tPosition -= tSpeed * dt;
                if (tPosition <= -tHalfWidth) tPosition += tHalfWidth;
            }
            testimonialTrack.style.transform = 'translateX(' + tPosition + 'px)';
            requestAnimationFrame(tStep);
        };
        requestAnimationFrame(tStep);

        testimonialTrack.addEventListener('mouseenter', function () { testimonialHovered = true; });
        testimonialTrack.addEventListener('mouseleave', function () { testimonialHovered = false; });

        testimonialTrack.addEventListener('wheel', function (event) {
            var delta = Math.abs(event.deltaX) > Math.abs(event.deltaY) ? event.deltaX : event.deltaY;
            if (delta === 0) return;
            event.preventDefault();
            tPosition -= delta;
            if (tPosition <= -tHalfWidth) tPosition += tHalfWidth;
            if (tPosition > 0) tPosition -= tHalfWidth;
            testimonialManualPauseUntil = performance.now() + 2500;
        }, { passive: false });
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
            testimonialModalOpen = true;
        };

        var closeTestimonialModal = function () {
            testimonialModal.classList.add('hidden');
            testimonialModal.classList.remove('flex');
            testimonialModalOpen = false;
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
