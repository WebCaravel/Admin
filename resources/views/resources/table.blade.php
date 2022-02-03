<div>
    <div class="text-right mb-4">
        @if($createRoute && auth()->user()->can("create", $resource->model()))
            <x-app-ui::button :href="$createRoute" tag="a">{{ __("Hinzufügen") }}</x-app-ui::button>
        @endif
    </div>

    {{ $this->table }}

    <x-caravel-admin::spinner wire:loading.delay.longer />
</div>
