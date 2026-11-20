@php
  $platforms = ['Oracle', 'MS Dynamics NAV', 'Odoo', 'е-ПДД'];
  $points = [
      'ERP имплементација и подобрување на процеси',
      'Автоматизација на финансиски извештаи',
      'Контрола на трошоци и управување со ризици',
  ];
@endphp

<section id="tehnologija" class="scroll-mt-20 bg-secondary text-on-dark">
  <div class="container flex flex-wrap items-center gap-14 px-clamp py-clamp-xl">
    <div class="min-w-0 flex-[1_1_420px]">
      {!! wp_get_attachment_image(25, 'full', false, [
          'class' => 'h-[440px] w-full rounded-surface object-cover',
          'style' => 'height: 440px; object-fit: cover',
          'alt' => 'Елита Билбилоска Панова работи на лаптоп во канцеларија',
      ]) !!}
    </div>
    <div class="flex min-w-0 flex-[1_1_500px] flex-col gap-[22px]">
      <p class="home-eyebrow is-light">Финансии и технологија</p>
      <h2 class="h2 text-white">Дигитално работење, со системите што веќе ги користите.</h2>
      <p class="fs-lead">Како процесен консултант, помагаме компаниите да ги искористат своите ERP системи за поефикасно управување со финансиските процеси, контрола на трошоци и автоматизирани извештаи.</p>
      <div class="flex flex-wrap gap-2.5">
        @foreach ($platforms as $platform)
          <span class="home-chip is-dark">{{ $platform }}</span>
        @endforeach
      </div>
      <div class="flex flex-col gap-3 pt-1.5">
        @foreach ($points as $point)
          <div class="flex items-start gap-3.5">
            <span class="flex size-7 shrink-0 items-center justify-center rounded-lg bg-tertiary-light/20 font-bold text-tertiary-light" aria-hidden="true">✓</span>
            <span class="text-white">{{ $point }}</span>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
