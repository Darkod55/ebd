@php
    $title = get_the_title($post);
    $hasThumb = has_post_thumbnail($post);
    $dialogId = $dialogId ?? ('mpx-featured-' . $post->ID);
@endphp

<article class="mpx-card mpx-card--image mpx-post-card mpx-featured-card">
    <figure class="wp-block-image mpx-post-card__media mpx-featured-card__media">
        @if ($hasThumb)
            {!! get_the_post_thumbnail($post, 'large', [
                'class' => 'mpx-post-card__image mpx-featured-card__image',
                'alt' => $title,
                'loading' => 'lazy',
            ]) !!}
        @else
            <span
                class="mpx-post-card__placeholder mpx-featured-card__placeholder"
                aria-hidden="true"
            ></span>
        @endif
    </figure>

    <div class="mpx-post-card__footer">
        <button
            type="button"
            class="btn btn-white btn-sm mpx-featured-card__trigger"
            data-mpx-dialog-open="{{ $dialogId }}"
            aria-haspopup="dialog"
            aria-controls="{{ $dialogId }}"
        >
            {{ __('Read more', 'sage') }}
            <span class="sr-only">{{ sprintf(__('about %s', 'sage'), $title) }}</span>
        </button>
    </div>
</article>
