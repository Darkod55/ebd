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
    $cardBg = $a['bg_colour']['value'] ?? 'var(--color-tertiary)';
    $fillRow = (bool) ($a['fill_row'] ?? false);
    $enableSlider = (bool) ($a['enable_slider'] ?? false);
    $autoplay = $enableSlider && (bool) ($a['autoplay'] ?? false);
    $isEditorView = (bool) ($isEditor ?? false);

    // Editor (+ non-slider frontend): wrapping grid. When slider is on in the
    // editor, column counts follow slides-per-view so layout matches intent.
    if ($enableSlider && $isEditorView) {
        $minDesktop = $helpers->resolveGridTrackMin((string) $slidesDesktop, $gapColDesktop);
        $minTablet = $helpers->resolveGridTrackMin((string) $slidesTablet, $gapSmall);
        $minMobile = $helpers->resolveGridTrackMin('1', $gapSmall);
    } else {
        $minDesktop = $helpers->resolveGridTrackMin((string) ($grid['cols_desktop'] ?? '50%'), $gapColDesktop);
        $minTablet = $helpers->resolveGridTrackMin((string) ($grid['cols_tablet'] ?? '50%'), $gapSmall);
        $minMobile = $helpers->resolveGridTrackMin((string) ($grid['cols_mobile'] ?? '100%'), $gapSmall);
    }

    $allowedBlocks = [
        'mpx/partial-card',
        'mpx/partial-card-icon',
        'mpx/partial-card-image',
        'mpx/partial-card-testimonial-simple',
        'mpx/partial-card-testimonial-image',
        'mpx/partial-button',
    ];

    $template = [
        ['mpx/partial-card', [], [
            ['core/paragraph', [
                'placeholder' => 'Add card text',
            ]],
        ]],
        ['mpx/partial-card', [], [
            ['core/paragraph', [
                'placeholder' => 'Add card text',
            ]],
        ]],
    ];

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
        $useAlpineSlider ? 'mpx-cards--slider' : 'grid-auto-cards grid-auto-cards-gap',
        (! $useAlpineSlider && $fillRow) ? 'is-fill-row' : null,
        $useGradient ? 'mpx-cards--gradient' : null,
    ])));
@endphp

<div
    useBlockProps
    class="{{ $rootClasses }}"
    style="{!! esc_attr($gridStyle) !!}"
    @if ($useAlpineSlider)
        x-data="mpxCardsSlider({ autoplay: {{ $autoplay ? 'true' : 'false' }} })"
    @endif
>
    @if ($useAlpineSlider)
        <div class="mpx-cards-slider">
            <div class="mpx-cards-slider__viewport">
                <button
                    type="button"
                    class="mpx-cards-slider__arrow mpx-cards-slider__arrow--prev"
                    x-ref="prevBtn"
                    x-on:click="prev()"
                    hidden
                    aria-label="{{ esc_attr__('Previous cards', 'sage') }}"
                >
                    <span aria-hidden="true">{!! \App\helpers()->getSvg(['icon' => 'chevron-left', 'width' => 24, 'title' => '']) !!}</span>
                </button>

                <div
                    class="mpx-cards-slider__track"
                    x-ref="track"
                    x-on:scroll.passive="update"
                >
                    <InnerBlocks
                        allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
                        template="{!! esc_attr(wp_json_encode($template)) !!}"
                    />
                </div>

                <button
                    type="button"
                    class="mpx-cards-slider__arrow mpx-cards-slider__arrow--next"
                    x-ref="nextBtn"
                    x-on:click="next()"
                    hidden
                    aria-label="{{ esc_attr__('Next cards', 'sage') }}"
                >
                    <span aria-hidden="true">{!! \App\helpers()->getSvg(['icon' => 'chevron-right', 'width' => 24, 'title' => '']) !!}</span>
                </button>
            </div>

            {{-- Dots are built in JS (Blockstudio DOMDocument mangles <template x-for>). --}}
            <nav
                class="mpx-cards-slider__dots"
                x-ref="dots"
                aria-label="{{ esc_attr__('Card slides', 'sage') }}"
            ></nav>
        </div>
    @else
        <InnerBlocks
            allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
            template="{!! esc_attr(wp_json_encode($template)) !!}"
        />
    @endif
</div>
