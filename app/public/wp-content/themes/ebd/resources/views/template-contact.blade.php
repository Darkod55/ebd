{{--
  Template Name: Contact
  Static demo. Placeholder copy only.
  The form is a shell: Alpine stops submit. No admin-post, no email, no storage.
  Later: a page, and a real form plugin if Darko wants one. Fields live on DemoCatalog::contact().
--}}

@extends('layouts.issue')

@section('content')
  @php($contact = \App\DemoCatalog::contact())

  <article class="container grid gap-12 px-clamp py-clamp lg:grid-cols-2">
    <div>
      <p class="issue-kicker">{{ $contact['kicker'] }}</p>
      <h1 class="m-0 mt-4">{{ $contact['title'] }}</h1>
      <p class="text-lg text-muted">{{ $contact['intro'] }}</p>
    </div>

    <form class="grid gap-4 border border-line bg-white p-8" action="#" method="post" @submit.prevent>
      <p class="m-0 text-sm text-muted">Placeholder form. Submission is not wired.</p>

      <label class="grid gap-1 text-sm" for="issue-contact-name">
        Placeholder name
        <input id="issue-contact-name" class="border border-line-strong bg-white px-3 py-3 text-body" type="text" name="name" autocomplete="name">
      </label>

      <label class="grid gap-1 text-sm" for="issue-contact-email">
        Placeholder email
        <input id="issue-contact-email" class="border border-line-strong bg-white px-3 py-3 text-body" type="email" name="email" autocomplete="email">
      </label>

      <label class="grid gap-1 text-sm" for="issue-contact-message">
        Placeholder message
        <textarea id="issue-contact-message" class="min-h-32 border border-line-strong bg-white px-3 py-3 text-body" name="message"></textarea>
      </label>

      <button class="btn btn-primary justify-self-start" type="submit">Send</button>
    </form>
  </article>
@endsection
