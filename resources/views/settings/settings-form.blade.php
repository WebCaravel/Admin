<div>
    {{ $this->form }}

    <div class="flex flex-wrap justify-center gap-4 mt-5">
        <x-caravel-admin::button color="primary" wire:click="save">{{ __("Save") }}</x-caravel-admin::button>
    </div>

    <x-caravel-admin::spinner wire:loading.delay.long />
</div>

