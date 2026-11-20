import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
  Alpine.data('mpxCardsSlider', (config = {}) => ({
    pages: 1,
    active: 0,
    slidesPerView: 1,
    autoplay: Boolean(config?.autoplay),
    autoplayOnView: Boolean(config?.autoplayOnView),
    intervalMs: 5000,
    direction: 1,
    _paused: false,
    _timer: null,
    _ro: null,
    _io: null,
    _autoplayReady: false,
    _mqlDesktop: null,
    _mqlTablet: null,
    _onPause: null,
    _onResume: null,
    _onPointerUp: null,

    init() {
      this._mqlDesktop = window.matchMedia('(min-width: 64rem)');
      this._mqlTablet = window.matchMedia('(min-width: 48rem)');
      const onBreakpoint = () => this.update();
      this._mqlDesktop.addEventListener?.('change', onBreakpoint);
      this._mqlTablet.addEventListener?.('change', onBreakpoint);

      this.$nextTick(() => {
        this.update();
        if (typeof ResizeObserver !== 'undefined' && this.$refs.track) {
          this._ro = new ResizeObserver(() => this.update());
          this._ro.observe(this.$refs.track);
        }
        this.setupAutoplay();
      });
    },

    destroy() {
      this.stopAutoplay();
      this._io?.disconnect();
      this._ro?.disconnect();
      if (this._onPause && this._onResume) {
        this.$el.removeEventListener('mouseenter', this._onPause);
        this.$el.removeEventListener('mouseleave', this._onResume);
        this.$el.removeEventListener('focusin', this._onPause);
        this.$el.removeEventListener('focusout', this._onResume);
        this.$refs.track?.removeEventListener('pointerdown', this._onPause);
        window.removeEventListener('pointerup', this._onPointerUp);
        window.removeEventListener('pointercancel', this._onPointerUp);
      }
    },

    setupAutoplay() {
      if (! this.autoplay) return;
      if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

      this._onPause = () => {
        this._paused = true;
      };
      this._onResume = () => {
        this._paused = false;
      };
      // Touch has no hover — resume after the gesture ends unless still hovered.
      this._onPointerUp = () => {
        if (! this.$el.matches(':hover')) {
          this._paused = false;
        }
      };

      this.$el.addEventListener('mouseenter', this._onPause);
      this.$el.addEventListener('mouseleave', this._onResume);
      this.$el.addEventListener('focusin', this._onPause);
      this.$el.addEventListener('focusout', (event) => {
        if (! this.$el.contains(event.relatedTarget)) {
          this._paused = false;
        }
      });
      this.$refs.track?.addEventListener('pointerdown', this._onPause);
      window.addEventListener('pointerup', this._onPointerUp);
      window.addEventListener('pointercancel', this._onPointerUp);

      if (this.autoplayOnView && typeof IntersectionObserver !== 'undefined') {
        this._io = new IntersectionObserver((entries) => {
          if (! entries.some((entry) => entry.isIntersecting)) {
            return;
          }

          this._autoplayReady = true;
          this.startAutoplay();
          this._io?.disconnect();
          this._io = null;
        }, { threshold: 0.2 });
        this._io.observe(this.$el);
        return;
      }

      this._autoplayReady = true;
      this.startAutoplay();
    },

    startAutoplay() {
      this.stopAutoplay();
      if (! this.autoplay || this.pages <= 1) return;
      if (this.autoplayOnView && ! this._autoplayReady) return;

      this._timer = window.setInterval(() => {
        if (! this._paused) {
          this.advance();
        }
      }, this.intervalMs);
    },

    stopAutoplay() {
      if (this._timer != null) {
        window.clearInterval(this._timer);
        this._timer = null;
      }
    },

    /**
     * Step forward/back; reverse direction at either end (ping-pong).
     * Avoids cloning slides for a seamless loop with scroll-snap.
     */
    advance() {
      if (this.pages <= 1) return;

      let next = this.active + this.direction;

      if (next >= this.pages) {
        this.direction = -1;
        next = this.active - 1;
      } else if (next < 0) {
        this.direction = 1;
        next = this.active + 1;
      }

      if (next !== this.active) {
        this.goTo(next);
      }
    },

    readSlidesPerView() {
      const root = this.$el;
      const styles = getComputedStyle(root);
      const desktop = parseInt(styles.getPropertyValue('--mpx-slides-desktop'), 10) || 4;
      const tablet = parseInt(styles.getPropertyValue('--mpx-slides-tablet'), 10) || 2;
      const mobile = parseInt(styles.getPropertyValue('--mpx-slides-mobile'), 10) || 1;

      // lg ≥ 64rem → desktop; md ≥ 48rem (and below lg) → tablet; else mobile.
      if (this._mqlDesktop?.matches) {
        this.slidesPerView = Math.max(1, desktop);
      } else if (this._mqlTablet?.matches) {
        this.slidesPerView = Math.max(1, tablet);
      } else {
        this.slidesPerView = Math.max(1, mobile);
      }

      // Write the active count onto the element so card width calc updates.
      // Avoids Blockstudio CSS media-query reordering fighting the theme CSS.
      root.style.setProperty('--mpx-slides', String(this.slidesPerView));
    },

    cards() {
      const track = this.$refs.track;
      if (! track) return [];
      return [...track.querySelectorAll(':scope > *')];
    },

    /**
     * Scroll distance for one card (always advance by a single slide,
     * even when several are visible).
     */
    slideStep() {
      const track = this.$refs.track;
      const card = track?.querySelector(':scope > *');
      if (! track || ! card) return 0;

      const styles = getComputedStyle(track);
      const gap = parseFloat(styles.columnGap || styles.gap || '0') || 0;
      return card.getBoundingClientRect().width + gap;
    },

    update() {
      const track = this.$refs.track;
      if (! track) return;

      this.readSlidesPerView();
      const count = this.cards().length;
      // Positions = how far you can shift by one card while keeping N visible.
      const pages = Math.max(1, count - this.slidesPerView + 1);
      const pagesChanged = pages !== this.pages;
      this.pages = pages;

      const step = this.slideStep();
      let active = step > 0 ? Math.round(track.scrollLeft / step) : 0;
      active = Math.max(0, Math.min(active, this.pages - 1));
      this.active = active;

      this.renderDots();

      if (pagesChanged && this.autoplay) {
        this.startAutoplay();
      }
    },

    goTo(index) {
      const track = this.$refs.track;
      if (! track) return;

      const target = Math.max(0, Math.min(index, this.pages - 1));
      track.scrollTo({ left: target * this.slideStep(), behavior: 'smooth' });
    },

    prev() {
      if (this.active <= 0) return;
      this.direction = -1;
      this.goTo(this.active - 1);
    },

    next() {
      if (this.active >= this.pages - 1) return;
      this.direction = 1;
      this.goTo(this.active + 1);
    },

    syncChrome() {
      const multi = this.pages > 1;
      const nav = this.$refs.dots;
      if (nav) {
        nav.hidden = ! multi;
      }

      const viewport = this.$refs.track?.closest('.mpx-cards-slider__viewport');
      viewport?.classList.toggle('has-arrows', multi);

      const prevBtn = this.$refs.prevBtn;
      const nextBtn = this.$refs.nextBtn;
      if (prevBtn) {
        prevBtn.hidden = ! multi;
        prevBtn.disabled = this.active <= 0;
      }
      if (nextBtn) {
        nextBtn.hidden = ! multi;
        nextBtn.disabled = this.active >= this.pages - 1;
      }
    },

    renderDots() {
      const nav = this.$refs.dots;
      this.syncChrome();
      if (! nav) return;

      // One page fills the track — no pagination chrome needed.
      if (this.pages <= 1) {
        nav.replaceChildren();
        return;
      }

      const existing = nav.querySelectorAll('.mpx-cards-slider__dot');
      if (existing.length === this.pages) {
        existing.forEach((btn, i) => {
          const on = i === this.active;
          btn.classList.toggle('is-active', on);
          if (on) {
            btn.setAttribute('aria-current', 'true');
          } else {
            btn.removeAttribute('aria-current');
          }
        });
        return;
      }

      nav.replaceChildren();

      for (let i = 0; i < this.pages; i++) {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'mpx-cards-slider__dot' + (i === this.active ? ' is-active' : '');
        btn.setAttribute('aria-label', `Go to slide ${i + 1}`);
        if (i === this.active) {
          btn.setAttribute('aria-current', 'true');
        }
        btn.addEventListener('click', () => this.goTo(i));
        nav.appendChild(btn);
      }
    },
  }));
});

