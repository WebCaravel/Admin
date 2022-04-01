<form wire:submit.prevent="submit">
    {{ $this->form }}

    <hr>

    <div class="px-4 py-2">
        <div class="flex flex-wrap justify-center gap-4">
            <x-caravel-admin::button x-on:click.prevent="open = false">{{ __("Cancel") }}</x-caravel-admin::button>
            <x-caravel-admin::button wire:click.prevent="submit" class="w-24" :color="isset($btnColor) ? $btnColor : 'primary'">{{ __("Ok") }}</x-caravel-admin::button>
        </div>
    </div>
</form>
