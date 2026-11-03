<div id="flash" {{ $attributes->merge(['class' => 'w-full']) }}>
    @if ($message = Session::get('success'))
        @include('components.flash-message', ['type' => "success", 'message' => $message])
    @endif
    @if ($message = Session::get('error'))
        @include('components.flash-message', ['type' => "danger", 'message' => $message])
    @endif
    @if ($message = Session::get('warning'))
        @include('components.flash-message', ['type' => "warning", 'message' => $message])
    @endif
    @if ($message = Session::get('info'))
        @include('components.flash-message', ['type' => "info", 'message' => $message])
    @endif
</div>