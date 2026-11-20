@php
    $parent = $c['mpx/partial-cards'] ?? [];
    $parentGrid = ($parent && function_exists('bs_get_group'))
        ? bs_get_group($parent, 'grid_controls')
        : [];
    $widthStyle = \App\helpers()->resolveGridItemWidthStyle($a, $parentGrid);

    $allowedBlocks = ['core/paragraph', 'core/heading'];
    $template = [
        ['core/paragraph', [
            'placeholder' => 'Add the testimonial quote…',
        ]],
        ['core/heading', [
            'level' => 4,
            'placeholder' => 'Name',
        ]],
        ['core/paragraph', [
            'placeholder' => 'Company (optional)',
            'className' => 'mpx-card__company',
        ]],
    ];
@endphp

<div
    useBlockProps
    class="mpx-card mpx-card--testimonial-simple"
    @if ($widthStyle !== '')
        style="{!! esc_attr($widthStyle) !!}"
    @endif
>
    <span class="mpx-card__quote-mark" aria-hidden="true">
        {!! \App\helpers()->getSvg(['icon' => 'quote', 'width' => 32, 'title' => '']) !!}
    </span>
    <div class="mpx-card__body">
        <InnerBlocks
            allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
            template="{!! esc_attr(wp_json_encode($template)) !!}"
        />
    </div>
</div>
