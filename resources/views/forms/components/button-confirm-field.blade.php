<x-caravel-admin::modal :id="$getModalId()">
    <x-slot name="trigger">
        @include("caravel-admin::forms.components.button-field")
    </x-slot>

    <x-slot name="title">{{ $getTitle() }}</x-slot>

    <x-slot name="body">
        {!! $getBody() !!}

        <div class="px-4 pt-5">
            <div class="flex flex-wrap justify-center gap-4">
                <x-caravel-admin::button x-on:click.prevent="open = false">{{ __("Cancel") }}</x-caravel-admin::button>
                <x-caravel-admin::button x-on:click.prevent="{{ $getConfirmAction() }}" :color="$getOkColor()">{{ $getOkLabel() }}</x-caravel-admin::button>
            </div>
        </div>
    </x-slot>
</x-caravel-admin::modal>
