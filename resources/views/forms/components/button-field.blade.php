<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :state-path="$getStatePath()"
>
    <div {{ $attributes->merge($getExtraAttributes())->class('filament-forms-placeholder-component') }}>
        <x-caravel-admin::button
            x-on:click="{{ $getOnClickJs() }}"
            tag="a"
            :size="$getSize()"
            :href="$getHref()"
            :color="$getColor()"
            :target="$isTargetBlank() ? '_blank': ''">
            {{ $getButtonLabel() }}
        </x-caravel-admin::button>
    </div>
</x-forms::field-wrapper>
