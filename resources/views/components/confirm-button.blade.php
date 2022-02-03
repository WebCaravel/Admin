<x-caravel-admin::modal id="confirm-delete">
    <x-slot name="trigger">
        <x-caravel-admin::button :color="!empty($btnColor) ? $btnColor : ''" :href="$this->resource->getRoute('index')" x-on:click="open = true">{{ __("Delete") }}</x-caravel-admin::button>
    </x-slot>

    <x-slot name="title">{{ $title ?? __('Confirm') }}</x-slot>

    <x-slot name="body">
        {{ $body ?? __('Are you sure, that you want to run this action?') }}
    </x-slot>

    <x-slot name="actions">
        <x-caravel-admin::button x-on:click="open = false">{{ __("Cancel") }}</x-caravel-admin::button>
        <x-caravel-admin::button x-on:click="open = false; {{ $action }}" class="w-24" :color="isset($btnColor) ? $btnColor : 'success'">{{ __("Ok") }}</x-caravel-admin::button>
    </x-slot>
</x-caravel-admin::modal>
