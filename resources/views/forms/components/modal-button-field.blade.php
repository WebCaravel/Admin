<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <x-caravel-admin::modal :id="$getModalId()">
        <x-slot name="trigger">
            {{--        <x-caravel-admin::button :color="!empty($btnColor) ? $btnColor : ''" x-on:click="open = true">{{ __("Delete") }}</x-caravel-admin::button>--}}
            <x-caravel-admin::button x-on:click="open = true">{{ __($getLabel()) }}</x-caravel-admin::button>
        </x-slot>

        <x-slot name="title">{{ $getTitle() }}</x-slot>

        <x-slot name="body">
            @livewire($getLivewireName(), [
                "parentRecord" => $getRecord(),
                "modalId" => $getModalId()
            ])
        </x-slot>
    </x-caravel-admin::modal>
</x-forms::field-wrapper>
