<footer class="site-footer border-t border-line bg-white">
  <div class="container flex flex-wrap items-center justify-between gap-4 px-clamp py-8 text-sm text-muted">
    <x-brand-lockup :href="home_url('/')" mark-class="h-7 w-12 shrink-0" word-class="font-heading text-base font-bold" />

    <div class="flex flex-wrap items-center gap-x-7 gap-y-3">
      <p>© {{ date('Y') }} Елита Консалтинг. Скопје, Северна Македонија.</p>
      @if (has_nav_menu('social_navigation'))
        <nav aria-label="{{ wp_get_nav_menu_name('social_navigation') }}">
          {!! wp_nav_menu([
            'theme_location' => 'social_navigation',
            'menu_class' => 'footer-social m-0 flex flex-wrap items-center gap-2',
            'container' => false,
            'depth' => 1,
            'echo' => false,
          ]) !!}
        </nav>
      @endif
    </div>
  </div>
</footer>
