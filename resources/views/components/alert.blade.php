<div class="alert alert-{{$type or 'info'}}" role="alert">
    @if (isset($icon) && $icon)
        <i class="fa fa-{{$icon}}"></i>&nbsp;
    @endif
    {{ $slot }}
</div>