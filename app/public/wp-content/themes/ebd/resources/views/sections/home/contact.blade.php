<section id="kontakt" class="scroll-mt-20">
  <div class="container px-clamp py-clamp-xl">
    <div class="flex flex-wrap items-stretch gap-3 rounded-[28px] bg-secondary p-3">
      <div class="flex min-w-0 flex-[1_1_380px] flex-col gap-6 px-9 py-11">
        <p class="home-eyebrow is-light">Контакт</p>
        <h2 class="h2 text-white">Контактирајте нè денес.</h2>
        <p class="fs-lead max-w-[460px] text-on-dark">Секој бизнис заслужува партнер кој ќе го разбере, ќе го предвиди неговиот раст и ќе му помогне да се движи со сигурност.</p>
        <div class="flex flex-col gap-3 pt-2">
          <a href="mailto:elitakonsalting@gmail.com" class="flex min-h-11 items-center gap-3.5 text-lg font-medium text-white no-underline">
            <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-white/10">
              <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="M3 7l9 6 9-6"></path></svg>
            </span>
            elitakonsalting@gmail.com
          </a>
          <a href="tel:+38971255564" class="flex min-h-11 items-center gap-3.5 text-lg font-medium text-white no-underline">
            <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-white/10">
              <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 3h4l2 5-2.5 1.5a11 11 0 0 0 6 6L16 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 5a2 2 0 0 1 2-2"></path></svg>
            </span>
            +389 71 255 564
          </a>
          <div class="flex min-h-11 items-center gap-3.5 text-lg font-medium text-white">
            <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-white/10">
              <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-7-6.2-7-11.5A7 7 0 0 1 19 9.5C19 14.8 12 21 12 21z"></path><circle cx="12" cy="9.5" r="2.5"></circle></svg>
            </span>
            [АДРЕСА], Скопје
          </div>
        </div>
        <div class="relative mt-auto h-[200px] overflow-hidden rounded-[18px]">
          {!! wp_get_attachment_image(26, 'full', false, [
              'class' => 'absolute inset-0 h-full w-full object-cover',
              'style' => 'height: 100%; width: 100%; object-fit: cover',
              'alt' => 'Работна маса со лаптоп, калкулатор и финансиски извештаи',
          ]) !!}
        </div>
      </div>

      <div id="forma" class="min-w-0 flex-[1_1_520px] rounded-surface bg-white p-6 sm:p-11">
        @if (shortcode_exists('fluentform'))
          {!! do_shortcode('[fluentform id="1"]') !!}
        @endif
      </div>
    </div>
  </div>
</section>
