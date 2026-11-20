@php
  $steps = [
      ['n' => 'Чекор 1', 'title' => 'Прв разговор', 'text' => 'Ја запознаваме вашата дејност, обемот на работа и целите.'],
      ['n' => 'Чекор 2', 'title' => 'Анализа', 'text' => 'Ги разгледуваме постојните евиденции, процеси и ризици.'],
      ['n' => 'Чекор 3', 'title' => 'Понуда', 'text' => 'Предлагаме обем на услуги прилагоден на вашите потреби.'],
      ['n' => 'Чекор 4', 'title' => 'Преземање', 'text' => 'Ги преземаме евиденциите и ги усогласуваме отворените ставки.'],
      ['n' => 'Чекор 5', 'title' => 'Тековна поддршка', 'text' => 'Месечно известување, советување и следење на законските измени.'],
  ];
  $prep = [
      'Краток опис на дејноста',
      'Приближен месечен обем на документи',
      'Број на вработени',
      'Дали сте ДДВ обврзник',
      'Дали имате поврзани лица во странство',
      'Ако менувате сметководител: до кога е обработено',
  ];
@endphp

<section id="proces" class="scroll-mt-20">
  <div class="container flex flex-col gap-12 px-clamp py-clamp-xl">
    <div class="mw-1000 flex flex-col gap-3.5">
      <p class="home-eyebrow">Како работиме</p>
      <h2 class="h2">Од првиот разговор до стабилна соработка</h2>
    </div>
    <div class="home-steps">
      @foreach ($steps as $step)
        <div class="flex flex-col gap-2 border-t-[3px] border-primary pt-5">
          <p class="font-heading text-[15px] font-extrabold text-primary">{{ $step['n'] }}</p>
          <p class="font-heading text-lg font-bold text-secondary">{{ $step['title'] }}</p>
          <p class="text-sm text-muted">{{ $step['text'] }}</p>
        </div>
      @endforeach
    </div>
    <div class="flex flex-wrap gap-x-12 gap-y-6 rounded-surface bg-gray p-6 sm:p-10">
      <div class="flex min-w-0 flex-[1_1_300px] flex-col gap-2.5">
        <h3 class="text-[22px]">Како да се подготвите за првиот разговор</h3>
        <p class="text-sm text-muted">Ако ги имате овие информации при рака, првиот разговор ќе биде многу покорисен.</p>
      </div>
      <ul class="home-checks is-two min-w-0 flex-[2_1_520px]">
        @foreach ($prep as $item)
          <li>
            <span class="text-primary" aria-hidden="true">✓</span>
            <span>{{ $item }}</span>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
</section>
