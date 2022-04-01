<x-caravel-admin::modal :id="$getModalId()">
    <x-slot name="trigger">
        @include("caravel-admin::forms.components.button-field")
    </x-slot>

    <x-slot name="title">{{ $getTitle() }}</x-slot>

    <x-slot name="body">
        @livewire($getLivewireName(), [
            "parentRecord" => $getRecord(),
            "modalId" => $getModalId()
        ])
    </x-slot>
</x-caravel-admin::modal>
