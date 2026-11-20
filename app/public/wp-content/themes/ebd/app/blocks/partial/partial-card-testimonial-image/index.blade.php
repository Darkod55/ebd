@php
    $parent = $c['mpx/partial-cards'] ?? [];
    $parentGrid = ($parent && function_exists('bs_get_group'))
        ? bs_get_group($parent, 'grid_controls')
        : [];
    $widthStyle = \App\helpers()->resolveGridItemWidthStyle($a, $parentGrid);

    $allowedBlocks = ['core/image'];
    $template = [
        ['core/image', []],
    ];
@endphp

<div
    useBlockProps
    class="mpx-card mpx-card--testimonial-image"
    @if ($widthStyle !== '')
        style="{!! esc_attr($widthStyle) !!}"
    @endif
>
    <InnerBlocks
        allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
        template="{!! esc_attr(wp_json_encode($template)) !!}"
        templateLock="insert"
    />
</div>
