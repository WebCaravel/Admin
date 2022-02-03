<div>
    @if($this->recordExists() && $this->user->can("delete", $this->model))
        <div class="flex flex-wrap justify-end gap-4 mb-4">
            <x-caravel-admin::delete-button action="$wire.delete()" />
        </div>
    @endif

    <form wire:submit.prevent="save">
        {{ $this->form }}

        <div class="flex flex-wrap justify-center gap-4 mt-5">
            <x-caravel-admin::button color="secondary" tag="a" :href="$this->resource->getRoute('index')">{{ __("Cancel") }}</x-caravel-admin::button>
            @if($showSaveButton)
                <x-caravel-admin::button color="primary" type="submit">{{ __("Save") }}</x-caravel-admin::button>
            @endif
        </div>
    </form>

    <x-caravel-admin::spinner wire:loading.delay.long />
</div>

