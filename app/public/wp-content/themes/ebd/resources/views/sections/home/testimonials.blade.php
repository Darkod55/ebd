@php
  $quotes = [
      [
          'initials' => 'ВЃ',
          'name' => 'Васка Ѓорчевска',
          'role' => 'Vitillo Group',
          'quote' => '„Постојано ме воодушевуваше нејзиниот професионализам, вниманието на детали и силните аналитички вештини. Елита одигра клучна улога во управувањето со нашите финансиски евиденции. Нејзиниот интегритет и работна етика поставија стандард за целиот наш тим.“',
      ],
      [
          'initials' => 'МС',
          'name' => 'Марина Стојановска',
          'role' => 'CEO, Extrabis',
          'quote' => '„Соработувам со Елита повеќе од 2 години. Нејзиното длабоко познавање на ERP системите беше од непроценливо значење за поефикасно управување со нашите финансиски процеси. Топло ги препорачувам нејзините услуги.“',
      ],
      [
          'initials' => 'МП',
          'name' => 'Марија Петреска',
          'role' => 'Vitillo Group',
          'quote' => '„Таа секогаш ја гледа големата слика во секоја ситуација и знае како да ги процени и поврзе процесите во рамки на организацијата за да постигне најдобра оптимизација.“',
      ],
      [
          'initials' => 'ЉС',
          'name' => 'Љупчо Стојановски',
          'role' => 'Менаџер на продажба',
          'quote' => '„Задоволство е да се соработува со Елита. Комуникацијата е лесна, а таа секогаш има решенија и трпеливост за секој предизвик. Ја сметам за една од најдобрите професионалци во својата област во нашата земја.“',
      ],
  ];
@endphp

<section id="preporaki" class="scroll-mt-20 bg-gray">
  <div class="container flex flex-col gap-11 px-clamp py-clamp-xl">
    <div class="mw-1000 flex flex-col gap-3.5">
      <p class="home-eyebrow">Што велат клиентите</p>
      <h2 class="h2">Реални гласови. Реални резултати.</h2>
    </div>
    <div class="home-quotes">
      @foreach ($quotes as $quote)
        <figure class="m-0 flex flex-col gap-5 rounded-surface border border-line bg-white p-[30px]">
          <blockquote class="text-base leading-relaxed">{{ $quote['quote'] }}</blockquote>
          <figcaption class="mt-auto flex items-center gap-3">
            <span class="flex size-11 items-center justify-center rounded-full bg-light font-heading text-[15px] font-bold text-primary" aria-hidden="true">{{ $quote['initials'] }}</span>
            <span class="flex flex-col">
              <span class="font-semibold text-secondary">{{ $quote['name'] }}</span>
              <span class="text-sm text-muted">{{ $quote['role'] }}</span>
            </span>
          </figcaption>
        </figure>
      @endforeach
    </div>
  </div>
</section>