/**
 * Featured Posts: open native <dialog> from card Read more buttons.
 * Uses the top layer so overflow on the cards track does not clip the modal.
 */
function pauseFeaturedModalMedia(root) {
  root.querySelectorAll('video, audio').forEach((media) => {
    media.pause();
    // Chrome can keep decoding/buffering after pause inside a closed dialog.
    try {
      media.currentTime = 0;
    } catch (_) {
      /* ignore unseekable streams */
    }
  });

  // Same-src iframe reloads are a no-op in Chrome; blanking stops playback.
  root.querySelectorAll('iframe').forEach((iframe) => {
    const src = iframe.getAttribute('src') || iframe.dataset.mpxSrc || '';
    if (!src || src === 'about:blank') {
      return;
    }

    iframe.dataset.mpxSrc = src;

    // Best-effort pause before tear-down (works when the provider allows it).
    try {
      iframe.contentWindow?.postMessage(
        JSON.stringify({ event: 'command', func: 'pauseVideo', args: [] }),
        '*',
      );
      iframe.contentWindow?.postMessage(
        JSON.stringify({ method: 'pause' }),
        '*',
      );
    } catch (_) {
      /* cross-origin */
    }

    iframe.setAttribute('src', 'about:blank');
  });
}

function restoreFeaturedModalMedia(root) {
  root.querySelectorAll('iframe[data-mpx-src]').forEach((iframe) => {
    const src = iframe.dataset.mpxSrc;
    if (src && iframe.getAttribute('src') === 'about:blank') {
      iframe.setAttribute('src', src);
    }
  });
}

