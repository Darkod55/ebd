/**
 * Progressive enhancement for the issue reader.
 * Without this file, every control is still a link or a <details> toggle.
 */
document.addEventListener('alpine:init', () => {
  window.Alpine.data('issueReader', () => ({
    busy: false,
    startX: 0,
    startY: 0,

    init() {
      this.$el.addEventListener('click', (event) => this.onClick(event));
      window.addEventListener('popstate', () => {
        this.go(window.location.href, false);
      });
      this.focusSpread();
    },

    focusSpread() {
      document.getElementById('issue-stage')?.focus({ preventScroll: true });
    },

    reduced() {
      return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    },

    closeOverview() {
      document.getElementById('issue-overview')?.removeAttribute('open');
      document.getElementById('issue-menu')?.removeAttribute('open');
    },

    onKey(event) {
      if (event.altKey || event.metaKey || event.ctrlKey) return;

      const tag = event.target?.tagName;
      if (tag === 'INPUT' || tag === 'TEXTAREA' || event.target?.isContentEditable) return;

      if (event.key === 'Escape') {
        this.closeOverview();
        return;
      }

      if (event.key === 'ArrowRight') {
        event.preventDefault();
        this.follow(document.getElementById('issue-next'));
      }

      if (event.key === 'ArrowLeft') {
        event.preventDefault();
        this.follow(document.getElementById('issue-prev'));
      }
    },

    onTouchStart(event) {
      if (event.touches.length !== 1 || event.target.closest?.('.issue-nav')) {
        this.startX = null;
        return;
      }
      this.startX = event.touches[0].clientX;
      this.startY = event.touches[0].clientY;
    },

    onTouchEnd(event) {
      if (this.startX === null || !event.changedTouches.length) return;
      const dx = event.changedTouches[0].clientX - this.startX;
      const dy = event.changedTouches[0].clientY - this.startY;
      if (Math.abs(dx) < 56 || Math.abs(dx) < Math.abs(dy) * 1.2) return;
      this.follow(document.getElementById(dx < 0 ? 'issue-next' : 'issue-prev'));
    },

    onClick(event) {
      const overview = document.getElementById('issue-overview');
      const menu = document.getElementById('issue-menu');

      if (overview?.open && !overview.contains(event.target)) {
        overview.removeAttribute('open');
      }
      if (menu?.open && !menu.contains(event.target)) {
        menu.removeAttribute('open');
      }

      const link = event.target.closest?.('[data-spread-url]');
      if (!link || !this.$el.contains(link)) return;

      if (link.getAttribute('aria-disabled') === 'true') {
        event.preventDefault();
        return;
      }

      if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || event.button !== 0) return;

      event.preventDefault();
      this.go(link.href, true);
    },

    follow(el) {
      if (!el || el.tagName !== 'A' || el.getAttribute('aria-disabled') === 'true') return;
      const url = el.getAttribute('href');
      if (!url) return;
      this.go(url, true);
    },

    async go(url, push) {
      if (!url || this.busy) return;

      let target;
      try {
        target = new URL(url, window.location.href);
      } catch {
        window.location.assign(url);
        return;
      }

      if (target.href === window.location.href) {
        this.closeOverview();
        return;
      }

      if (this.reduced()) {
        window.location.assign(target.href);
        return;
      }

      this.busy = true;
      this.closeOverview();
      const stage = document.getElementById('issue-stage');
      stage?.classList.add('is-leaving');

      try {
        const response = await fetch(target.href, {
          credentials: 'same-origin',
          headers: { Accept: 'text/html' },
        });

        if (!response.ok) throw new Error(String(response.status));

        const doc = new DOMParser().parseFromString(await response.text(), 'text/html');
        const nextStage = doc.getElementById('issue-stage');

        if (!stage || !nextStage) throw new Error('missing stage');

        await wait(170);
        nextStage.classList.add('is-entering');
        stage.replaceWith(nextStage);
        this.sync(doc);

        if (push) history.pushState({ ebdIssue: true }, '', target.href);

        document.title = doc.title;
        requestAnimationFrame(() => {
          requestAnimationFrame(() => nextStage.classList.remove('is-entering'));
        });
        nextStage.focus({ preventScroll: true });

        const live = document.getElementById('issue-live');
        const heading = nextStage.querySelector('h1');
        if (live && heading) live.textContent = heading.textContent || '';
      } catch {
        window.location.assign(target.href);
      } finally {
        this.busy = false;
      }
    },

    sync(doc) {
      copyInner(doc, 'issue-pager');
      copyInner(doc, 'issue-overview-list');

      const fromSummary = doc.getElementById('issue-progress-btn');
      const summary = document.getElementById('issue-progress-btn');
      if (fromSummary && summary) {
        summary.setAttribute('aria-label', fromSummary.getAttribute('aria-label') || '');
        const fromText = fromSummary.querySelector('#issue-progress');
        const text = summary.querySelector('#issue-progress');
        if (fromText && text) text.textContent = fromText.textContent;
      }

      replaceLinks(doc, 'link[rel="canonical"]', 'canonical');
      replaceLinks(doc, 'link[rel="prev"]', 'prev');
      replaceLinks(doc, 'link[rel="next"]', 'next');

      document.querySelectorAll('link[data-issue-prefetch]').forEach((node) => node.remove());
      doc.querySelectorAll('link[data-issue-prefetch]').forEach((node) => {
        document.head.appendChild(node);
      });
    },
  }));
});

function wait(ms) {
  return new Promise((resolve) => {
    window.setTimeout(resolve, ms);
  });
}

function copyInner(doc, id) {
  const from = doc.getElementById(id);
  const to = document.getElementById(id);
  if (from && to) to.innerHTML = from.innerHTML;
}

function replaceLinks(doc, selector, rel) {
  document.head.querySelector(`link[rel="${rel}"]`)?.remove();
  const next = doc.head.querySelector(selector);
  if (next) document.head.appendChild(next.cloneNode(true));
}
