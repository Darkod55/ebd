@php
    $parent = $c['mpx/partial-cards'] ?? [];
    $parentGrid = ($parent && function_exists('bs_get_group'))
        ? bs_get_group($parent, 'grid_controls')
        : [];
    $widthStyle = \App\helpers()->resolveGridItemWidthStyle($a, $parentGrid);

    $horizontal = (bool) ($a['horizontal_layout'] ?? false);
    $cardClass = 'mpx-card mpx-card--icon' . ($horizontal ? ' is-horizontal' : '');

    $allowedBlocks = ['mpx/partial-icon', 'core/heading', 'core/paragraph', 'mpx/partial-button'];
    $template = [
        ['mpx/partial-icon', [
            'icon' => 'globe',
        ]],
        ['core/heading', [
            'level' => 3,
            'placeholder' => 'Add a heading',
        ]],
        ['core/paragraph', [
            'placeholder' => 'Add supporting text',
        ]],
    ];
@endphp

<div
    useBlockProps
    class="{{ $cardClass }}"
    @if ($widthStyle !== '')
        style="{!! esc_attr($widthStyle) !!}"
    @endif
>
    <InnerBlocks
        allowedBlocks="{!! esc_attr(wp_json_encode($allowedBlocks)) !!}"
        template="{!! esc_attr(wp_json_encode($template)) !!}"
    />
</div>
