@props(['on'])

<div x-data="{ shown: false, timeout: null }"
     x-init="@this.on('{{ $on }}', (data) => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 3000); })"
     x-show.transition.out.opacity.duration.300ms="shown"
     x-transition:leave.opacity.duration.300ms
     style="display: none;"
    {{ $attributes->merge(['class' => 'text-sm text-white']) }}>
    {{ $slot->isEmpty() ? (isset($message) ? $message : 'Operación realizada correctamente.') : $slot }}
</div>
