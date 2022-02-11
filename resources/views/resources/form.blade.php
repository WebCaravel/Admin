<div>
    <div class="flex flex-wrap justify-end gap-4 mb-4">
        @if($this->recordExists() && $this->user->can("delete", $this->model))
            <x-caravel-admin::delete-button action="$wire.delete()" />
        @endif
        @if($this->recordExists() && !$this->isEditable() && $this->user->can("update", $this->model))
            <x-caravel-admin::button tag="a" color="primary" :href="$this->resource->getRoute('edit', $this->model)">
                {{ __("Edit") }}
            </x-caravel-admin::button>
        @endif
    </div>

    {{ $this->form }}

    <div class="flex flex-wrap justify-center gap-4 mt-5">
        <x-caravel-admin::button color="secondary" tag="a" :href="$this->resource->getRoute('index')">
            {{ $showSaveButton ? __("Cancel") : __("Back") }}
        </x-caravel-admin::button>
        @if($showSaveButton)
            @if(!$this->model->exists)
                <x-caravel-admin::button color="primary" wire:click="save(true)">{{ __("Create & new") }}</x-caravel-admin::button>
            @endif
            <x-caravel-admin::button color="primary" wire:click="save()">{{ $this->model->exists ? __("Save") : __("Create") }}</x-caravel-admin::button>
        @endif
    </div>

    <x-caravel-admin::spinner wire:loading.delay.long />
</div>

