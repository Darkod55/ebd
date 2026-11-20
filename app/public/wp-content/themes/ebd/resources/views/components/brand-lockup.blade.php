@props([
    'tone' => 'dark',
    'wordClass' => 'font-heading text-[19px] font-bold leading-tight',
])

@php
  $toneClass = $tone === 'light' ? 'text-white' : 'text-secondary';
  $logo = \App\helpers()->getSiteLogo([
      'link_classes' => 'inline-flex items-center gap-3 no-underline ' . $toneClass,
      'custom_logo_class' => 'site-logo shrink-0',
      'logo_variant' => $tone === 'light' ? 'alt' : 'default',
  ]);

  if (str_contains($logo, 'site-logo')) {
      $word = '<span class="' . esc_attr($wordClass) . '">Елита Консалтинг</span>';
      $logo = preg_replace('#</a>\s*$#', $word . '</a>', $logo, 1);
  }
@endphp

{!! $logo !!}
