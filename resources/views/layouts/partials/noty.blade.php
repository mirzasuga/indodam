@if(Session::has('flash_notification.message'))
@php
    $level = Session::get('flash_notification.level');
    if ($level == 'info') {
        $level = 'information';
    }
@endphp
<script src="{{ asset('js/noty.js') }}"></script>
<script>
    noty({
        type: '{{ $level }}',
        layout: 'bottomRight',
        text: '{{ Session::get('flash_notification.message') }}',
        timeout: 4000
    });
</script>
@endif
