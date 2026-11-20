<section id="top" class="scroll-mt-20 bg-gray">
  <div class="container flex flex-wrap items-center gap-14 px-clamp pb-20 pt-[72px]">
    <div class="flex min-w-0 flex-[1_1_500px] flex-col gap-6">
      <p class="home-eyebrow">Сметководство · Даноци · Финансиско советување</p>
      <h1>Финансиска експертиза со човечка визија и стратегиски пристап.</h1>
      <p class="fs-lead max-w-[540px] text-muted">Сметководство, даноци, трансферни цени и поддршка за ТИРЗ, за компании од стартапи до меѓународни инвеститори во Северна Македонија.</p>
      <div class="flex flex-wrap gap-3 pt-1">
        <a href="{{ home_url('/#kontakt') }}" class="btn btn-primary">Побарајте понуда</a>
        <a href="{{ home_url('/#uslugi') }}" class="btn btn-outline">Нашите услуги</a>
      </div>
    </div>
    <div class="min-w-0 flex-[1_1_440px]">
      {!! wp_get_attachment_image(23, 'full', false, [
          'class' => 'h-[440px] w-full rounded-surface object-cover',
          'alt' => 'Две колешки разгледуваат документи на лаптоп во канцеларија',
          'loading' => 'eager',
          'fetchpriority' => 'high',
      ]) !!}
    </div>
  </div>
</section>
