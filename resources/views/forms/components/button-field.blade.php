<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    @if($isConfirmationRequired())
        <x-app-ui::modal x-show="openModal" x-cloak>
            <x-slot name="trigger">
                <x-app-ui::button type="button" color="{{ $getColor() }}" x-on:click="open = true">
                    {{ $getButtonLabel() }}
                </x-app-ui::button>
            </x-slot>

            <x-slot name="heading">
                {{ $getHeading() ?: __("Confirm action") }}
            </x-slot>

            <x-slot name="subheading">
                {!! $getSubHeading() !!}
            </x-slot>

            <x-slot name="footer">
                <x-app-ui::modal.actions full-width>
                    <x-app-ui::button x-on:click="open = false" color="secondary">
                        {{ __("Abbrechen") }}
                    </x-app-ui::button>

                    <x-app-ui::button color="{{ $getColor() }}" wire:click="{{ $getAction() }}()">
                        {{ $getButtonLabel() }}
                    </x-app-ui::button>
                </x-app-ui::modal.actions>
            </x-slot>
        </x-app-ui::modal>
    @else
        <x-app-ui::button type="button" color="{{ $getColor() }}" wire:click="{{ $getAction() }}()">
            {{ $getLabel() }}
        </x-app-ui::button>
    @endif
</x-forms::field-wrapper>
