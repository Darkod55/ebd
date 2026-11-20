@include('components.header-icons')

@php
  $primaryLinks = [
      ['url' => home_url('/#za-nas'), 'label' => 'За нас'],
      ['url' => home_url('/#uslugi'), 'label' => 'Услуги'],
      ['url' => home_url('/#tehnologija'), 'label' => 'ERP и технологија'],
      ['url' => home_url('/#proces'), 'label' => 'Како работиме'],
      ['url' => home_url('/#prasanja'), 'label' => 'Прашања'],
  ];
  $consultUrl = home_url('/#kontakt');
@endphp

<div class="preheader bg-secondary text-sm text-on-dark">
  <div class="container flex min-h-10 flex-wrap items-center justify-between gap-x-6 gap-y-1 px-clamp">
    <div class="flex flex-wrap gap-x-6">
      <a href="mailto:elitakonsalting@gmail.com" class="py-2 text-on-dark no-underline hover:text-white">elitakonsalting@gmail.com</a>
      <a href="tel:+38971255564" class="py-2 text-on-dark no-underline hover:text-white">+389 71 255 564</a>
    </div>
    <span class="text-on-dark/70">Скопје, Северна Македонија</span>
  </div>
</div>

<header id="main-header" class="site-header sticky top-0 z-30 border-b border-line bg-white" x-data="{ mobileOpen: false }" x-effect="document.body.classList.toggle('overflow-hidden', mobileOpen)">
  <div class="container flex flex-wrap items-center justify-between gap-x-6 gap-y-3 px-clamp py-3">
    <x-brand-lockup :href="home_url('/')" />

    <nav class="hidden items-center gap-x-7 text-sm font-medium lg:flex" aria-label="Главна навигација">
      @foreach ($primaryLinks as $link)
        <a href="{{ $link['url'] }}" class="py-2.5 text-body no-underline hover:text-primary">{{ $link['label'] }}</a>
      @endforeach
      <a href="{{ $consultUrl }}" class="btn btn-primary btn-sm">Закажете консултација</a>
    </nav>

    <button
      type="button"
      class="relative z-[60] shrink-0 text-primary lg:hidden"
      @click="mobileOpen = ! mobileOpen"
      :aria-expanded="mobileOpen"
      :aria-label="mobileOpen ? 'Затвори мени' : 'Отвори мени'"
    >
      <span x-show="! mobileOpen">@svgIcon('menu'|25|25)</span>
      <span class="text-white" x-show="mobileOpen" x-cloak>@svgIcon('close'|25|25)</span>
    </button>
  </div>

  <div
    x-show="mobileOpen"
    x-cloak
    x-transition.opacity
    class="fixed inset-0 z-40 bg-black/50 lg:hidden"
    @click="mobileOpen = false"
  ></div>

  <div
    x-show="mobileOpen"
    x-cloak
    x-transition:enter="duration-300 ease-out"
    x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="duration-200 ease-in"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
    class="fixed inset-0 z-50 flex flex-col overflow-y-auto bg-secondary px-clamp py-4 text-white lg:hidden"
  >
    <div class="flex shrink-0 items-center justify-between gap-6">
      <x-brand-lockup :href="home_url('/')" tone="light" />
      <div class="size-7 shrink-0" aria-hidden="true"></div>
    </div>

    <nav class="mt-8 flex flex-col gap-1 text-base font-medium" aria-label="Главна навигација">
      @foreach ($primaryLinks as $link)
        <a href="{{ $link['url'] }}" class="border-b border-white/10 py-3 text-white no-underline" @click="mobileOpen = false">{{ $link['label'] }}</a>
      @endforeach
      <a href="{{ $consultUrl }}" class="btn btn-white mt-6" @click="mobileOpen = false">Закажете консултација</a>
    </nav>
  </div>
</header>
