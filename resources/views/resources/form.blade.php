<div>
    <form wire:submit.prevent="save">
        <div class="text-right mb-4">
            <x-delete-button :heading="__('Löschen der Immobilie bestätigen')" action="$wire.delete()" />
        </div>

        {{ $this->form }}

        <div class="mt-5 text-center">
            <x-app-ui::button tag="a" color="secondary" :href="$this->resource->getRoute('index')">{{ __("Zurück") }}</x-app-ui::button>
            <x-app-ui::button type="submit">{{ __("Speichern") }}</x-app-ui::button>
        </div>
    </form>

    <x-spinner wire:loading.delay.long />
</div>

