@php
    $sectionPadding = $a['section_padding'] ?? ['py-clamp-xl'];
    if (! is_array($sectionPadding)) {
        $sectionPadding = [$sectionPadding];
    }
    $paddingClasses = implode(' ', array_filter($sectionPadding));

    $bgValue = $a['bg_colour']['value'] ?? 'var(--color-primary)';

    $heroImage = $a['hero_image'] ?? null;
    $heroImageMobile = $a['hero_image_mobile'] ?? null;
    $hasHeroImage = ! empty($heroImage['ID']);
    $hasMobileImage = ! empty($heroImageMobile['ID']);
    $hasAnyImage = $hasHeroImage || $hasMobileImage;
    $hasMobileOverride = $hasHeroImage && $hasMobileImage;

    $clampPositionAxis = static function ($value, float $fallback): float {
        if ($value === '' || $value === null) {
            return $fallback;
        }

        return max(0, min(100, (float) $value));
    };

    $desktopX = $clampPositionAxis($a['image_position_x'] ?? 100, 100);
    $desktopY = $clampPositionAxis($a['image_position_y'] ?? 50, 50);
    $desktopPosition = $desktopX . '% ' . $desktopY . '%';

    $styleVars = [
        '--mpx-hero-v2-scrim: ' . $bgValue,
        '--mpx-hero-v2-pos-desktop: ' . $desktopPosition,
    ];

    if (! empty($a['custom_position_tablet'])) {
        $tabletX = $clampPositionAxis($a['image_position_x_tablet'] ?? null, $desktopX);
        $tabletY = $clampPositionAxis($a['image_position_y_tablet'] ?? null, $desktopY);
        $styleVars[] = '--mpx-hero-v2-pos-tablet: ' . $tabletX . '% ' . $tabletY . '%';
    }

    if (! empty($a['custom_position_mobile'])) {
        $mobileX = $clampPositionAxis($a['image_position_x_mobile'] ?? null, $desktopX);
        $mobileY = $clampPositionAxis($a['image_position_y_mobile'] ?? null, $desktopY);
        $styleVars[] = '--mpx-hero-v2-pos-mobile: ' . $mobileX . '% ' . $mobileY . '%';
    }

    $styleAttr = implode('; ', $styleVars);

    $template = [
        ['mpx/partial-subheading', [], [
            ['core/paragraph', [
                'content' => 'Work with Chris',
                'placeholder' => 'Add a short label',
            ]],
        ]],
        ['core/heading', [
            'level' => 1,
            'content' => 'Breakthrough Your Fear',
            'placeholder' => 'Add a heading',
        ]],
        ['core/paragraph', [
            'content' => 'Overcome fear, phobias and anxiety — rapid change without exposure or years of therapy.',
            'placeholder' => 'Add supporting text',
        ]],
        ['mpx/partial-button', [], [
            ['core/button', [
                'text' => 'BOOK YOUR CLARITY CALL',
                'blockstudio' => [
                    'attributes' => [
                        'button_type' => 'btn-white',
                    ],
                ],
            ]],
        ]],
    ];

    $anchorId = $a['anchor'] ?? $b['anchor'] ?? '';
@endphp

<section
    useBlockProps
    @if ($anchorId !== '') id="{{ $anchorId }}" @endif
    class="mpx-hero-v2 relative overflow-hidden text-white bs-block{{ $hasMobileOverride ? ' mpx-hero-v2--has-mobile-image' : '' }}"
    style="{{ esc_attr($styleAttr) }}"
>
    <div class="mpx-hero-v2__media" @if (! $hasAnyImage) aria-hidden="true" @endif>
        @if ($hasHeroImage)
            {!! wp_get_attachment_image($heroImage['ID'], 'full', false, [
                'class' => 'mpx-hero-v2__image' . ($hasMobileOverride ? ' mpx-hero-v2__image--desktop' : ''),
                'alt' => $heroImage['alt'] ?? '',
                'loading' => 'eager',
                'fetchpriority' => 'high',
            ]) !!}
        @endif

        @if ($hasMobileImage)
            {!! wp_get_attachment_image($heroImageMobile['ID'], 'full', false, [
                'class' => 'mpx-hero-v2__image' . ($hasMobileOverride ? ' mpx-hero-v2__image--mobile' : ''),
                'alt' => $heroImageMobile['alt'] ?? '',
                'loading' => 'eager',
            ]) !!}
        @endif

        @if (! $hasAnyImage && ! empty($isEditor))
            <div class="mpx-hero-v2__placeholder">
                {{ __('Select a background image in the block sidebar.', 'sage') }}
            </div>
        @endif

        <div class="mpx-hero-v2__scrim" aria-hidden="true"></div>
    </div>

    <div class="mpx-hero-v2__foreground px-clamp {{ $paddingClasses }}">
        <div class="container">
            <div class="mpx-hero-v2__content">
                <InnerBlocks
                    allowedBlocks="{!! esc_attr(wp_json_encode(['mpx/partial-subheading', 'core/heading', 'core/paragraph', 'mpx/partial-button'])) !!}"
                    template="{!! esc_attr(wp_json_encode($template)) !!}"
                />
            </div>
        </div>
    </div>
</section>
