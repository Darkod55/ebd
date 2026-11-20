{{--
  Text lockup. variant="light" is white, for dark or photographic grounds.
  variant="dark" is ink, for paper. Colour is currentColor, so a parent can restyle it.
--}}
@props([
    'variant' => 'dark',
])

<p {{ $attributes->class(['ebd-logo', 'ebd-logo--'.$variant]) }} role="img" aria-label="Ethical Brand Directory">
  <span class="ebd-logo__name">Ethical Brand</span>
  <span class="ebd-logo__box">Directory</span>
</p>
