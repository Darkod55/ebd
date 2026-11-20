{{-- Sprite for editor iframe (layouts also include it on the frontend). --}}
@include('components.footer-icons')

@php
    $grid = function_exists('bs_get_group') ? bs_get_group($a, 'grid_controls') : [];
    $gapColDesktop = $grid['gap_col_desktop'] ?: '20px';
    $gapRowDesktop = $grid['gap_row_desktop'] ?: '20px';
    $gapSmall = '20px';

    $helpers = \App\helpers();

    $resolveSlides = static function ($value, int $fallback): int {
        if (is_array($value)) {
            $value = $value['value'] ?? $fallback;
        }
        $n = (int) $value;

        return max(1, min(6, $n ?: $fallback));
    };

    $slidesDesktop = $resolveSlides($a['slides_desktop'] ?? 4, 4);
    $slidesTablet = $resolveSlides($a['slides_tablet'] ?? 2, 2);

    $useGradient = (bool) ($a['use_gradient_bg'] ?? false);
    $cardBg = $a['bg_colour']['value'] ?? 'var(--color-primary)';
    $enableSlider = (bool) ($a['enable_slider'] ?? true);
    $autoplay = $enableSlider && (bool) ($a['autoplay'] ?? false);
    $isEditorView = (bool) ($isEditor ?? false);

    if ($enableSlider && $isEditorView) {
        // Editor preview: always show a wrapping N-column grid (default 4).
        $editorCols = (string) $slidesDesktop;
        $minDesktop = $helpers->resolveGridTrackMin($editorCols, $gapColDesktop);
        $minTablet = $helpers->resolveGridTrackMin($editorCols, $gapSmall);
        $minMobile = $helpers->resolveGridTrackMin($editorCols, $gapSmall);
    } else {
        $minDesktop = $helpers->resolveGridTrackMin((string) ($grid['cols_desktop'] ?? '25%'), $gapColDesktop);
        $minTablet = $helpers->resolveGridTrackMin((string) ($grid['cols_tablet'] ?? '50%'), $gapSmall);
        $minMobile = $helpers->resolveGridTrackMin((string) ($grid['cols_mobile'] ?? '100%'), $gapSmall);
    }

    $posts = get_posts([
        'post_type' => 'featured-post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'menu_order date',
        'order' => 'ASC',
        'no_found_rows' => true,
    ]);

    $gridStyleParts = [
        "--grid-min-desktop: {$minDesktop}",
        "--grid-min-tablet: {$minTablet}",
        "--grid-min-mobile: {$minMobile}",
        "--grid-gap-col: {$gapColDesktop}",
        "--grid-gap-row: {$gapRowDesktop}",
        "--mpx-slides-desktop: {$slidesDesktop}",
        "--mpx-slides-tablet: {$slidesTablet}",
        '--mpx-slides-mobile: 1',
    ];

    if (! $useGradient) {
        $gridStyleParts[] = "--mpx-card-bg: {$cardBg}";
    }

    $gridStyle = implode('; ', $gridStyleParts);

    $useAlpineSlider = $enableSlider && ! $isEditorView;

    $rootClasses = trim(implode(' ', array_filter([
        'mpx-cards',
        'mpx-featured-posts',
        $useAlpineSlider ? 'mpx-cards--slider' : 'grid-auto-cards grid-auto-cards-gap',
        $useGradient ? 'mpx-cards--gradient' : null,
    ])));

    $uid = 'mpx-fp-' . wp_unique_id();
@endphp

<div
    useBlockProps
    class="{{ $rootClasses }}"
    style="{!! esc_attr($gridStyle) !!}"
    @if ($useAlpineSlider)
        x-data="mpxCardsSlider({ autoplay: {{ $autoplay ? 'true' : 'false' }}, autoplayOnView: true })"
    @endif
>
    @if (empty($posts))
        <p class="mpx-featured-posts__empty text-center opacity-70">
            {{ __('No featured posts yet. Add some under Featured Posts in the admin.', 'sage') }}
        </p>
    @elseif ($useAlpineSlider)
        <div class="mpx-cards-slider">
            <div class="mpx-cards-slider__viewport">
                <button
                    type="button"
                    class="mpx-cards-slider__arrow mpx-cards-slider__arrow--prev"
                    x-ref="prevBtn"
                    x-on:click="prev()"
                    hidden
                    aria-label="{{ esc_attr__('Previous featured posts', 'sage') }}"
                >
                    <span aria-hidden="true">{!! \App\helpers()->getSvg(['icon' => 'chevron-left', 'width' => 24, 'title' => '']) !!}</span>
                </button>

                <div
                    class="mpx-cards-slider__track"
                    x-ref="track"
                    x-on:scroll.passive="update"
                >
                    @foreach ($posts as $post)
                        @include('partials.featured-post-card', [
                            'post' => $post,
                            'dialogId' => $uid . '-' . $post->ID,
                        ])
                    @endforeach
                </div>

                <button
                    type="button"
                    class="mpx-cards-slider__arrow mpx-cards-slider__arrow--next"
                    x-ref="nextBtn"
                    x-on:click="next()"
                    hidden
                    aria-label="{{ esc_attr__('Next featured posts', 'sage') }}"
                >
                    <span aria-hidden="true">{!! \App\helpers()->getSvg(['icon' => 'chevron-right', 'width' => 24, 'title' => '']) !!}</span>
                </button>
            </div>

            <nav
                class="mpx-cards-slider__dots"
                x-ref="dots"
                aria-label="{{ esc_attr__('Featured post slides', 'sage') }}"
            ></nav>
        </div>
    @else
        @foreach ($posts as $post)
            @include('partials.featured-post-card', [
                'post' => $post,
                'dialogId' => $uid . '-' . $post->ID,
            ])
        @endforeach
    @endif

    @foreach ($posts as $post)
        @include('partials.featured-post-modal', [
            'post' => $post,
            'dialogId' => $uid . '-' . $post->ID,
        ])
    @endforeach
</div>
