<div>
    <div class="flex flex-wrap justify-end gap-4 mb-4">
        <x-caravel-admin::delete-button action="$wire.delete()" />
    </div>

    <form wire:submit.prevent="save">
        {{ $this->form }}

        <div class="flex flex-wrap justify-center gap-4 mt-5">
            <x-caravel-admin::button color="secondary" tag="a" :href="$this->resource->getRoute('index')">{{ __("Cancel") }}</x-caravel-admin::button>
            <x-caravel-admin::button color="primary" type="submit">{{ __("Save") }}</x-caravel-admin::button>
        </div>
    </form>

    <x-caravel-admin::spinner wire:loading.delay.long />
</div>

