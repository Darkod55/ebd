@php
  $audiences = [
      'Стартапи и нови компании',
      'Мали и средни претпријатија',
      'Големи корпорации',
      'Компании со странски капитал',
      'Меѓународни инвеститори',
      'Компании во ТИРЗ-зони',
      'Трговија',
      'Производство',
      'Финансиски сектор',
  ];
@endphp

<section aria-label="Со кого работиме">
  <div class="container flex flex-wrap items-center gap-x-12 gap-y-6 px-clamp pb-10 pt-[88px]">
    <div class="flex min-w-0 flex-[0_1_300px] flex-col gap-2">
      <p class="home-eyebrow">Со кого работиме</p>
      <p class="h3">Компании од различни индустрии, големини и сопственички структури</p>
    </div>
    <div class="flex min-w-0 flex-[1_1_560px] flex-wrap gap-2.5">
      @foreach ($audiences as $audience)
        <span class="home-chip">{{ $audience }}</span>
      @endforeach
    </div>
  </div>
</section>
