@php
    $title = get_the_title($post);
    $dialogId = $dialogId ?? ('mpx-featured-' . $post->ID);
    $content = apply_filters('the_content', $post->post_content);
    $readMoreUrl = (string) get_post_meta($post->ID, \App\PostTypes\PostTypes::FEATURED_URL_META, true);
    $readMoreUrl = $readMoreUrl !== '' ? esc_url($readMoreUrl) : '';
@endphp

<dialog
    id="{{ $dialogId }}"
    class="mpx-featured-modal"
    aria-labelledby="{{ $dialogId }}-title"
>
    <div class="mpx-featured-modal__panel">
        <header class="mpx-featured-modal__header">
            <h2 id="{!! $dialogId !!}-title" class="mpx-featured-modal__title h3">
                {!! $title !!}
            </h2>
            <form method="dialog" class="mpx-featured-modal__close-form">
                <button
                    type="submit"
                    class="mpx-featured-modal__close"
                    aria-label="{{ esc_attr__('Close', 'sage') }}"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </form>
        </header>

        <div class="mpx-featured-modal__body entry-content">
            {!! $content !!}
        </div>

        @if ($readMoreUrl !== '')
            <footer class="mpx-featured-modal__footer">
                <a
                    href="{!! $readMoreUrl !!}"
                    class="btn btn-primary"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    {{ __('Read more', 'sage') }}
                    <span class="sr-only">{{ sprintf(__('about %s', 'sage'), $title) }}</span>
                </a>
            </footer>
        @endif
    </div>
</dialog>
