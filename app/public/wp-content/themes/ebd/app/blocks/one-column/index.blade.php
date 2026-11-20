@php
    $sectionPadding = $a['section_padding'] ?? ['py-clamp'];
    if (! is_array($sectionPadding)) {
        $sectionPadding = [$sectionPadding];
    }
    $paddingClasses = implode(' ', array_filter($sectionPadding));

    $useGradient = (bool) ($a['use_gradient_bg'] ?? false);
    $bgClass = $useGradient ? '' : ($a['bg_colour']['slug'] ?? 'bg-white');

    $useBackgroundImage = ! $useGradient && (bool) ($a['use_background_image'] ?? false);
    $backgroundImage = $a['background_image'] ?? null;
    $hasBackgroundImage = $useBackgroundImage && ! empty($backgroundImage['ID']);

    $limitWidth = (bool) ($a['limit_width'] ?? false);
    $enableContentPosition = (bool) ($a['enable_content_position'] ?? false);
    $positionClass = null;
    if ($enableContentPosition) {
        $positionClass = match ($a['content_position'] ?? 'left') {
            'center' => 'content-pos-center',
            'right' => 'content-pos-right',
            default => 'content-pos-left',
        };
    }
    $contentClasses = trim(implode(' ', array_filter([
        'container relative',
        $limitWidth ? 'mw-1000' : null,
        $positionClass,
    ])));

    $allowedBlocks = [
        'core/heading',
        'core/paragraph',
        'core/list',
        'core/image',
        'core/video',
        'core/embed',
        'mpx/partial-button',
        'mpx/partial-subheading',
        'mpx/partial-cards',
        'mpx/partial-featured-posts',
        'mpx/partial-checklist',
        'rank-math/faq-block',
        'fluentfom/guten-block',
    ];

    $template = [
        ['core/heading', [
            'level' => 2,
            'placeholder' => 'Add a heading',
        ]],
        ['core/paragraph', [
            'placeholder' => 'Add supporting text',
        ]],
    ];

    $anchorId = $a['anchor'] ?? $b['anchor'] ?? '';

    $sectionClasses = trim(implode(' ', array_filter([
        'relative overflow-hidden px-clamp bs-block mpx-one-column-section',
        $useGradient ? 'mpx-columns-section--gradient' : null,
        $bgClass,
        $paddingClasses,
    ])));
@endphp

<section
    useBlockProps
    @if ($anchorId !== '') id="{{ $anchorId }}" @endif
    class="{{ $sectionClasses }}"
>
    @if ($hasBackgroundImage)
        {!! wp_get_attachment_image($backgroundImage['ID'], 'full', false, [
            'class' => 'pointer-events-none absolute inset-0 h-full w-full object-cover',
            'alt' => $backgroundImage['alt'] ?? '',
            'loading' => 'lazy',
        ]) !!}

        <div class="absolute inset-0 hero-overlay"></div>
    @endif

    <div class="{{ $contentClasses }}">
        <InnerBlocks
            allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
            template="{!! esc_attr(wp_json_encode($template)) !!}"
        />
    </div>
</section>
