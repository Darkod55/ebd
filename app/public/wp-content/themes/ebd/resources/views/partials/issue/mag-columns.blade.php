<div class="mag-cols" style="--mag-cols: {{ count($columns) }}">
  @foreach ($columns as $column)
    <div class="mag-col">
      @include('partials.issue.mag-blocks', ['blocks' => $column])
    </div>
  @endforeach
</div>
