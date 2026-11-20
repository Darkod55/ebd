@php
  $stages = [
      [
          'n' => '01',
          'title' => 'Започнувате бизнис',
          'text' => 'За нови компании и претприемачи кои сакаат правилен почеток.',
          'tone' => 'light',
          'items' => [
              'Основање компании',
              'Целосно водење на сметководство',
              'Пресметка на плати и персонален данок',
              'Подготовка и поднесување на даночни пријави',
              'Договори за вработување',
          ],
      ],
      [
          'n' => '02',
          'title' => 'Растете и се развивате',
          'text' => 'За мали и средни претпријатија кои сакаат контрола, ликвидност и подобри одлуки.',
          'tone' => 'dark',
          'items' => [
              'Финансиско планирање и буџетирање',
              'Анализа на ликвидност и контрола на трошоци',
              'Даночно планирање и оптимизација',
              'ERP имплементација и автоматизација',
              'Месечно и годишно известување',
          ],
      ],
      [
          'n' => '03',
          'title' => 'Инвестирате од странство',
          'text' => 'За меѓународни групи, подружници и компании во ТИРЗ-зоните.',
          'tone' => 'light',
          'items' => [
              'Трансферни цени и benchmark анализа',
              'Правна и даночна поддршка во ТИРЗ',
              'Дозволи за престој и работа за странци',
              'Консолидирани извештаи и групни сметки',
              'Двојно оданочување и меѓународни стандарди',
          ],
      ],
  ];
@endphp

<section class="bg-gray" aria-label="Решенија според вашата фаза">
  <div class="container flex flex-col gap-12 px-clamp py-clamp-xl">
    <div class="mw-1000 flex flex-col gap-3.5">
      <p class="home-eyebrow">Решенија според вашата фаза</p>
      <h2 class="h2">Каде се наоѓа вашиот бизнис денес?</h2>
      <p class="fs-lead text-muted">Ги групиравме нашите услуги според тоа што најчесто им е потребно на компаниите во различни фази.</p>
    </div>
    <div class="home-stages">
      @foreach ($stages as $stage)
        <article @class([
          'flex flex-col gap-[18px] rounded-surface p-8',
          'border border-line bg-white' => $stage['tone'] === 'light',
          'bg-secondary text-on-dark' => $stage['tone'] === 'dark',
        ])>
          <p @class([
            'text-xs font-semibold',
            'text-muted' => $stage['tone'] === 'light',
            'text-tertiary-light' => $stage['tone'] === 'dark',
          ])>{{ $stage['n'] }}</p>
          <h3 @class(['text-[22px]', 'text-white' => $stage['tone'] === 'dark'])>{{ $stage['title'] }}</h3>
          <p @class(['text-sm', 'text-muted' => $stage['tone'] === 'light'])>{{ $stage['text'] }}</p>
          <ul @class(['home-checks', 'is-on-dark' => $stage['tone'] === 'dark'])>
            @foreach ($stage['items'] as $item)
              <li>
                <span @class(['text-primary' => $stage['tone'] === 'light', 'text-tertiary-light' => $stage['tone'] === 'dark']) aria-hidden="true">✓</span>
                <span>{{ $item }}</span>
              </li>
            @endforeach
          </ul>
          <a
            href="{{ home_url('/#kontakt') }}"
            @class([
              'btn mt-auto',
              'btn-outline' => $stage['tone'] === 'light',
              'btn-white' => $stage['tone'] === 'dark',
            ])
          >Побарајте понуда</a>
        </article>
      @endforeach
    </div>
  </div>
</section>
