@props([
    'label' => 'Image goes here',
    'alt' => null,
])

<div
  @if ($alt) role="img" aria-label="{{ $alt }}" @endif
  {{ $attributes->merge(['class' => 'flex items-center justify-center border border-dashed border-line-strong bg-gray px-3 text-center text-sm leading-tight text-muted']) }}
>
  {{ $label }}
</div>
