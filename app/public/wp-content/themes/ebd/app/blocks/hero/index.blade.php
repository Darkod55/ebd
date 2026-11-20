@php
    $sectionPadding = $a['section_padding'] ?? ['py-clamp-xl'];
    if (! is_array($sectionPadding)) {
        $sectionPadding = [$sectionPadding];
    }
    $paddingClasses = implode(' ', array_filter($sectionPadding));

    $bgClass = $a['bg_colour']['slug'] ?? 'bg-primary';
    $bgValue = $a['bg_colour']['value'] ?? 'var(--color-primary)';

    $heroImage = $a['hero_image'] ?? null;
    $hasHeroImage = ! empty($heroImage['ID']);
    $showOverlay = (bool) ($a['show_overlay'] ?? true);

    $template = [
        ['core/heading', [
            'level' => 1,
            'content' => 'Breakthrough Your Fear',
            'placeholder' => 'Add a heading',
        ]],
        ['core/paragraph', [
            'content' => 'Overcome Fear, Phobias and Anxiety: Rapid Change Without Exposure or Years of Therapy',
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
    class="mpx-hero relative overflow-x-clip {{ $bgClass }} text-white bs-block"
    style="--mpx-hero-bg: {{ esc_attr($bgValue) }}"
>
    <div class="px-clamp">
        <div class="container mpx-hero__inner">
            <div class="mpx-hero__content {{ $paddingClasses }}">
                <div class="mpx-hero__content-inner">
                    <InnerBlocks
                        allowedBlocks="{!! esc_attr(wp_json_encode(['core/heading', 'core/paragraph', 'mpx/partial-button'])) !!}"
                        template="{!! esc_attr(wp_json_encode($template)) !!}"
                    />
                </div>
            </div>

            <div class="mpx-hero__media">
                @if ($hasHeroImage)
                    {!! wp_get_attachment_image($heroImage['ID'], 'full', false, [
                        'class' => 'mpx-hero__image',
                        'alt' => $heroImage['alt'] ?? '',
                        'loading' => 'eager',
                        'fetchpriority' => 'high',
                    ]) !!}
                @elseif (! empty($isEditor))
                    <div class="mpx-hero__placeholder">
                        {{ __('Select a hero image in the block sidebar.', 'sage') }}
                    </div>
                @endif

                @if ($showOverlay && ($hasHeroImage || ! empty($isEditor)))
                    <div class="mpx-hero__overlay" aria-hidden="true"></div>
                @endif
            </div>
        </div>
    </div>
</section>