document.addEventListener('click', (event) => {
  const trigger = event.target.closest('[data-mpx-dialog-open]');
  if (trigger) {
    const id = trigger.getAttribute('data-mpx-dialog-open');
    const dialog = id ? document.getElementById(id) : null;
    if (dialog && typeof dialog.showModal === 'function') {
      event.preventDefault();
      restoreFeaturedModalMedia(dialog);
      dialog.showModal();
    }
    return;
  }

  // Backdrop click closes (target is the <dialog> itself, not the panel).
  if (
    event.target instanceof HTMLDialogElement
    && event.target.classList.contains('mpx-featured-modal')
  ) {
    event.target.close();
  }
});

document.querySelectorAll('dialog.mpx-featured-modal').forEach((dialog) => {
  dialog.addEventListener('close', () => {
    pauseFeaturedModalMedia(dialog);
  });
});

Alpine.start();

if (window.scrollY > 0) document.body.classList.add('scrolled');
window.addEventListener('scroll',() => window.scrollY > 0 ? document.body.classList.add('scrolled') : document.body.classList.remove('scrolled'));

/**
 * Preheader + main header height for full-viewport heroes (Hero V2).
 * Preheader is display:none below lg, so mobile only subtracts the sticky bar.
 */
function syncSiteChromeHeight() {
  const preheader = document.querySelector('.preheader');
  const header = document.getElementById('main-header');
  let height = 0;

  if (preheader && getComputedStyle(preheader).display !== 'none') {
    height += preheader.getBoundingClientRect().height;
  }

  if (header) {
    height += header.getBoundingClientRect().height;
  }

  document.documentElement.style.setProperty('--site-chrome-height', `${Math.round(height)}px`);
}

/**
 * Partners marquee: fill the viewport with cloned groups (avoids empty
 * teal when the logo set is narrower than the screen), then set pixel
 * shift + duration from the first group width.
 * Percentage translateX is unreliable with width:max-content on iOS.
 */
function syncPartnersMarqueeShift() {
  const pxPerSecond = window.matchMedia('(max-width: 767px)').matches ? 55 : 45;
  const minTrackWidth = Math.max(window.innerWidth, document.documentElement.clientWidth) * 2;

  document.querySelectorAll('.mpx-partners-slider .wp-block-gallery[data-mpx-marquee="true"]').forEach((gallery) => {
    const groups = [...gallery.querySelectorAll(':scope > .mpx-partners-group')];
    const source = groups[0];
    if (!source) return;

    // Reset to a single source group, then rebuild clones for this viewport.
    groups.slice(1).forEach((group) => group.remove());

    const firstClone = source.cloneNode(true);
    firstClone.setAttribute('aria-hidden', 'true');
    gallery.appendChild(firstClone);

    // Keep cloning until the track covers 2× viewport (seamless + no gap).
    let guard = 0;
    while (gallery.scrollWidth < minTrackWidth && guard < 12) {
      const extra = source.cloneNode(true);
      extra.setAttribute('aria-hidden', 'true');
      gallery.appendChild(extra);
      guard += 1;
    }

    const width = source.getBoundingClientRect().width;
    if (width <= 0) return;

    gallery.style.setProperty('--mpx-partners-shift', `-${width}px`);
    gallery.style.setProperty('--mpx-partners-duration', `${Math.max(width / pxPerSecond, 12)}s`);
  });
}

function syncLayoutMetrics() {
  syncSiteChromeHeight();
  syncPartnersMarqueeShift();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', syncLayoutMetrics, { once: true });
} else {
  syncLayoutMetrics();
}

window.addEventListener('load', syncLayoutMetrics);
window.addEventListener('resize', syncLayoutMetrics);
