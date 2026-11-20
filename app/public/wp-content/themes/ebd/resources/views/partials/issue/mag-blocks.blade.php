@foreach ($blocks as $block)
  @if (($block['type'] ?? 'p') === 'h2')
    <h2>{{ $block['text'] }}</h2>
  @elseif ($block['type'] === 'h3')
    <h3>{{ $block['text'] }}</h3>
  @elseif ($block['type'] === 'quote')
    <blockquote><p>{{ $block['text'] }}</p></blockquote>
  @else
    <p @class(['mag-drop' => ! empty($block['drop'])])>{{ $block['text'] }}</p>
  @endif
@endforeach
