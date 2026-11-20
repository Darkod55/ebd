<section class="border-t border-line bg-white" aria-label="Placeholder newsletter">
  <div class="container flex flex-wrap items-end justify-between gap-6 px-clamp py-10">
    <div class="max-w-xl">
      <p class="issue-kicker">Placeholder · Newsletter</p>
      <p class="m-0 mt-3 font-heading text-3xl text-secondary">Placeholder newsletter line</p>
    </div>

    {{-- Shell only. Alpine stops the submit. Nothing is stored or sent. --}}
    <form class="flex w-full max-w-md flex-wrap gap-2" action="#" method="post" @submit.prevent>
      <label class="sr-only" for="issue-newsletter">Placeholder email</label>
      <input id="issue-newsletter" class="min-w-0 flex-1 border border-line-strong bg-white px-3 py-3 text-body" type="email" name="email" placeholder="Placeholder email" autocomplete="email">
      <button class="btn btn-primary" type="submit">Join</button>
    </form>
  </div>
</section>
