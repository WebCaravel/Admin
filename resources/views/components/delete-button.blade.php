@php($default = [
    "btnColor" => "danger"
])
<x-caravel-admin::confirm-button {{ $attributes->merge($default) }}>
    {{ __("Delete") }}

    <x-slot name="title">
        {{ $title ?? __('Delete') }}
    </x-slot>

    <x-slot name="body">
        {{ $body ?? __('Are you sure, that you want to delete this item?') }}
    </x-slot>
</x-caravel-admin::confirm-button>
